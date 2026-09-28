<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RestaurantTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('table')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'customer.reservations.index',
            compact('reservations')
        );
    }

    public function create()
    {
        $tables = RestaurantTable::whereIn('status', [
            'available',
            'reserved',
        ])
            ->orderBy('table_number')
            ->get();

        return view(
            'customer.reservations.create',
            compact('tables')
        );
    }

    public function availability(Request $request)
    {
        $validated = $request->validate([
            'reservation_date' => ['required', 'date'],
            'reservation_time' => ['required', 'date_format:H:i'],
        ]);

        $unavailableTableIds = $this->overlappingReservations(
            $validated['reservation_date'],
            $validated['reservation_time']
        )
            ->pluck('restaurant_table_id')
            ->unique()
            ->values();

        return response()->json([
            'unavailable_table_ids' => $unavailableTableIds,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_table_id' => [
                'required',
                'exists:restaurant_tables,id',
            ],
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'reservation_time' => [
                'required',
                'date_format:H:i',
            ],
            'guest_count' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'restaurant_table_id.required' => 'Meja wajib dipilih.',
            'restaurant_table_id.exists' => 'Meja tidak ditemukan.',
            'reservation_date.required' => 'Tanggal reservasi wajib diisi.',
            'reservation_date.after_or_equal' => 'Tanggal reservasi tidak boleh sebelum hari ini.',
            'reservation_time.required' => 'Jam reservasi wajib diisi.',
            'guest_count.required' => 'Jumlah orang wajib diisi.',
            'guest_count.min' => 'Minimal 1 orang.',
            'guest_count.max' => 'Maksimal 50 orang.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $error = DB::transaction(function () use ($validated) {
            $table = RestaurantTable::whereKey(
                $validated['restaurant_table_id']
            )
                ->lockForUpdate()
                ->first();

            if (!$table || !in_array($table->status, [
                'available',
                'reserved',
            ], true)) {
                return 'Meja tersebut sedang tidak tersedia.';
            }

            if ($validated['guest_count'] > $table->capacity) {
                return 'Jumlah tamu melebihi kapasitas meja.';
            }

            if ($this->overlappingReservations(
                $validated['reservation_date'],
                $validated['reservation_time'],
                $table->id
            )->isNotEmpty()) {
                return 'Meja tersebut sudah dipesan pada waktu yang berdekatan.';
            }

            Reservation::create([
                'user_id' => Auth::id(),
                'restaurant_table_id' => $table->id,
                'reservation_date' => $validated['reservation_date'],
                'reservation_time' => $validated['reservation_time'],
                'guest_count' => $validated['guest_count'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            return null;
        });

        if ($error !== null) {
            return back()
                ->withInput()
                ->with('error', $error);
        }

        return redirect()
            ->route('customer.reservations.index')
            ->with(
                'success',
                'Reservasi berhasil dibuat dan menunggu konfirmasi.'
            );
    }

    private function overlappingReservations(
        string $date,
        string $time,
        ?int $tableId = null
    ) {
        $requestedStart = Carbon::parse("{$date} {$time}");

        return Reservation::query()
            ->whereDate(
                'reservation_date',
                '>=',
                $requestedStart->copy()->subHour()->toDateString()
            )
            ->whereDate(
                'reservation_date',
                '<=',
                $requestedStart->copy()->addHour()->toDateString()
            )
            ->whereIn('status', [
                'pending',
                'confirmed',
                'checked_in',
            ])
            ->when($tableId !== null, function ($query) use ($tableId) {
                $query->where('restaurant_table_id', $tableId);
            })
            ->get([
                'restaurant_table_id',
                'reservation_date',
                'reservation_time',
            ])
            ->filter(function ($reservation) use ($requestedStart) {
                $bookedStart = Carbon::parse(
                    $reservation->reservation_date->format('Y-m-d') .
                    ' ' . $reservation->reservation_time
                );

                return $bookedStart->lt($requestedStart->copy()->addHour()) &&
                    $bookedStart->copy()->addHour()->gt($requestedStart);
            });
    }

    public function show(Reservation $reservation)
    {
        abort_unless(
            $reservation->user_id === Auth::id(),
            403
        );

        $reservation->load('table');

        return view(
            'customer.reservations.show',
            compact('reservation')
        );
    }

    public function destroy(Reservation $reservation)
    {
        abort_unless(
            $reservation->user_id === Auth::id(),
            403
        );

        if (!in_array($reservation->status, [
            'pending',
            'confirmed',
        ])) {
            return back()->with(
                'error',
                'Reservasi ini tidak dapat dibatalkan.'
            );
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('customer.reservations.index')
            ->with(
                'success',
                'Reservasi berhasil dibatalkan.'
            );
    }
}