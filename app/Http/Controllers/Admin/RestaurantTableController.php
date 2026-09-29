<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    /**
     * Menampilkan semua meja.
     */
    public function index()
    {
        $tables = RestaurantTable::oldest()->paginate(10);

        return view('admin.meja.index', compact('tables'));
    }

    /**
     * Form tambah meja.
     */
    public function create()
    {
        return view('admin.meja.create');
    }

    /**
     * Menyimpan meja baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => [
                'required',
                'string',
                'max:20',
                'unique:restaurant_tables,table_number',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
        ], [
            'table_number.required' => 'Nomor meja wajib diisi.',
            'table_number.unique' => 'Nomor meja sudah digunakan.',
            'capacity.required' => 'Kapasitas meja wajib diisi.',
            'capacity.integer' => 'Kapasitas harus berupa angka.',
            'capacity.min' => 'Kapasitas minimal 1 orang.',
            'capacity.max' => 'Kapasitas maksimal 50 orang.',
        ]);

        RestaurantTable::create($validated + ['status' => 'available']);

        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Detail meja.
     */
    public function show(RestaurantTable $meja)
    {
        return view('admin.meja.show', compact('meja'));
    }

    /**
     * Form edit meja.
     */
    public function edit(RestaurantTable $meja)
    {
        return view('admin.meja.edit', compact('meja'));
    }

    /**
     * Update meja.
     */
    public function update(Request $request, RestaurantTable $meja)
    {
        $validated = $request->validate([
            'table_number' => [
                'required',
                'string',
                'max:20',
                'unique:restaurant_tables,table_number,' . $meja->id,
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
        ], [
            'table_number.required' => 'Nomor meja wajib diisi.',
            'table_number.unique' => 'Nomor meja sudah digunakan.',
            'capacity.required' => 'Kapasitas meja wajib diisi.',
            'capacity.integer' => 'Kapasitas harus berupa angka.',
            'capacity.min' => 'Kapasitas minimal 1 orang.',
            'capacity.max' => 'Kapasitas maksimal 50 orang.',
        ]);

        $meja->update($validated);

        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }

    /**
     * Hapus meja.
     */
    public function destroy(RestaurantTable $meja)
    {
        $meja->delete();

        return redirect()
            ->route('admin.meja.index')
            ->with('success', 'Meja berhasil dihapus.');
    }
}