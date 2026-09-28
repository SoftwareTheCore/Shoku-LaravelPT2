<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\RestaurantTable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerReservationAvailabilityTest extends TestCase
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

    public function test_customer_can_book_reserved_table_one_hour_after_existing_reservation(): void
    {
        $firstCustomer = User::factory()->create(['role' => 'customer']);
        $nextCustomer = User::factory()->create(['role' => 'customer']);
        $table = RestaurantTable::create([
            'table_number' => 'M-001',
            'capacity' => 4,
            'status' => 'reserved',
        ]);
        $date = now()->addDay()->toDateString();

        Reservation::create([
            'user_id' => $firstCustomer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => $date,
            'reservation_time' => '10:10',
            'guest_count' => 2,
            'status' => 'confirmed',
        ]);

        $this->actingAs($nextCustomer)
            ->post(route('customer.reservations.store'), [
                'restaurant_table_id' => $table->id,
                'reservation_date' => $date,
                'reservation_time' => '11:10',
                'guest_count' => 2,
            ])
            ->assertRedirect(route('customer.reservations.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('reservations', [
            'user_id' => $nextCustomer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => $date . ' 00:00:00',
            'status' => 'pending',
        ]);
    }

    public function test_customer_cannot_book_reserved_table_during_existing_reservation(): void
    {
        $firstCustomer = User::factory()->create(['role' => 'customer']);
        $nextCustomer = User::factory()->create(['role' => 'customer']);
        $table = RestaurantTable::create([
            'table_number' => 'M-002',
            'capacity' => 4,
            'status' => 'reserved',
        ]);
        $date = now()->addDay()->toDateString();

        Reservation::create([
            'user_id' => $firstCustomer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => $date,
            'reservation_time' => '10:10',
            'guest_count' => 2,
            'status' => 'confirmed',
        ]);

        $this->actingAs($nextCustomer)
            ->from(route('customer.reservations.create'))
            ->post(route('customer.reservations.store'), [
                'restaurant_table_id' => $table->id,
                'reservation_date' => $date,
                'reservation_time' => '10:30',
                'guest_count' => 2,
            ])
            ->assertRedirect()
            ->assertSessionHas(
                'error',
                'Meja tersebut sudah dipesan pada waktu yang berdekatan.'
            );

        $this->assertDatabaseMissing('reservations', [
            'user_id' => $nextCustomer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => $date . ' 00:00:00',
        ]);
    }
}
