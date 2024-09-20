<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Lend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('login');
    }

    public function registerIndex()
    {
        return view('register');
    }

public function lendMyStuffIndex()
{
    $userId = Auth::id(); // Get the current user's ID

    // Fetch products the user is lending
    $lending = Product::where('owner_id', $userId)
                      ->whereNotNull('borrower_id') // Ensures the product is currently lent out
                      ->get();

    // Fetch products lent to the user
    $borrowed = Product::where('borrower_id', $userId)->get();

    // Fetch all products owned by the user (not lent out)
    $products = Product::where('owner_id', $userId)
                       ->whereNull('borrower_id') // Ensures the product is not currently lent out
                       ->get();

    // Fetch all products available for borrowing
    $availableItems = Product::where('owner_id', $userId)->where('state', 'available')->get();

    // Pass all data to the view
    return view('lendmystuff', [
        'products' => $products,
        'lending' => $lending,
        'borrowed' => $borrowed,
        'availableItems' => $availableItems,
    ]);
}

public function login(Request $request)
{
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->blocked) {
            Auth::logout();
            return redirect('login')->withErrors(['Your account is blocked.']);
        }
        return redirect('/');
    }

    return redirect('login')->withErrors(['Invalid email or password']);
}

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Registration successful!');
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('Logout successful!');
        return redirect('login');
    }
}