<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Payments;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Products;

class DashboardController extends Controller
{
    //
    public function __construct() {
        $this->middleware('admin.auth');
    }

    public function index() {
        $customersCount = Customers::count();
        $accountBalance = Payments::sum('amount');
        $recentCustomers = Customers::latest()->take(5)->get();
        $recentOrders = Orders::orderBy('id', 'desc')->limit(5)->get();

        $orderIds = $recentOrders->pluck('id');
        $orderDetails = OrderDetails::whereIn('order_id', $orderIds)->get();
        $productIds = $orderDetails->pluck('product_id');
        $productsOrdered = Products::whereIn('id', $productIds)->get();

        $paymentOrder = [];

        foreach ($recentOrders as $order) {
            $payments = Payments::where('order_id', $order->id)->get();
            if ($payments->isNotEmpty()) {
                foreach ($payments as $payment) {
                    if (isset($payment->amount)) {
                        $paymentOrder[] = $payment->amount;
                    }
                }
            }
        }

        $totalOrders = Orders::count();

        return view('dashboard.index', compact('customersCount', 'accountBalance', 'recentCustomers', 'recentOrders', 'paymentOrder', 'totalOrders', 'productsOrdered', 'orderDetails'));
    }
}
