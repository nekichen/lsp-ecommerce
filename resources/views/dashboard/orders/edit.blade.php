@extends('dashboard.layout.layout')

@section('title', 'Edit Orders')
@section('page', 'Edit Orders')
@section('content')
    <div class="w-full flex mb-14 rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800 dark:text-gray-300">
        <div class="w-1/2 px-6 py-4">
            <div class="font-bold text-xl mb-2">Order Details</div>
            <div class="mb-4">
                <p class="text-gray-700 dark:text-gray-300"><strong>Invoice Number:</strong> {{ $orders->invoice_number }}
                </p>
                @if ($orders->customer_id == $customers->id)
                    <p class="text-gray-700 dark:text-gray-300"><strong>Customer Name:</strong>
                        {{ $customers->first_name . ' ' . $customers->last_name }}</p>
                @endif
                <p class="text-gray-700 dark:text-gray-300"><strong>Order Date & Time:</strong>
                    {{ $orders->order_date }}
                </p>
            </div>
            <div class="mb-4">
                <h2 class="font-semibold text-lg mb-2 dark:text-gray-300">Items Ordered</h2>
                <ul class="list-disc list-inside">
                    @foreach ($orderDetails as $orderDetail)
                        @php
                            $product = $products->firstWhere('id', $orderDetail->product_id);
                            $image = $product ? $images->firstWhere('product_id', $product->id) : null;
                            $size = $sizes->firstWhere('id', $orderDetail->size_id);
                        @endphp
                        <li class="text-gray-700 dark:text-gray-300 flex items-start mb-2">
                            @if ($image)
                                <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                    class="w-14 h-14 object-cover mr-4">
                            @endif
                            <div>
                                <div>
                                    <span class="font-semibold">{{ $product->name }} ({{ $size->code }})</span>
                                </div>
                                <div>
                                    <span>${{ number_format($product->price, 2) }} x {{ $orderDetail->quantity }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="border-t pt-4">
                @if ($payments->order_id == $orders->id)
                    <p class="text-gray-700 dark:text-gray-300 text-lg font-bold"><strong>Payment Method:</strong>
                        @if ($payments->payment_method == 'cod')
                            Cash On Delivery ({{ $payments->payment_status }})
                        @elseif ($payments->payment_method == 'bank transfer')
                            Bank Transfer ({{ $payments->payment_status }})
                        @elseif ($payments->payment_method == 'paypal')
                            Paypal ({{ $payments->payment_status }})
                        @endif
                    </p>
                    @if ($payments->payment_method == 'bank transfer' && $payments->payment_status != 'cancelled')
                        <p class="text-gray-700 dark:text-gray-300 text-lg font-bold"><strong>Account number:</strong>
                            {{ $payments->account_number }}</p>
                    @endif
                @endif
                <p class="text-gray-700 dark:text-gray-300 text-lg font-bold"><strong>Total Amount:</strong>
                    ${{ number_format($orders->grand_total, 2) }}</p>
                <p class="text-gray-700 dark:text-gray-300 text-lg font-bold"><strong>Total Discount:</strong>
                    ${{ number_format($orders->discount_amount, 2) }}</p>
            </div>
        </div>
        <div class="w-1/2 px-6 py-4">
            <h2 class="text-2xl font-bold mb-4 dark:text-gray-300">Update Order Status</h2>
            <form action="{{ route('orders.update', $orders->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Status</label>
                    @if ($orders->status == 'Cancelled')
                        <select disabled
                            class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <option value="Cancelled" selected>Cancelled</option>
                        </select>
                    @elseif ($orders->status == 'Delivered')
                        <select disabled
                            class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <option value="Delivered" selected>Delivered</option>
                        </select>
                    @else
                        <select name="status" id="status"
                            class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <option value="Pending"
                                @if ($orders->status == 'Pending') selected @elseif ($orders->status == 'Processing' || $orders->status == 'Shipped' || $orders->status == 'Delivered') disabled @endif>
                                Pending</option>
                            <option value="Processing"
                                @if ($orders->status == 'Processing') selected @elseif ($orders->status == 'Shipped' || $orders->status == 'Delivered') disabled @endif>
                                Processing</option>
                            <option value="Shipped"
                                @if ($orders->status == 'Shipped') selected @elseif ($orders->status == 'Delivered') disabled @endif>
                                Shipped</option>
                            <option value="Delivered" @if ($orders->status == 'Delivered') selected @endif>Delivered</option>
                            <option value="Cancelled" @if ($orders->status == 'Cancelled') selected @endif>Cancelled</option>
                        </select>
                    @endif
                </div>
                <div class="mt-6 flex @if ($orders->status == 'Cancelled' || $orders->status == 'Delivered') justify-center @else justify-between @endif">
                    @if ($orders->status != 'Cancelled' && $orders->status != 'Delivered')
                        <button type="submit"
                            class="w-1/2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                            Update Status
                        </button>
                    @endif
                    <a href="{{ route('orders.index') }}"
                        class="w-1/2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md ml-4 text-center">
                        Back
                    </a>
                </div>
            </form>
        </div>
    @endsection
