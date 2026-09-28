<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\RestaurantTableController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        AuthController::class,
        'showLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->name('login.process');


    Route::get('/register', [
        AuthController::class,
        'showRegister'
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register'
    ])->name('register.process');

});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [
    AuthController::class,
    'logout'
])
->middleware('auth')
->name('logout');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            DashboardController::class,
            'admin'
        ])->name('dashboard');

        Route::get('/reservations', [
            AdminReservationController::class,
            'index',
        ])->name('reservations.index');

        Route::patch('/reservations/{reservation}/table-status', [
            AdminReservationController::class,
            'markTableReserved',
        ])->name('reservations.table-status');

        Route::resource('menu-categories', MenuCategoryController::class);

        Route::resource('menus', AdminMenuController::class);

        Route::patch('karyawan/{karyawan}/status', [
            KaryawanController::class,
            'updateStatus',
        ])->name('karyawan.status');

        Route::resource('karyawan', KaryawanController::class);

        Route::resource('meja', RestaurantTableController::class);

    });


/*
|--------------------------------------------------------------------------
| Karyawan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/dashboard', [
            DashboardController::class,
            'karyawan'
        ])->name('dashboard');

    });


/*
|--------------------------------------------------------------------------
| Customer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [
            DashboardController::class,
            'customer'
        ])->name('dashboard');

        Route::get('/menu', [
            MenuController::class,
            'index'
        ])->name('menu.index');

        Route::get('/menu/{menu}', [
            MenuController::class,
            'show'
        ])->name('menu.show');

        Route::get('/reservations/availability', [
            ReservationController::class,
            'availability'
        ])->name('reservations.availability');

        Route::resource('reservations', ReservationController::class)->only([
            'index',
            'create',
            'store',
            'show',
            'destroy',
        ]);

    });