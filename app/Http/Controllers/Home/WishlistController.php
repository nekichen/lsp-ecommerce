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
        $user = Auth::user();
        $wishlistItems = Cart::instance('wishlist_' . Auth::user()->id)->content();
        $images = [];

        if(Auth::check('user_id' == Auth::user()->id)){
            foreach ($wishlistItems as $item) {
                $product = Products::find($item->id);
                $images[$item->id] = ProductImages::where('product_id', $item->id)->first();
            }
        }

        if (Auth::check()) {
            return view('landing.shop.wishlist', compact('wishlistItems', 'images', 'product'));
        } else {
            return redirect()->route('login');
        }
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
}
