<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $categories = Category::take(6)->get();
        $products = Product::orderByDesc('id')->available()->take(8)->get();

        return view('home', compact('categories', 'products'));
    }
}
