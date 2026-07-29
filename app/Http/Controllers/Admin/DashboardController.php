<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index() {
        $categories = Category::all();
        $products = Product::with('category')->latest()->get();

        return view('admin.dashboard', compact('categories', 'products'));
    }
}
