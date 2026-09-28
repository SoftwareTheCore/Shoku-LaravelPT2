<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Menampilkan semua menu.
     */
    public function index()
    {
        $menus = Menu::with('category')
            ->oldest()
            ->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Form tambah menu.
     */
    public function create()
    {
        $categories = MenuCategory::oldest()
            ->orderBy('id')
            ->get();

        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Menyimpan menu baru.
     */
    public function store(Request $request)
    {
        $stockMinimum = $request->boolean('is_available') ? 1 : 0;

        $validated = $request->validate([
            'menu_category_id' => [
                'required',
                'exists:menu_categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],

            'stock' => [
                'required',
                'integer',
                'min:' . $stockMinimum,
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],
        ], [
            'menu_category_id.required' => 'Kategori menu wajib dipilih.',
            'menu_category_id.exists' => 'Kategori menu tidak valid.',

            'name.required' => 'Nama menu wajib diisi.',
            'name.max' => 'Nama menu maksimal 150 karakter.',

            'description.max' => 'Deskripsi maksimal 2000 karakter.',

            'price.required' => 'Harga menu wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',

            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok harus lebih dari 0 jika menu ditandai tersedia.',

            'image.image' => 'File yang dipilih harus berupa gambar.',
            'image.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $validated['is_available'] = $request->boolean('is_available')
            && $validated['stock'] > 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('menus', 'public');
        }

        Menu::create($validated);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Detail menu.
     */
    public function show(Menu $menu)
    {
        $menu->load('category');

        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Form edit menu.
     */
    public function edit(Menu $menu)
    {
        $categories = MenuCategory::oldest()
            ->orderBy('id')
            ->get();

        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $stockMinimum = $request->boolean('is_available') ? 1 : 0;

        $validated = $request->validate([
            'menu_category_id' => [
                'required',
                'exists:menu_categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],

            'stock' => [
                'required',
                'integer',
                'min:' . $stockMinimum,
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_available' => [
                'nullable',
                'boolean',
            ],
        ], [
            'menu_category_id.required' => 'Kategori menu wajib dipilih.',
            'menu_category_id.exists' => 'Kategori menu tidak valid.',

            'name.required' => 'Nama menu wajib diisi.',
            'name.max' => 'Nama menu maksimal 150 karakter.',

            'description.max' => 'Deskripsi maksimal 2000 karakter.',

            'price.required' => 'Harga menu wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',

            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok harus lebih dari 0 jika menu ditandai tersedia.',

            'image.image' => 'File yang dipilih harus berupa gambar.',
            'image.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $validated['is_available'] = $request->boolean('is_available')
            && $validated['stock'] > 0;

        if ($request->hasFile('image')) {

            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}