<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('comments', compact('product'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $product = Product::findOrFail($productId);
        $ownerId = $product->owner_id;
        $borrowerId = auth()->id();

        Comment::create([
            'product_id' => $productId,
            'borrower_id' => $borrowerId,
            'owner_id' => $ownerId,
            'comment' => $request->comment,
        ]);

        return redirect()->route('lendmystuff')->with('success', 'Comment added successfully.');
    }
}