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

        // dd('Category Slug:', $categorySlug, 'Category Selected:', $categorySelected);

        $products = $query->orderBy('id', 'DESC')->where('active', 'yes')->paginate(9);
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
        
        $product = Products::where('slug', $slug)->first();
    
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
            ->orderBy('id', 'DESC')
            ->get();

        // Get all related images
        $relatedImages = ProductImages::whereIn('product_id', $relatedProducts->pluck('id'))->get();

        $productInWishlist = Cart::instance('wishlist_' . Auth::user()->id)->content()->pluck('id')->contains($product->id);

        return view('landing.shop.product', compact('relatedProducts', 'relatedImages', 'product', 'images', 'size', 'category', 'brand', 'productInWishlist'));
    }
}
