<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\ProductImages;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        $products = Products::orderBy('id','desc')->limit(8)->with('reviews.customer')->get();
        $images = ProductImages::all();

        $orderItems = OrderDetails::select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Get the product IDs from the order items
        $bestSellerProductIds = $orderItems->pluck('product_id');

        // Retrieve the products based on the IDs
        $bestSeller = Products::whereIn('id', $bestSellerProductIds)->with('reviews.customer')->get();

        // Filter produk terbaik (best seller) untuk rating 3 ke atas
        $bestSeller = $bestSeller->filter(function ($product) {
            $totalRating = 0;
            $totalReviews = $product->reviews->count();

            foreach ($product->reviews as $review) {
                $totalRating += $review->rating;
            }

            $product->averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;

            return $product->averageRating >= 3;
        });

        // Menghitung rata-rata rating untuk setiap produk dalam $products
        foreach ($products as $product) {
            $totalRating = 0;
            $totalReviews = $product->reviews->count();

            foreach ($product->reviews as $review) {
                $totalRating += $review->rating;
            }

            $product->averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 2) : 0;
        }
        
        return view('landing.index', compact('products', 'images', 'bestSeller'));
    }
}
