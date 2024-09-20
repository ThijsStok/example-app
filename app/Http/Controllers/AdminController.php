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

        // Delete all products associated with the user
        $user->products()->delete();

        // Block the user (assuming you have a 'blocked' attribute)
        $user->blocked = true;
        $user->save();

        return redirect()->route('admin.index')->with('success', 'User blocked and all their products removed.');
    }
}