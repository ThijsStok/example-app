<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('products')->get();
        return view('admin', compact('users'));
    }

    public function removeProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Product removed successfully.');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'blocked']);

        return redirect()->route('admin.index')->with('success', 'User blocked successfully.');
    }
}