<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Assuming you have a Product model
use App\types\categorytypes;
use App\Models\Lend; // Assuming you have a Lend model
use Illuminate\Support\Facades\Auth; // If you're using authentication

class LendMyStuffController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the current user's ID
    
        // Fetch products the user is lending
        $lending = Lend::where('owner_id', $userId)->get();
    
        // Fetch products lent to the user
        $borrowed = Lend::where('borrower_id', $userId)->get();
    
        // Fetch all products (already existing line)
        $products = Product::all();
    
        // Pass all data to the view
        return view('lendmystuff', [
            'products' => $products,
            'lending' => $lending,
            'borrowed' => $borrowed,
        ]);
    }

    public function returnItem($id)
    {
        $item = Product::findOrFail($id);
        
        // Check if the current user is the borrower
        if ($item->borrower_id != auth()->id()) {
            return back()->with('error', 'You are not authorized to return this item.');
        }
    
        $item->state = 'waiting_for_acceptance'; // Set state to waiting for acceptance
        $item->save();
    
        return back()->with('success', 'Return initiated, waiting for owner to accept.');
    }

    public function borrow(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if ($product && is_null($product->borrower_id)) { // Check if product exists and is not currently borrowed
            // Set the borrow_id to the ID of the currently authenticated user
            $product->borrower_id = Auth::id(); // Get the currently authenticated user's ID
            $product->lend_date = now(); // Set the lend date to now
            $product->return_date = now()->addDays(intval($request->input('lend_days')));
            $product->save();

            return redirect()->back()->with('success', 'Product borrowed successfully!');
        }

        return redirect()->back()->with('error', 'Product not found or already borrowed.');
    }

    public function acceptReturn($id)
{
    $item = Product::findOrFail($id);
    
    // Check if the current user is the owner
    if ($item->owner_id != auth()->id()) {
        return back()->with('error', 'You are not authorized to accept this return.');
    }

    $item->borrower_id = null; // Clear borrower_id
    $item->state = 'available'; // Mark as available
    $item->save();

    return back()->with('success', 'Item return accepted.');
}

    public function createProduct(){
        $products = Product::All();
        $commonCategories = CategoryTypes::$commonCategories;
        return view('addproduct', ['products' => $products, 'commonCategories'=> $commonCategories]);
    }

    public function storeNew(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
        ]);
    
        $product = new Product();
        $product->owner_id = Auth::id(); // Set the owner ID to the currently authenticated user
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->description = $request->input('description');
        $product->borrower_id = null; // Initially, no one is borrowing the product
    
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $product->image = 'images/'.$imageName; // Save the path in the database
        }
    
        $product->save();
    
        return redirect('/lendmystuff')->with('success', 'Product added successfully!');
    }
}