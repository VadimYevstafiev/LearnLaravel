<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->paginate(5);
        return view('categories/index', compact('categories'));
    }

    public function show(Category $category)
    {

        $products = $category->products()->orderByDesc('id')->paginate(4);
        $childs = $category->childs()->getResults();

        return view('categories/show', compact('category', 'products', 'childs'));
    }
}
