@extends('landing.layout.main')

@section('content')
    <section>
        <div class="breadcrumb-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__text">
                            <h4>Orders</h4>
                            <div class="breadcrumb__links">
                                <a href="{{ route('home') }}">Home</a>
                                <span>Orders</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mr-5">
                    <div class="list-group">
                        <a href="{{ route('profile') }}"
                            class="list-group-item list-group-item-action @if (Route::currentRouteName() == 'profile') active @endif"
                            aria-current="true">
                            Your Account
                        </a>
                        <a href="{{ route('orders') }}"
                            class="list-group-item list-group-item-action @if (Route::currentRouteName() == 'orders') active @endif">
                            Your Orders
                        </a>
                    </div>
                </div>
                <div class="col d-flex">
                    @if ($orders->isEmpty())
                        <div class="col-lg-12 text-center">
                            <h2>No Orders</h2>
                            <a href="{{ route('shop') }}" class="site-btn mt-4">Shop Now</a>
                        </div>
                    @else
                        <h2>Your Orders</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Order Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->invoice_number }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>${{ $order->total }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td><a href="#">View Details</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
