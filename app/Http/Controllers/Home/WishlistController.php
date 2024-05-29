<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\ProductImages;

class WishlistController extends Controller
{
    //
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $wishlistItems = Cart::instance('wishlist_' . $user->id)->content();
        $images = [];
        $products = [];

        foreach ($wishlistItems as $item) {
            $product = Products::find($item->id);
            if ($product) {
                $products[] = $product;
                $images[$item->id] = ProductImages::where('product_id', $item->id)->first();
            }
        }

        return view('landing.shop.wishlist', compact('wishlistItems', 'images', 'products'));
    }

    public function addToWishlist(Request $request)
    {
        if (Auth::check()) {
            $product = Products::find($request->id);
            $user = Auth::user();
            
            Cart::instance('wishlist_' . $user->id)->add(
                $product->id,
                $product->name,
                $request->quantity,
                $product->price,
                ['user_id' => $user->id]
            )->associate('App\Models\Products');

            return redirect()->back();
        } else {
            return redirect()->route('login')->with('error', 'Please login first');
        }
    }

    public function removeFromWishlist(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Cart::instance('wishlist_' . $user->id)->remove($request->rowId);
            return redirect()->back();
        } else {
            return redirect()->route('login')->with('error', 'Please login first');
        }
    }
}
