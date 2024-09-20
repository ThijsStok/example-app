<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LendMyStuffController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdminRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'loginIndex']);
    Route::get('register', [AuthController::class, 'registerIndex']);
    Route::get('lendmystuff', [AuthController::class, 'lendMyStuffIndex']);
    Route::get('borrowedstuff', [AuthController::class, 'borrowedstuffIndex']);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('lendmystuff', [AuthController::class, 'lendMyStuffIndex']);

    Route::patch('/return/{id}', [LendMyStuffController::class, 'returnItem'])->name('returnProduct');
    Route::patch('/products/{product}/accept-return', [LendMyStuffController::class, 'acceptReturn'])->name('acceptReturn');
    Route::get('/add-product', [LendMyStuffController::class, 'createProduct'])->name('addProductForm');
    Route::delete('/products/{product}/remove', [LendMyStuffController::class, 'removeProduct'])->name('removeProduct');
    Route::post('/store-product', [LendMyStuffController::class, "storeNew"])->name('storeProduct');
    Route::post('/borrow', [LendMyStuffController::class, 'borrow'])->name('borrow');
    // Route::post('/products/{product}/return', [LendMyStuffController::class, 'returnItem'])->name('products.return');

    // route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware(CheckAdminRole::class);
});


Route::get('/products/filter', 'ProductController@filter')->name('products.filter');