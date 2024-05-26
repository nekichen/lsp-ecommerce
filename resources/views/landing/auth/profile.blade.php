@extends('landing.layout.main')
@section('content')
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
                            <div class="col-lg-6">
                                <form action="{{ route('update-profile') }}" method="POST">
                                    @csrf
                                    <input type="text" placeholder="Change Your Name" name="name">
                                    <input type="email" placeholder="Change Your Email" name="email">
                                    <button type="submit" class="site-btn">Update Profile</button>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ route('change-password') }}" method="POST">
                                    @csrf
                                    <input type="password" placeholder="Type Your Old Password" name="old_password">
                                    <input type="password" placeholder="Type Your New Password" name="password">
                                    <div class="row">
                                        <div class="col d-flex justify-content-start">
                                            <button type="submit" class="pass-btn">Change Password</button>
                                        </div>
                                </form>
                                <div class="col d-flex justify-content-end">
                                    <form action="{{ route('delete-account') }}" method="POST" id="form">
                                        @csrf
                                        <button type="submit" class="del-btn" id="del-btn" onclick="return confirm('Are you sure?')">Delete Account</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
