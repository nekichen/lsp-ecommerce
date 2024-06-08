<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ShopController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\WishlistController;

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

Route::prefix('/')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', [UserController::class, 'register'])->name('page');
        Route::post('register', [UserController::class, 'registerPost'])->name('register');
        Route::get('login', [UserController::class, 'login'])->name('login');
        Route::post('login', [UserController::class, 'authenticate'])->name('authenticate');
    });
    Route::middleware('auth')->group(function () {
        // ACCOUNT
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('profile/update-user', [ProfileController::class, 'updatePage'])->name('update-profile-page');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('update-profile');
        Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('profile/delete', [ProfileController::class, 'destroy'])->name('delete-account');

        // CUSTOMER ADDRESS
        Route::get('profile/addresses', [ProfileController::class, 'addresses'])->name('customer-address');
            // add address
        Route::get('profile/add-address', [ProfileController::class, 'addAddressPage'])->name('add-address-page');
        Route::post('profile/add-new-address', [ProfileController::class, 'addAddress'])->name('add-address');
            // activate address
        Route::post('/activate-address/{id}', [ProfileController::class, 'activateAddress'])->name('activate-address');
            // edit address
        Route::get('profile/edit-address/{id}', [ProfileController::class, 'editAddressPage'])->name('edit-address-page');
        Route::post('profile/edit-address/edit{id}', [ProfileController::class, 'editAddress'])->name('edit-address');

        // CART
        Route::get('cart', [CartController::class, 'index'])->name('cart');
        Route::post('cart/store', [CartController::class, 'addToCart'])->name('add-to-cart');
        Route::put('cart/update', [CartController::class, 'updateCart'])->name('update-cart');
        Route::delete('cart/remove', [CartController::class, 'removeItem'])->name('remove-item');
        Route::delete('cart/clear', [CartController::class, 'clearCart'])->name('clear-cart');

        // WISHLIST
        Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::post('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist-add');
        Route::delete('wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist-remove');
        Route::delete('wishlist/clear', [WishlistController::class, 'clearWishlist'])->name('wishlist-clear');

        // ORDERS
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/order/success', function () {
            return view('landing.shop.order-success');
        })->name('order.success');
        Route::get('orders', [ProfileController::class, 'orders'])->name('orders');
    });
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('shop', [ShopController::class, 'index'])->name('shop');
    Route::get('shop/category/{categorySlug}', [ShopController::class, 'index'])->name('shop.category');
    Route::get('product/{slug}', [ShopController::class, 'product'])->name('product');

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
        Route::resource('discounts', DiscountsController::class);
        Route::resource('orders', OrdersController::class);
        Route::resource('customers', CustomersController::class);
        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});