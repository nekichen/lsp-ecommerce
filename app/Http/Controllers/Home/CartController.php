<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Sizes;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Payments;
use App\Models\Discounts;
use App\Models\OrderDetails;

class CartController extends Controller
{
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
            
        // Stock check
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock');
        }

        // Add to cart
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
        Session::forget('total_amount');
    
        return redirect()->back();
    }

    public function removeItem(Request $request)
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->remove($request->rowId_D);
        Session::forget('total_amount');
    
        return redirect()->back();
    }

    public function clearCart()
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->destroy();
        Session::forget('total_amount');
    
        return redirect()->back();
    }

    public function checkout()
    {
        $user = Auth::user();
        $cartItems = Cart::instance('cart_' . $user->id)->content();

        $total = floatval(str_replace(',', '', Cart::instance('cart_' . $user->id)->subtotal())); // Use subtotal instead of total
        $total_amount = session('total_amount', $total); // Retrieve total_amount from session if available

        // Retrieve all addresses for the user
        $addresses = Customers::where('user_id', $user->id)->with('country')->get();

        if ($addresses->isEmpty()) {
            return redirect()->route('add-address-page')->with('error', 'Please add an address to proceed.');
        }

        if (count($cartItems) == 0) {
            return redirect()->route('cart')->with('error', 'Cart is empty');
        } else {
            return view('landing.shop.checkout', compact('cartItems', 'total', 'total_amount', 'addresses'));
        }
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        $discount = Discounts::where('code', $couponCode)
                            ->where('is_active', true)
                            ->whereDate('start_date', '<=', now())
                            ->whereDate('end_date', '>=', now())
                            ->first();

        if ($discount) {
            $user = Auth::user();
            $cartInstance = Cart::instance('cart_' . $user->id);
            $subtotal = (double)(str_replace(',', '', $cartInstance->subtotal()));
            $discountedTotal = 0;

            if ($discount->type == 'fixed') {
                $discountedTotal = $subtotal - $discount->amount;
                // Pastikan tidak kurang dari nol
                $discountedTotal = max($discountedTotal, 0);
            } else {
                // Hitung diskon dalam bentuk persentase
                $discountedTotal = $subtotal * (1 - ($discount->amount / 100));
            }

            // Update session dengan total yang didiskon
            session(['total_amount' => number_format($discountedTotal, 2), 'discounted_total' => $discountedTotal]);

            return redirect()->back()->with('success', 'Coupon applied successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid or inactive coupon code. Please try again.');
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
        $total = floatval(str_replace(',', '', Cart::instance('cart_' . $user->id)->subtotal()));
        $total_amount = session('total_amount', $total); // Use the discounted total if available

        $customer = Customers::where('id', $request->address_id)->where('user_id', $user->id)->first();
        if (!$customer) {
            return redirect()->back()->with('error', 'Address not found.');
        }

        $order = new Orders();
        $order->invoice_number = uniqid('INV-');
        $order->customer_id = $customer->id;
        $order->discount_id = $discount->id;
        $order->order_date = now();
        $order->total = number_format($total_amount, 2, '.', '');
        $order->notes = $request->notes;
        $order->status = 'Pending';
        $order->save();

        $payment = new Payments();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer->id;
        $payment->amount = number_format($total_amount, 2, '.', '');
        $payment->payment_date = now();
        $payment->payment_method = $request->payment_method;
        $payment->save();

        foreach ($cartItems as $item) {
            $orderItem = new OrderDetails();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->quantity = $item->qty;
            $sizeId = Sizes::where('code', $item->options->size)->value('id');
            $orderItem->size_id = $sizeId;
            $orderItem->subtotal = $item->price * $item->qty;
            $orderItem->save();

            $product = Products::find($item->id);
            $product->stock = $product->stock - $item->qty;
            $product->save();
        }

        Cart::instance('cart_' . $user->id)->destroy();

        return redirect()->route('order.success')->with('message', 'Order placed successfully!');
    }
}
