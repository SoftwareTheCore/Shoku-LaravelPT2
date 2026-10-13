<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminKaryawanStatusTest extends TestCase
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

    public function test_admin_can_deactivate_and_reactivate_employee_from_employee_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employee = User::factory()->create([
            'name' => 'Karyawan Uji',
            'role' => 'karyawan',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.karyawan.index'))
            ->assertOk()
            ->assertSee('Nonaktifkan');

        $this->patch(route('admin.karyawan.status', $employee), [
            'is_active' => 0,
        ])
            ->assertRedirect(route('admin.karyawan.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'is_active' => false,
        ]);

        $this->get(route('admin.karyawan.index'))
            ->assertOk()
            ->assertSee('Aktifkan');

        $this->patch(route('admin.karyawan.status', $employee), [
            'is_active' => 1,
        ])
            ->assertRedirect(route('admin.karyawan.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'is_active' => true,
        ]);
    }
}
