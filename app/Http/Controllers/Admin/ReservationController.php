<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'table'])
            ->oldest()
            ->paginate(15);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function markTableReserved(Reservation $reservation)
    {
        $tableNumber = DB::transaction(function () use ($reservation) {
            $lockedReservation = Reservation::query()
                ->lockForUpdate()
                ->findOrFail($reservation->id);

            if ($lockedReservation->status !== 'pending') {
                return null;
            }

            $table = $lockedReservation->table()
                ->lockForUpdate()
                ->firstOrFail();

            $table->update(['status' => 'reserved']);
            $lockedReservation->update(['status' => 'confirmed']);

            return $table->table_number;
        });

        if ($tableNumber === null) {
            return back()->with(
                'error',
                'Reservasi ini sudah diproses dan tidak lagi berstatus pending.'
            );
        }

        return redirect()
            ->route('admin.reservations.index')
            ->with(
                'success',
                "Reservasi dikonfirmasi dan meja {$tableNumber} diubah menjadi reserved."
            );
    }
}