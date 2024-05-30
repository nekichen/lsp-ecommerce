@extends('landing.layout.main')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Update Profile</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('profile') }}">Profile</a>
                            <span>Update Profile</span>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="contact__form">
                        <form action="{{ route('update-profile') }}" method="POST">
                            @csrf
                            <div class="row">
                                <p>Your Name</p>
                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                                <p>Your Email</p>
                                <input type="text" name="email" value="{{ Auth::user()->email }}">
                                <div class="row">
                                    <div class="col-lg-6 d-flex">
                                        <button type="submit" class="site-btn">Update User</button>
                                    </div>
                                    <div class="col-lg-6 d-flex">
                                        <a href="{{ route('profile') }}" class="site-btn">Back to profile</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
