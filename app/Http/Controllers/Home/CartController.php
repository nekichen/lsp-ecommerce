<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Sizes;

class CartController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::instance('cart_' . $user->id)->content();
        $images = [];

        if(Auth::check('user_id' == Auth::user()->id)){
            foreach ($cartItems as $item) {
                $product = Products::find($item->id);
                $images[$item->id] = ProductImages::where('product_id', $item->id)->first();
            }
        }

        if(Auth::check()) {
            return view('landing.shop.cart', compact('cartItems', 'images'));
        } else {
            return redirect()->route('login');
        }
    }

    public function addToCart(Request $request)
    {
        if (Auth::check()) {
            $product = Products::find($request->id);
            $user = Auth::user();

            // Check if size exists in sizes table
            $size = Sizes::where('code', $request->size)->first();
            if (!$size) {
                return redirect()->back()->with('error', 'Please choose a valid size');
            }
            
            Cart::instance('cart_' . $user->id)->add(
                $product->id,
                $product->name,
                $request->quantity,
                $product->price,
                [
                    'user_id' => $user->id,
                    'size' => $size->code // Add size to item options
                ]
            )->associate('App\Models\Products');

            return redirect()->back()->with('message', 'Product added to cart');
        } else {
            return redirect()->route('login')->with('error', 'Please login first');
        }
    }

    public function updateCart(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Cart::instance('cart_' . $user->id)->update($request->rowId, $request->quantity);
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }

    public function removeItem(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Cart::instance('cart_' . $user->id)->remove($request->rowId_D);
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Cart::instance('cart_' . $user->id)->destroy();
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }
}
