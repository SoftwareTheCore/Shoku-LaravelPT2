<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'reservation.table',
            'items',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $categories = MenuCategory::with([
            'menus' => function ($query) {
                $query->where('is_available', true)
                    ->where('stock', '>', 0)
                    ->orderBy('name');
            },
        ])->get()->filter(fn ($category) => $category->menus->isNotEmpty());

        $reservations = Reservation::with('table')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->whereDate('reservation_date', '>=', today())
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get();

        return view('customer.orders.create', [
            'categories' => $categories,
            'reservations' => $reservations,
            'selectedMenuId' => $request->integer('menu'),
            'selectedReservationId' => $request->integer('reservation'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => ['required', 'integer'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'integer', 'min:0', 'max:100'],
        ], [
            'reservation_id.required' => 'Reservasi wajib dipilih.',
            'items.required' => 'Pilih minimal satu menu.',
            'items.*.max' => 'Jumlah pesanan maksimal 100 untuk setiap menu.',
        ]);

        $quantities = collect($validated['items'])
            ->map(fn ($quantity) => (int) $quantity)
            ->filter(fn ($quantity) => $quantity > 0);

        if ($quantities->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu menu.',
            ]);
        }

        $order = DB::transaction(function () use ($validated, $quantities) {
            $reservation = Reservation::query()
                ->whereKey($validated['reservation_id'])
                ->where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                ->whereDate('reservation_date', '>=', today())
                ->first();

            if (! $reservation) {
                throw ValidationException::withMessages([
                    'reservation_id' => 'Pilih reservasi aktif milik Anda.',
                ]);
            }

            $menus = Menu::query()
                ->whereIn('id', $quantities->keys())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($menus->count() !== $quantities->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Satu atau beberapa menu tidak tersedia.',
                ]);
            }

            $totalAmount = 0.0;
            foreach ($quantities as $menuId => $quantity) {
                $menu = $menus->get($menuId);

                if (! $menu->is_available || $menu->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stok menu {$menu->name} tidak mencukupi.",
                    ]);
                }

                $totalAmount = round(
                    $totalAmount + round((float) $menu->price * $quantity, 2),
                    2
                );
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'reservation_id' => $reservation->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($quantities as $menuId => $quantity) {
                $menu = $menus->get($menuId);
                $lineTotal = round((float) $menu->price * $quantity, 2);

                $order->items()->create([
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'quantity' => $quantity,
                    'unit_price' => $menu->price,
                    'line_total' => $lineTotal,
                ]);

                $menu->decrement('stock', $quantity);
            }

            return $order;
        });

        return redirect()
            ->route('customer.orders.index')
            ->with('success', 'Order berhasil dibuat dan terhubung dengan reservasi Anda.');
    }
}
