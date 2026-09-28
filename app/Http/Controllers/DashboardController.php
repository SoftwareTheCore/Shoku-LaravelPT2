<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function karyawan()
    {
        return view('karyawan.dashboard');
    }

    public function customer()
    {
        return view('customer.dashboard');
    }
}