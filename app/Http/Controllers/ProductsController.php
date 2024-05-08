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
        $data = Products::paginate(10);

        return view('dashboard.products.index', compact('data'), [
            "products" => Products::all(),
            "brands" => Brands::all(),
            "categories" => Categories::all(),
            "images" => ProductImages::all(),
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
        return view('dashboard.products.create', [
            "brands" => Brands::all(),
            "categories" => Categories::all(),
            "images" => ProductImages::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        ]);

        $product = Products::create($data); 

        // Check if $product exists
        if ($product) {
            $product_image = new ProductImages();
            $product_image->product_id = $product->id;

            if ($request->validate(['image'])) {
            // Validate the uploaded file
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);

                $image = $request->file('image');
                // $image_name = time() . '_' . $data['slug'] . '.' . $image->getClientOriginalExtension();
                $product_image->image = Storage::disk('public')->putFileAs('images/products', $image);
            } else {
                // If no image uploaded, set image field to null
                $product_image->image = null;
            }

            $product_image->save();
        }


        return redirect()->route('products.index')->with('message', 'Product added successfully');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Products::where('id', $id)->delete();
        $data = ProductImages::where('product_id', $id)->delete();

        return back()->with('message', 'Product deleted successfully');
    }
}
