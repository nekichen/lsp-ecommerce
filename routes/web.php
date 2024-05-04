<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Landing Page

Route::get('/', function () {
    return view('landing.index');
});
Route::prefix('/')->group(function () {
    Route::get('shop', function () {
        return view('landing.shop.shop');
    });
    Route::get('shop-details', function () {
        return view('landing.shop.shop-details');
    })->name('shop-details');
    Route::get('cart', function () {
        return view('landing.shop.shopping-cart');
    });
});
    

// Admin Panel

Route::prefix('admin')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        // Routes that require authentication via the web guard
        Route::redirect('/', '/admin/login');
        Route::get('login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::middleware('admin.auth')->group(function () {
        // Routes that require authentication via the web guard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UsersController::class);
        Route::resource('categories', CategoriesController::class);
        Route::resource('brands', BrandsController::class);
        Route::resource('sizes', SizesController::class);
        Route::resource('products', ProductsController::class);
        Route::resource('payments', PaymentsController::class);
        Route::resource('orders', OrdersController::class);
        Route::resource('customers', CustomersController::class);
        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});