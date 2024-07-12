<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::whereNull('borrower_id')->get();
        $types = require app_path('types.php');
        $commonCategories = $types['commonCategories'];
        return view('welcome', ['products' => $products, "categories" => $commonCategories]);
    }
}