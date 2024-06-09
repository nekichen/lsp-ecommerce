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
        $cart = Cart::instance('cart_' . $user->id);

        // Get the current quantity in the cart for the item
        $currentQuantity = $cart->get($request->rowId)->qty;

        // Get the product associated with the cart item
        $product = Products::find($cart->get($request->rowId)->id);

        // Check if the requested quantity exceeds the available stock
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock.');
        }

        // Update the cart
        $cart->update($request->rowId, $request->quantity);

        // Clear any discount-related session data
        Session::forget(['discount_code', 'discounted_total', 'discount_amount', 'total_amount']);

        return redirect()->back();
    }

    public function removeItem(Request $request)
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->remove($request->rowId_D);
        Session::forget(['discount_code', 'discounted_total', 'discount_amount', 'total_amount']);
    
        return redirect()->back();
    }

    public function clearCart()
    {
        $user = Auth::user();
        Cart::instance('cart_' . $user->id)->destroy();
        Session::forget(['discount_code', 'discounted_total', 'discount_amount', 'total_amount']);
    
        return redirect()->back();
    }

    public function checkout()
    {
        $user = Auth::user();
        $cartInstance = Cart::instance('cart_' . $user->id);
        $cartItems = $cartInstance->content();

        $subtotal = floatval(str_replace(',', '', $cartInstance->subtotal())); // Gunakan subtotal sebagai dasar perhitungan
        $total_amount = session('total_amount', $subtotal); // Ambil total_amount dari sesi jika tersedia

        // Ambil informasi kupon dari sesi jika tersedia
        $discountCode = session('discount_code');
        $discountedTotal = session('discounted_total', 0);
        $discountAmount = session('discount_amount', 0);

        // Hitung total pesanan setelah diskon
        $total = $total_amount - $discountAmount;

        // Mendapatkan alamat pengiriman pengguna
        $addresses = Customers::where('user_id', $user->id)->with('country')->get();

        if ($addresses->isEmpty()) {
            return redirect()->route('add-address-page')->with('error', 'Please add an address to proceed.');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Cart is empty');
        }

        // Pass data ke view checkout
        return view('landing.shop.checkout', compact('cartItems', 'subtotal', 'total_amount', 'addresses', 'discountCode', 'discountedTotal', 'total'));
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        // Validate the coupon code
        if (empty($couponCode)) {
            return redirect()->back()->with('error', 'Coupon code is required.');
        }

        // Find the discount associated with the coupon code
        $discount = Discounts::where('code', $couponCode)
                            ->where('is_active', true)
                            ->whereDate('start_date', '<=', now())
                            ->whereDate('end_date', '>=', now())
                            ->first();

        if ($discount) {
            // Check if the discount has reached its maximum usage per order
            if ($this->discountReachedMaxUsage($discount)) {
                return redirect()->back()->with('error', 'Coupon has reached its maximum usage per order.');
            }

            $user = Auth::user();
            $cartInstance = Cart::instance('cart_' . $user->id);
            $subtotal = (float) str_replace(',', '', $cartInstance->subtotal());
            $discountedTotal = 0;

            // Calculate the discount amount
            $discountAmount = ($discount->type == 'fixed') ? $discount->amount : ($subtotal * $discount->amount / 100);

            // Check if the discount has reached its maximum usage per user
            if ($this->discountReachedMaxUserUsage($discount, $user)) {
                return redirect()->back()->with('error', 'Coupon has reached its maximum usage per user.');
            }

            // Calculate the discounted total
            $discountedTotal = max($subtotal - $discountAmount, 0);

            // Store discount information in the session
            session([
                'discounted_total' => $discountedTotal,
                'discount_code' => $couponCode,
                'total_amount' => $subtotal,
                'discount_amount' => $discountAmount
            ]);

            // Increment the usage count for the discount
            $this->incrementUsageCount($discount);

            return redirect()->back()->with('success', 'Coupon applied successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid or inactive coupon code. Please try again.');
        }
    }

    // Check if the discount has reached its maximum usage per order
    public function discountReachedMaxUsage($discount)
    {
        $user = Auth::user();
        $usageCount = Session::get('discount_usage_' . $user->id . '_' . $discount->id, 0);
        return $discount->max_use !== null && $usageCount >= $discount->max_use;
    }

    // Check if the discount has reached its maximum usage per user
    public function discountReachedMaxUserUsage($discount, $user)
    {
        $usageCount = Session::get('discount_usage_user_' . $discount->id . '_' . $user->id, 0);
        return $discount->max_user !== null && $usageCount >= $discount->max_user;
    }

    // Increment the usage count for the discount
    public function incrementUsageCount($discount)
    {
        // Increment overall usage count
        $usageCount = Session::get('discount_usage_' . $discount->id, 0);
        $usageCount++;
        Session::put('discount_usage_' . $discount->id, $usageCount);

        // Increment usage count per user
        $user = Auth::user();
        $usageCountUser = Session::get('discount_usage_user_' . $discount->id . '_' . $user->id, 0);
        $usageCountUser++;
        Session::put('discount_usage_user_' . $discount->id . '_' . $user->id, $usageCountUser);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cod,bank transfer,paypal',
            'account_number' => 'required_if:payment_method,bank transfer|numeric',
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

        $discountID = Discounts::where('code', session('discount_code'))->first()->id ?? null;
        $grandTotal = number_format(session('discounted_total'), 2, '.', '');

        $order = new Orders();
        $order->invoice_number = uniqid('INV-');
        $order->customer_id = $customer->id;
        $order->discount_id = $discountID;
        $order->order_date = now();
        $order->total = number_format($total_amount, 2, '.', '');
        $order->discount_amount = number_format(session('total_amount') - session('discounted_total'), 2, '.', ''); // Jumlah diskon yang diterapkan
        $order->grand_total = $grandTotal;
        $order->notes = $request->notes;
        $order->status = 'Pending';
        $order->save();

        $paymentStatus = '';

        if($request->payment_method == 'cod'){
            $paymentStatus = 'not paid';
        } else{
            $paymentStatus = 'paid';
        }

        $payment = new Payments();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer->id;
        $payment->amount = $grandTotal;
        $payment->payment_date = now();
        $payment->payment_method = $request->payment_method;
        $payment->account_number = $request->account_number;
        $payment->payment_status = $paymentStatus;
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

        Session::forget(['discount_id', 'discounted_total', 'total_amount', 'discount_code', 'discount_amount']);

        Cart::instance('cart_' . $user->id)->destroy();

        return redirect()->route('order.success')->with('message', 'Order placed successfully!');
    }
}
