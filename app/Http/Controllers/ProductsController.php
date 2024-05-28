<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Brands;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductImages;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::paginate(10);
        $images = ProductImages::all();
        $brands = Brands::all();
        $categories = Categories::all();

        return view('dashboard.products.index', compact('products', 'images', 'brands', 'categories'), [
            "create" => route('products.create'),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $brands = Brands::all();
        $categories = Categories::all();
        $images = ProductImages::all();

        return view('dashboard.products.create', compact('brands', 'categories', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'sku' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
        ]);

        // Create a new product
        $product = Products::create($data);

        // Validate images separately
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Check if the product was created successfully
        if ($product && $request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // Handle the file upload
                $image_path = $image->store('images/products', 'public');
    
                // Initialize a new ProductImages instance
                $product_image = new ProductImages();
                $product_image->product_id = $product->id;
                $product_image->image = $image_path;
    
                // Save the product image record
                $product_image->save();
            }
        }

        return redirect()->route('products.index')->with('message', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Products::find($id);
        $brands = Brands::all();
        $categories = Categories::all();
        // $images = ProductImages::all();

        if (!$product) {
            return redirect()->route('products.index')->with('message', 'Product not found');
        }

        return view('dashboard.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'sku' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'active' => 'required',
        ]);

        Products::where('id', $id)->update($data);

        return redirect()->route('products.index')->with('message', 'Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        if ($product) {
            $product->delete();
            return back()->with('message', 'Product and associated images deleted successfully');
        }
        return back()->with('error', 'Product not found');
    }

}
