<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\Sizes;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\ProductReviews;

class ShopController extends Controller
{
    //
    public function index(Request $request, $categorySlug = null)
    {      
        $categorySelected = null;
        $brandSlugs = $request->get('brand') ? explode(',', $request->get('brand')) : [];
        $sort = $request->get('sort');

        $categories = Categories::with('products')->get();
        $brands = Brands::all();
        $query = Products::query();
        $query->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END');

        // Handle search query
        if ($request->get('search')) {
            $query->where(function($q) use ($request) {
                $q->where('products.name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('products.description', 'like', '%' . $request->get('search') . '%');
            });
        }

        if ($request->get('sort')) {
            if ($request->get('sort') == 'low') {
                $query->orderBy('price', 'ASC');
            } else {
                $query->orderBy('price', 'DESC');
            }
        } else {
            $query->orderByDesc('id');
        }

        if ($categorySlug) {
            $category = Categories::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
                $categorySelected = $category->id; // Set the selected category ID
            }
        }

        if (!empty($brandSlugs)) {
            $brandIds = Brands::whereIn('slug', $brandSlugs)->pluck('id')->toArray();
            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            }
        }

        // Retrieve products with their reviews
        $products = $query->with('reviews.customer')->where('active', 'yes')->paginate(9);

        // Calculate average rating for each product
        foreach ($products as $product) {
            $totalRating = 0;
            $totalReviews = $product->reviews->count();

            foreach ($product->reviews as $review) {
                $totalRating += $review->rating;
            }

            $product->averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;
        }

        $images = ProductImages::all();

        $user = Auth::user();
        $wishlistItems = $user ? Cart::instance('wishlist_' . $user->id)->content() : collect([]);
        $productInWishlist = $wishlistItems->pluck('id')->toArray();

        return view('landing.shop.index', compact('products', 'images', 'brands', 'categories', 'categorySelected', 'brandSlugs', 'sort', 'request', 'productInWishlist', 'wishlistItems'));
    }


    public function product($slug)
    {
        if (empty($slug)) {
            abort(404, 'Slug parameter is missing');
        }
        
        $product = Products::where('slug', $slug)->with('reviews.customer')->firstOrFail();
    
        if (!$product) {
            abort(404, 'Product not found');
        }

        // dd($product->id);

        $images = ProductImages::where('product_id', $product->id)->get();
        $size = Sizes::all();
        $category = Categories::find($product->category_id);
        $brand = Brands::find($product->brand_id);

        $relatedProducts = Products::where('id', '!=', $product->id)
            ->where('active', 'yes')
            ->where('stock', '>', 0)
            ->where('category_id', $product->category_id)
            ->orderBy('id', 'DESC')
            ->with('reviews.customer')
            ->take(4)
            ->get();

        foreach ($relatedProducts as $rltPrd) {
            $totalRating = 0;
            $totalReviews = $rltPrd->reviews->count();
    
            foreach ($rltPrd->reviews as $review) {
                $totalRating += $review->rating;
            }
    
            $rltPrd->averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;
        }

        // Get all related images
        $relatedImages = ProductImages::whereIn('product_id', $relatedProducts->pluck('id'))->get();

        $totalRating = 0;
        $totalReviews = count($product->reviews);

        foreach ($product->reviews as $review) {
            $totalRating += $review->rating;
        }

        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;

        return view('landing.shop.product', compact('relatedProducts', 'relatedImages', 'product', 'images', 'size', 'category', 'brand', 'averageRating', 'totalReviews'));
    }

    public function review(Request $request, Products $product)
    {
        // Validasi input
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:255',
        ]);

        // Mengambil produk berdasarkan slug
        $product = Products::where('slug', $product->slug)->firstOrFail();

        // Mengambil customer ID dari user yang sedang login
        $user = Auth::user();
        $customer = Customers::where('user_id', $user->id)->first();

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found!');
        }

        // Mengambil order details di mana produk tersebut dipesan oleh customer saat ini
        $orderDetails = OrderDetails::where('product_id', $product->id)
                                     ->whereHas('order', function($query) use ($customer) {
                                         $query->where('customer_id', $customer->id)->where('status', 'Delivered');
                                     })
                                     ->first();;

        // Memeriksa apakah customer telah memesan produk tersebut
        if (!$orderDetails) {
            return redirect()->back()->with('error', 'You can only review products you have ordered!');
        }

        // Membuat ulasan baru
        $review = new ProductReviews();
        $review->product_id = $product->id;
        $review->customer_id = $customer->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
