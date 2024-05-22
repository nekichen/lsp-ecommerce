<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Brands;

class ShopController extends Controller
{
    //
    public function index()
    {
        $products = Products::paginate(9);
        $images = ProductImages::all();

        return view('landing.shop.index', compact('products', 'images'));
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

        $images = ProductImages::where('product_id', $product->id)->get();

        \Log::info('Product:', ['product' => $product]);
        \Log::info('Images:', ['images' => $images]);

        return view('landing.shop.product', compact('product', 'images'));
    }
}
