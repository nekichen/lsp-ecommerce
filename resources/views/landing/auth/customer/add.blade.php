@extends('landing.layout.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Add Customer Details</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('profile') }}">Profile</a>
                            <a href="{{ route('customer-address') }}">Customer's Addresses</a>
                            <span>Add Customer Details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="spad">
        <div class="container">
            {{-- Form Customer Begin --}}
            <div class="checkout__form">
                <form action="{{ route('add-address') }}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-md-12">
                        <h6 class="checkout__title">Add Customer Details</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>First Name<span>*</span></p>
                                    <input type="text" name="first_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="last_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Country/State<span>*</span></p>
                                    <input type="text" placeholder="Country" name="country">
                                    {{-- <select class="mt-2 mb-3">
                                        <option value="" disabled selected>Select a country</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->iso2 }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <input type="text" placeholder="State" name="state">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Address<span>*</span></p>
                                    <input type="text" placeholder="Street Address" class="checkout__input__add"
                                        name="address">
                                    <input type="text" placeholder="Apartment, suite, unite ect (optinal)"
                                        name="apartment">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text"name="city">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text" name="zip_code">
                        </div>
                        <div class="checkout__input">
                            <p>Phone<span>*</span></p>
                            <input type="text" name="phone">
                        </div>
                        <button type="submit" class="site-btn">Update Details</button>
                        <a href="{{ route('customer-address') }}" class="site-btn">Back to customer's addresses</a>
                    </div>
                </form>
            </div>
            {{-- Form Customer End --}}
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
