<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan.
     */
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')
            ->oldest()
            ->paginate(10);

        $totalKaryawan = User::where('role', 'karyawan')->count();
        $karyawanAktif = User::where('role', 'karyawan')
            ->where('is_active', true)
            ->count();
        $karyawanNonaktif = $totalKaryawan - $karyawanAktif;

        return view('admin.karyawan.index', compact(
            'karyawans',
            'totalKaryawan',
            'karyawanAktif',
            'karyawanNonaktif'
        ));
    }

    /**
     * Menampilkan form tambah karyawan.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Menyimpan karyawan baru.
     */
    public function store(Request $request)
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
            'name.required' => 'Nama karyawan wajib diisi.',
            'name.max' => 'Nama karyawan maksimal 100 karakter.',
            'email.required' => 'Email karyawan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'karyawan',
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail karyawan.
     */
    public function show(User $karyawan)
    {
        if ($karyawan->role !== 'karyawan') {
            abort(404);
        }

        return view('admin.karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan form edit karyawan.
     */
    public function edit(User $karyawan)
    {
        if ($karyawan->role !== 'karyawan') {
            abort(404);
        }

        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Mengupdate data karyawan.
     */
    public function update(Request $request, User $karyawan)
    {
        if ($karyawan->role !== 'karyawan') {
            abort(404);
        }

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
                'unique:users,email,' . $karyawan->id,
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ], [
            'name.required' => 'Nama karyawan wajib diisi.',
            'name.max' => 'Nama karyawan maksimal 100 karakter.',
            'email.required' => 'Email karyawan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $karyawan->name = $validated['name'];
        $karyawan->email = $validated['email'];
        $karyawan->is_active = $validated['is_active'];

        if (!empty($validated['password'])) {
            $karyawan->password = Hash::make($validated['password']);
        }

        $karyawan->role = 'karyawan';

        $karyawan->save();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, User $karyawan)
    {
        if ($karyawan->role !== 'karyawan') {
            abort(404);
        }

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $karyawan->is_active = $validated['is_active'];
        $karyawan->save();

        $message = $karyawan->is_active
            ? 'Akun karyawan berhasil diaktifkan.'
            : 'Akun karyawan berhasil dinonaktifkan. Karyawan tidak dapat login.';

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', $message);
    }

    /**
     * Menghapus karyawan.
     */
    public function destroy(User $karyawan)
    {
        if ($karyawan->role !== 'karyawan') {
            abort(404);
        }

        $karyawan->delete();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}