<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuCategoryController extends Controller
{
    /**
     * Menampilkan semua kategori.
     */
    public function index()
    {
        $categories = MenuCategory::oldest()
            ->orderBy('id')
            ->paginate(10);

        return view('admin.menu_categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.menu_categories.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:menu_categories,name',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        MenuCategory::create($validated);

        return redirect()
            ->route('admin.menu-categories.index')
            ->with('success', 'Kategori menu berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori.
     */
    public function show(MenuCategory $menuCategory)
    {
        return view('admin.menu_categories.show', compact('menuCategory'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(MenuCategory $menuCategory)
    {
        return view('admin.menu_categories.edit', compact('menuCategory'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, MenuCategory $menuCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('menu_categories', 'name')
                    ->ignore($menuCategory->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        $menuCategory->update($validated);

        return redirect()
            ->route('admin.menu-categories.index')
            ->with('success', 'Kategori menu berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(MenuCategory $menuCategory)
    {
        $menuCategory->delete();

        return redirect()
            ->route('admin.menu-categories.index')
            ->with('success', 'Kategori menu berhasil dihapus.');
    }
}