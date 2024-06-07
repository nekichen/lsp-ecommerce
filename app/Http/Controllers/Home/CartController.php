<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Sizes;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Payments;

class CartController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::instance('cart_' . $user->id)->content();
        $images = [];

        if(Auth::check('user_id' == Auth::user()->id)){
            foreach ($cartItems as $item) {
                $product = Products::find($item->id);
                $images[$item->id] = ProductImages::where('product_id', $item->id)->first();
            }
        }

        return view('landing.shop.cart', compact('cartItems', 'images'));
    }

    public function addToCart(Request $request)
    {
        $product = Products::find($request->id);
        $user = Auth::user();

        // Check if size exists in sizes table
        $size = Sizes::where('code', $request->size)->first();
        if (!$size) {
            return redirect()->back()->with('error', 'Please choose a valid size');
        }
            
        Cart::instance('cart_' . $user->id)->add(
            $product->id,
            $product->name,
            $request->quantity,
            $product->price,
            [
                'user_id' => $user->id,
                'size' => $size->code // Add size to item options
            ]
        )->associate('App\Models\Products');

        return redirect()->back()->with('message', 'Product added to cart');
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->update($request->rowId, $request->quantity);
    
        return redirect()->back();
    }

    public function removeItem(Request $request)
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->remove($request->rowId_D);
    
        return redirect()->back();
    }

    public function clearCart()
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->destroy();
    
        return redirect()->back();
    }

    public function checkout()
    {
        $user = Auth::user();
        $cartItems = Cart::instance('cart_' . $user->id)->content();
        $total = Cart::instance('cart_' . $user->id)->total();
        
        // Retrieve all addresses for the user
        $addresses = Customers::where('user_id', $user->id)->with('country')->get();

        if( count($cartItems) == 0 ){
            return redirect()->route('cart')->with('error', 'Cart is empty');
        } else {
            return view('landing.shop.checkout', compact('cartItems', 'total', 'addresses'));
        }
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cod,bank transfer,paypal',
            'notes' => 'nullable|string'
        ]);

        $user = Auth::user();
        $cartItems = Cart::instance('cart_' . $user->id)->content();
        $total = Cart::instance('cart_' . $user->id)->total();

        // Find the selected address
        $customer = Customers::where('id', $request->address_id)->where('user_id', $user->id)->first();
        if (!$customer) {
            return redirect()->back()->with('error', 'Address not found.');
        }

        // Create an order
        $order = new Order();
        $order->invoice_number = uniqid('INV-'); // Generate a unique invoice number
        $order->customer_id = $customer->id;
        $order->order_date = now();
        $order->total = $total;
        $order->notes = $request->notes;
        $order->status = 'Pending'; // Initial status
        $order->payment_method = $request->payment_method;
        $order->save();

        // Save order items
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->quantity = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->size = $item->options->size;
            $orderItem->save();
        }

        // Clear the cart
        Cart::instance('cart_' . $user->id)->destroy();

        return redirect()->route('order.success')->with('message', 'Order placed successfully!');
    }

}
