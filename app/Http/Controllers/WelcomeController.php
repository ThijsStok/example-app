<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\types\categorytypes;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::whereNull('borrower_id')->get();
        $commonCategories = categorytypes::$commonCategories;
        return view('welcome', ['products' => $products, "commonCategories" => $commonCategories]);
    }
}