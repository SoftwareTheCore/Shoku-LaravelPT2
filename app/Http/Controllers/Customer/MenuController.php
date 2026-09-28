<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;

class MenuController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::with([
            'menus' => function ($query) {
                $query->where('is_available', true)
                    ->where('stock', '>', 0)
                    ->latest();
            }
        ])->get();

        return view(
            'customer.menu.index',
            compact('categories')
        );
    }

    public function show(Menu $menu)
    {
        abort_unless(
            $menu->is_available && $menu->stock > 0,
            404
        );

        $menu->load('category');

        return view(
            'customer.menu.show',
            compact('menu')
        );
    }
}