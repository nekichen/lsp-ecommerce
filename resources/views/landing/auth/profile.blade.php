@extends('landing.layout.main')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Profile</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Your Name</span>
                        <h2>{{ Auth::user()->name }}</h2>
                        <span>Your Email</span>
                        <h2>{{ Auth::user()->email }}</h2>
                    </div>
                    <div class="contact__form">
                        <div class="row">
                            <div class="col d-flex">
                                <a href="{{ route('update-profile-page') }}" class="site-btn">Update Profile</a>
                            </div>
                            <div class="col d-flex">
                                <a href="{{ route('customer-address') }}" class="site-btn">Customer's Addresses</a>
                            </div>
                            <div class="col d-flex">
                                <a href="#" class="pass-btn">Change Password</a>
                            </div>
                            <div class="col d-flex">
                                <button type="submit" class="del-btn" id="del-btn"
                                    onclick="return confirm('Are you sure?')">Delete Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
