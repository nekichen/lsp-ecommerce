<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Sizes;
use App\Models\Payments;
use App\Models\ProductImages;
use App\Models\Deliveries;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Orders::orderBy('id', 'desc')->paginate(10);
        $customers = Customers::all();

        return view('dashboard.orders.index', compact('orders', 'customers'), [
            'orders' => Orders::all(),
            'create' => route('orders.create'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orders = Orders::find($id);
        $orderDetails = OrderDetails::where('order_id', $orders->id)->get();
        $customers = Customers::where('id', $orders->customer_id)->first();
        $products = Products::whereIn('id', $orderDetails->pluck('product_id'))->get();
        $sizes = Sizes::whereIn('id', $orderDetails->pluck('size_id'))->get();
        $images = ProductImages::whereIn('product_id', $orderDetails->pluck('product_id'))->get();
        $payments = Payments::where('order_id', $orders->id)->first();

        return view('dashboard.orders.edit', compact('orders', 'orderDetails', 'customers', 'products', 'sizes', 'images', 'payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Shipped,Delivered,Cancelled',
        ]);

        // Find the order by ID
        $order = Orders::findOrFail($id);

        // Update the order status
        $order->status = $request->input('status');
        $order->save();

        $paymentMethod = Payments::where('order_id', $order->id)->first();
        
        $products = Products::whereIn('id', OrderDetails::where('order_id', $order->id)->pluck('product_id'))->first();
        $quantity = OrderDetails::where('order_id', $order->id)->sum('quantity');
        
        if ($order->status == 'Shipped') {
            $deliveries = new Deliveries();
            $deliveries->order_id = $order->id;
            $deliveries->shipped_date = now();
            $deliveries->tracking_code = uniqid('TC-');
            $deliveries->status = 'Shipped';
            $deliveries->save();
        } elseif ($order->status == 'Delivered') {
            $paymentMethod->payment_status = 'paid';
            $paymentMethod->save();

            $deliveries = Deliveries::where('order_id', $order->id)->first();
            $deliveries->delivered_date = now();
            $deliveries->status = 'Delivered';
            $deliveries->save();
        } elseif ($order->status == 'Cancelled') {
            $paymentMethod->payment_status = 'cancelled';
            $paymentMethod->amount = 0;
            $paymentMethod->save();

            $products->stock = $products->stock + $quantity;
            $products->save();

            $deliveries = Deliveries::where('order_id', $order->id)->first();
            $deliveries->status = 'Cancelled';
            $deliveries->save();
        } 

        // Redirect back with a success message
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }

    public function exportPDF()
    {
        // Ambil data order dari database
        $orders = Orders::all();

        // Data yang akan dikirim ke view
        $data = [
            'orders' => $orders
        ];

        // Load view dengan data
        $pdf = PDF::loadView('orders_pdf', $data);

        // Unduh PDF dengan nama orders.pdf
        return $pdf->download('orders.pdf');
    }
}
