<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\RestaurantTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerOrderTest extends TestCase
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

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_customer_can_place_multi_item_order_for_their_reservation(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $reservation = $this->createReservation($customer);
        [$firstMenu, $secondMenu] = $this->createMenus();

        $this->actingAs($customer)
            ->get(route('customer.orders.create', [
                'menu' => $firstMenu->id,
                'reservation' => $reservation->id,
            ]))
            ->assertOk()
            ->assertSee('Buat Order')
            ->assertSee('Salmon Roll')
            ->assertSee('M-001');

        $this->actingAs($customer)
            ->post(route('customer.orders.store'), [
                'reservation_id' => $reservation->id,
                'items' => [
                    $firstMenu->id => 2,
                    $secondMenu->id => 1,
                ],
            ])
            ->assertRedirect(route('customer.orders.index'))
            ->assertSessionHas('success');

        $order = Order::with('items')->firstOrFail();
        $this->assertSame($customer->id, $order->user_id);
        $this->assertSame($reservation->id, $order->reservation_id);
        $this->assertSame('29000.00', $order->total_amount);
        $this->assertCount(2, $order->items);
        $this->assertDatabaseHas('menus', [
            'id' => $firstMenu->id,
            'stock' => 3,
        ]);
        $this->assertDatabaseHas('menus', [
            'id' => $secondMenu->id,
            'stock' => 4,
        ]);

        $this->actingAs($customer)
            ->get(route('customer.orders.index'))
            ->assertOk()
            ->assertSee('Order Saya')
            ->assertSee('Salmon Roll')
            ->assertSee('M-001');

        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($otherCustomer)
            ->get(route('customer.orders.index'))
            ->assertOk()
            ->assertSee('Anda belum memiliki order.')
            ->assertDontSee('Salmon Roll');
    }

    public function test_customer_cannot_order_for_another_customers_reservation(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $anotherCustomer = User::factory()->create(['role' => 'customer']);
        $reservation = $this->createReservation($anotherCustomer);
        [$menu] = $this->createMenus();

        $this->actingAs($customer)
            ->from(route('customer.orders.create'))
            ->post(route('customer.orders.store'), [
                'reservation_id' => $reservation->id,
                'items' => [$menu->id => 1],
            ])
            ->assertRedirect(route('customer.orders.create'))
            ->assertSessionHasErrors('reservation_id');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'stock' => 5,
        ]);
    }

    public function test_order_rejects_insufficient_stock_without_creating_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $reservation = $this->createReservation($customer);
        [$menu] = $this->createMenus();

        $this->actingAs($customer)
            ->from(route('customer.orders.create'))
            ->post(route('customer.orders.store'), [
                'reservation_id' => $reservation->id,
                'items' => [$menu->id => 6],
            ])
            ->assertRedirect(route('customer.orders.create'))
            ->assertSessionHasErrors('items');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'stock' => 5,
        ]);
    }

    public function test_admin_can_see_orders_from_all_customers(): void
    {
        $firstCustomer = User::factory()->create(['role' => 'customer']);
        $secondCustomer = User::factory()->create(['role' => 'customer']);
        $firstReservation = $this->createReservation($firstCustomer, 'M-001');
        $secondReservation = $this->createReservation($secondCustomer, 'M-002');
        [$menu] = $this->createMenus();

        foreach ([$firstCustomer, $secondCustomer] as $index => $customer) {
            $reservation = $index === 0 ? $firstReservation : $secondReservation;
            $order = $customer->orders()->create([
                'reservation_id' => $reservation->id,
                'total_amount' => 12000,
                'status' => 'pending',
            ]);
            $order->items()->create([
                'menu_id' => $menu->id,
                'menu_name' => $menu->name,
                'quantity' => 1,
                'unit_price' => $menu->price,
                'line_total' => $menu->price,
            ]);
        }

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Histori Order Customer')
            ->assertSee($firstCustomer->name)
            ->assertSee($secondCustomer->name)
            ->assertSee('M-001')
            ->assertSee('M-002');
    }

    public function test_admin_can_complete_order_with_customer_note_and_count_it_as_revenue(): void
    {
        Carbon::setTestNow('2026-10-06 12:00:00');
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $reservation = $this->createReservation($customer);
        [$menu] = $this->createMenus();
        $order = $customer->orders()->create([
            'reservation_id' => $reservation->id,
            'total_amount' => 12000,
            'status' => 'pending',
        ]);
        $order->items()->create([
            'menu_id' => $menu->id,
            'menu_name' => $menu->name,
            'quantity' => 1,
            'unit_price' => $menu->price,
            'line_total' => $menu->price,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.orders.complete', $order), [
                'admin_note' => 'Pesanan telah selesai dan siap diambil.',
            ])
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
            'admin_note' => 'Pesanan telah selesai dan siap diambil.',
            'completed_at' => '2026-10-06 12:00:00',
        ]);

        $this->get(route('admin.orders.index', [
            'period' => 'day',
            'date' => '2026-10-06',
        ]))
            ->assertOk()
            ->assertSee('Pemasukan')
            ->assertSee('Rp 12.000')
            ->assertSee('1 order');

        $this->actingAs($customer)
            ->get(route('customer.orders.index'))
            ->assertOk()
            ->assertSee('Pesanan telah selesai dan siap diambil.')
            ->assertSee('06/10/2026 12:00');

    }

    public function test_admin_revenue_can_be_filtered_by_day_week_and_month(): void
    {
        Carbon::setTestNow('2026-10-06 12:00:00');
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $menu = $this->createMenus()[0];

        foreach ([
            ['M-010', 12000, '2026-10-06 11:00:00'],
            ['M-011', 5000, '2026-10-05 11:00:00'],
            ['M-012', 7000, '2026-10-02 11:00:00'],
        ] as [$tableNumber, $amount, $completedAt]) {
            $reservation = $this->createReservation($customer, $tableNumber);
            $order = $customer->orders()->create([
                'reservation_id' => $reservation->id,
                'total_amount' => $amount,
                'status' => 'completed',
                'completed_at' => $completedAt,
            ]);
            $order->items()->create([
                'menu_id' => $menu->id,
                'menu_name' => $menu->name,
                'quantity' => 1,
                'unit_price' => $amount,
                'line_total' => $amount,
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.orders.index', [
                'period' => 'day',
                'date' => '2026-10-06',
            ]))
            ->assertOk()
            ->assertSee('Rp 12.000');

        $this->get(route('admin.orders.index', [
            'period' => 'week',
            'date' => '2026-10-06',
        ]))
            ->assertOk()
            ->assertSee('Rp 17.000');

        $this->get(route('admin.orders.index', [
            'period' => 'month',
            'date' => '2026-10-06',
        ]))
            ->assertOk()
            ->assertSee('Rp 24.000');

    }

    public function test_customer_cannot_complete_an_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $reservation = $this->createReservation($customer);
        $order = $customer->orders()->create([
            'reservation_id' => $reservation->id,
            'total_amount' => 12000,
            'status' => 'pending',
        ]);

        $this->actingAs($customer)
            ->patch(route('admin.orders.complete', $order), [
                'admin_note' => 'Selesai',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    private function createReservation(User $customer, string $tableNumber = 'M-001'): Reservation
    {
        $table = RestaurantTable::create([
            'table_number' => $tableNumber,
            'capacity' => 4,
            'status' => 'reserved',
        ]);

        return Reservation::create([
            'user_id' => $customer->id,
            'restaurant_table_id' => $table->id,
            'reservation_date' => now()->addDay()->toDateString(),
            'reservation_time' => '18:30',
            'guest_count' => 2,
            'status' => 'confirmed',
        ]);
    }

    private function createMenus(): array
    {
        $category = MenuCategory::create(['name' => 'Sushi']);

        return [
            Menu::create([
                'menu_category_id' => $category->id,
                'name' => 'Salmon Roll',
                'price' => 12000,
                'stock' => 5,
                'is_available' => true,
            ]),
            Menu::create([
                'menu_category_id' => $category->id,
                'name' => 'Tamago',
                'price' => 5000,
                'stock' => 5,
                'is_available' => true,
            ]),
        ];
    }
}
