<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            $user
            && $user->role === 'karyawan'
            && !$user->is_active
            && Hash::check($credentials['password'], $user->password)
        ) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Akun karyawan ini sudah nonaktif. Silakan hubungi Admin.');
        }

        if (!Auth::attempt($credentials + ['is_active' => true], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin' => redirect()
                ->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!'),

            'karyawan' => redirect()
                ->route('karyawan.dashboard')
                ->with('success', 'Selamat datang, Karyawan!'),

            'customer' => redirect()
                ->route('customer.dashboard')
                ->with('success', 'Selamat datang di Shque!'),

            default => tap(Auth::logout(), function () use ($request) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }) ? redirect()
                ->route('login')
                ->with('error', 'Role akun tidak valid.') : redirect()->route('login'),
        };
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Registrasi berhasil. Selamat datang di Shque!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}