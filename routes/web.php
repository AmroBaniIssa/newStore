<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Models\Category;
use App\Models\Product;



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

// Route::get('/home', function () {
//     return view('products.index');
// })->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard', [CategoryController::class, 'store'])->name('addCategory');
Route::get('/cart', [OrdersController::class, 'index'])->name('cart');

Route::post('/add-to-cart', [OrdersController::class, 'create'])->name('add.to.cart');
Route::post('/add-to-orders', [OrdersController::class, 'store'])->name('add.to.orders');
Route::get('/orders', [OrdersController::class, 'orderspage'])->name('orderspage');

Route::post('/update-quantity', [OrdersController::class, 'updateQuantity'])->name('updateQuantity');



Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::post('/products', [ProductsController::class, 'store']);
Route::get('/products/{product}', [ProductsController::class, 'show'])->name('oneProduct');
Route::get('/products/tag/{tag}', [ProductsController::class, 'productsTag'])->name('productsTag');
Route::get('/products/bysearch/{search}', [ProductsController::class, 'bySearch'])->name('bySearch');

Route::get('/products/category/{category}', [ProductsController::class, 'productsByCategory'])
    ->name('products.byCategory');

Route::get('/home', [ProductsController::class, 'index'])->name('home');




