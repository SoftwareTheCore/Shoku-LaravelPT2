<?php

namespace Tests\Feature;

use App\Models\RestaurantTable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RestaurantTableManagementTest extends TestCase
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

    public function test_admin_can_create_table_without_submitting_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.meja.store'), [
                'table_number' => 'M-101',
                'capacity' => 4,
            ])
            ->assertRedirect(route('admin.meja.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('restaurant_tables', [
            'table_number' => 'M-101',
            'capacity' => 4,
            'status' => 'available',
        ]);
    }

    public function test_admin_can_edit_table_without_changing_its_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $table = RestaurantTable::create([
            'table_number' => 'M-102',
            'capacity' => 4,
            'status' => 'reserved',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.meja.update', $table), [
                'table_number' => 'M-102',
                'capacity' => 6,
            ])
            ->assertRedirect(route('admin.meja.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('restaurant_tables', [
            'id' => $table->id,
            'table_number' => 'M-102',
            'capacity' => 6,
            'status' => 'reserved',
        ]);
    }

    public function test_admin_workspace_brand_links_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $table = RestaurantTable::create([
            'table_number' => 'M-103',
            'capacity' => 4,
            'status' => 'available',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.meja.edit', $table))
            ->assertOk()
            ->assertSee('href="' . route('admin.dashboard') . '"', false)
            ->assertDontSee('href="' . route('home') . '"', false);
    }
}