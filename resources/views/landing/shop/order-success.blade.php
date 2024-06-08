@extends('landing.layout.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Checkout</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('shop') }}">Shop</a>
                            <a href="{{ route('cart') }}">Shopping Cart</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="spad">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Order Successful</h2>
                    <p>Thank you for your purchase! Your order has been placed successfully.</p>
                    <a href="{{ route('shop') }}" class="primary-btn mt-5">Your Orders</a>
                </div>
            </div>
        </div>
    </section>
@endsection
