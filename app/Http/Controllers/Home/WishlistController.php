<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Products;

class WishlistController extends Controller
{
    //
    public function addToWishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Products');

        return response()->json(['status' => 200, 'message' => 'Product added to wishlist']);
    }
}
