<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Controllers\Controller;

class AdminMenuController extends Controller
{
    public function index() {
        $title = '';

        // if(request('category')) {
        //     $category = Category::firstWhere('slug', request('category'));
        //     $title = ' in ' . $category->name;
        // }

        // if(request('author')) {
        //     $author = User::firstWhere('username', request('author'));
        //     $title = ' by ' . $author->name;
        // }

        return view('dashboard.menus.index', [
            "title" => "Daftar Menu" . $title,
            // "active" => "menus",
            // "menus" => Menu::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
            "menus" => Menu::all()
        ]);
    }

    public function show(Menu $menu) {
        return view('dashboard.menus.index', [
            "title" => "Daftar Menu",
            "active" => "menus",
            "menu" => $menu
        ]);
    }
}
