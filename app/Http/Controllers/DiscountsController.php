<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discounts;
use App\Models\DiscountProducts;
use App\Models\Products;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $discountProducts = DiscountProducts::paginate(10);
        $discounts = Discounts::all();

        return view('dashboard.discounts.index', compact('discounts', 'discountProducts'), [
            "create" => route('discounts.create'),
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
        $products = Products::all();

        return view('dashboard.discounts.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
        ]);

        // Membuat diskon baru
        $discount = new Discounts();
        $discount->name = $validatedData['name'];
        $discount->percentage = $validatedData['percentage'];
        $discount->start_date = $validatedData['start_date'];
        $discount->end_date = $validatedData['end_date'];
        $discount->save();

        // Menyimpan produk yang terkait dengan diskon
        foreach ($validatedData['product_id'] as $productId) {
            $discountProduct = new DiscountProducts();
            $discountProduct->discount_id = $discount->id;
            $discountProduct->product_id = $productId;
            $discountProduct->save();
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('discounts.index')->with('success', 'Discount created successfully!');
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
    }
}
