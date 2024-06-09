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
        $wishlistItems = Cart::instance('wishlist_' . $user->id)->content()->sortByDesc(function ($item) {
            // Retrieve the 'added_at' timestamp from item's options
            return $item->options->added_at;
        });
        $images = [];
        $products = [];

        foreach ($wishlistItems as $item) {
            // Use eager loading to retrieve product with reviews and customer
            $product = Products::with('reviews.customer')->find($item->id);
            if ($product) {
                // Calculate the average rating for the product
                $totalRating = 0;
                $totalReviews = $product->reviews->count();

                foreach ($product->reviews as $review) {
                    $totalRating += $review->rating;
                }

                $product->averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;

                // Assign averageRating to each item in wishlist
                $item->averageRating = $product->averageRating;

                $products[] = $item; // Push the item to products array
                $images[$item->id] = ProductImages::where('product_id', $item->id)->first();
            }
        }
        
        return view('landing.shop.wishlist', compact('wishlistItems', 'images', 'products'));
    }

    public function addToWishlist(Request $request)
    {
        $product = Products::find($request->id);
            $user = Auth::user();
            
        Cart::instance('wishlist_' . $user->id)->add(
            $product->id,
            $product->name,
            1,
            $product->price,
            [
                'user_id' => $user->id,
                'added_at' => now()
            ]
        )->associate('App\Models\Products');

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function removeFromWishlist(Request $request)
    {
        $rowId = $request->rowId;

        Cart::instance('wishlist_' . Auth::user()->id)->remove($rowId);
        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }

    public function clearWishlist()
    {
        Cart::instance('wishlist_' . Auth::user()->id)->destroy();
        return redirect()->back()->with('success', 'Wishlist cleared!');
    }
}
