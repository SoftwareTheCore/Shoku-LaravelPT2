<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\RestaurantTable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminReservationTableStatusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        $this->artisan('migrate:fresh');
    }

    public function test_admin_can_mark_pending_reservation_table_as_reserved(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $table = RestaurantTable::create([
            'table_number' => 'M-001',
            'capacity' => 4,
            'status' => 'reserved',
        ]);
        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => now()->addDay()->toDateString(),
            'reservation_time' => '18:30',
            'guest_count' => 2,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reservations.index'))
            ->assertOk()
            ->assertSee('Konfirmasi Reservasi');

        $this->patch(route('admin.reservations.table-status', $reservation))
            ->assertRedirect(route('admin.reservations.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('restaurant_tables', [
            'id' => $table->id,
            'status' => 'reserved',
        ]);
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
        ]);

        $this->actingAs($customer)
            ->get(route('customer.reservations.index'))
            ->assertOk()
            ->assertSee('Reserved');
    }

    public function test_admin_booking_history_includes_pending_and_confirmed_reservations(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $pendingTable = RestaurantTable::create([
            'table_number' => 'M-003',
            'capacity' => 4,
            'status' => 'available',
        ]);
        $reservedTable = RestaurantTable::create([
            'table_number' => 'M-004',
            'capacity' => 4,
            'status' => 'reserved',
        ]);

        Reservation::create([
            'user_id' => $customer->id,
            'restaurant_table_id' => $pendingTable->id,
            'reservation_date' => now()->addDay()->toDateString(),
            'reservation_time' => '18:30',
            'guest_count' => 2,
            'status' => 'pending',
        ]);
        Reservation::create([
            'user_id' => $customer->id,
            'restaurant_table_id' => $reservedTable->id,
            'reservation_date' => now()->addDays(2)->toDateString(),
            'reservation_time' => '19:00',
            'guest_count' => 2,
            'status' => 'confirmed',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reservations.index'))
            ->assertOk()
            ->assertSee('Histori Booking')
            ->assertSee('M-003')
            ->assertSee('M-004')
            ->assertSee('Pending')
            ->assertSee('Confirmed');
    }

    public function test_customer_cannot_mark_a_reservation_table_as_reserved(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $table = RestaurantTable::create([
            'table_number' => 'M-002',
            'capacity' => 4,
            'status' => 'available',
        ]);
        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => now()->addDay()->toDateString(),
            'reservation_time' => '19:00',
            'guest_count' => 2,
            'status' => 'pending',
        ]);

        $this->actingAs($customer)
            ->patch(route('admin.reservations.table-status', $reservation))
            ->assertForbidden();

        $this->assertDatabaseHas('restaurant_tables', [
            'id' => $table->id,
            'status' => 'available',
        ]);
    }
}