<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'period' => ['nullable', 'in:day,week,month'],
            'date' => ['nullable', 'date'],
        ]);
        $period = $filters['period'] ?? 'day';
        $date = Carbon::parse($filters['date'] ?? today()->toDateString());
        $start = $date->copy();
        $end = $date->copy();

        if ($period === 'week') {
            $start->startOfWeek(Carbon::MONDAY);
            $end->endOfWeek(Carbon::SUNDAY);
        } elseif ($period === 'month') {
            $start->startOfMonth();
            $end->endOfMonth();
        } else {
            $start->startOfDay();
            $end->endOfDay();
        }

        $completedOrders = Order::with(['user', 'reservation.table', 'items'])
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])
            ->oldest('completed_at')
            ->paginate(10, ['*'], 'completed_page')
            ->withQueryString();

        $revenue = Order::query()
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])
            ->selectRaw('COUNT(*) as order_count, COALESCE(SUM(total_amount), 0) as total_revenue')
            ->first();

        $orders = Order::with([
            'user',
            'reservation.table',
            'items',
        ])
            ->oldest()
            ->paginate(15, ['*'], 'history_page')
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'completedOrders' => $completedOrders,
            'period' => $period,
            'date' => $date->toDateString(),
            'periodLabel' => match ($period) {
                'week' => 'Minggu '.$start->format('d/m/Y').' – '.$end->format('d/m/Y'),
                'month' => $date->translatedFormat('F Y'),
                default => $date->format('d/m/Y'),
            },
            'orderCount' => (int) $revenue->order_count,
            'totalRevenue' => (float) $revenue->total_revenue,
        ]);
    }

    public function complete(Request $request, Order $order)
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ], [
            'admin_note.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        $completed = DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            if (! in_array($lockedOrder->status, ['pending', 'preparing'], true)) {
                return false;
            }

            $lockedOrder->update([
                'status' => 'completed',
                'admin_note' => $validated['admin_note'] ?? null,
                'completed_at' => now(),
            ]);

            return true;
        });

        if (! $completed) {
            throw ValidationException::withMessages([
                'order' => 'Order ini sudah diproses dan tidak dapat diselesaikan kembali.',
            ]);
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$order->id} selesai dan totalnya tercatat sebagai pemasukan.");
    }
}
