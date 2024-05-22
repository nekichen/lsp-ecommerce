<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\ProductImages;

class HomeController extends Controller
{
    //
    public function index(){

        $products = Products::orderBy('id','desc')->limit(8)->get();
        $images = ProductImages::all();

        return view('landing.index', compact('products', 'images'));
    }
}
