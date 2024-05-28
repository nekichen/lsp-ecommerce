<!-- Header Section Begin -->
<header class="header">
    <!-- <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                                <a href="#">Sign in</a>
                                <a href="#">FAQs</a>
                            </div>
                            <div class="header__top__hover">
                                <span>Usd <i class="arrow_carrot-down"></i></span>
                                <ul>
                                    <li>USD</li>
                                    <li>EUR</li>
                                    <li>USD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                        <li class="{{ request()->is('shop') || request()->is('shop/*') ? 'active' : '' }}"><a
                                href="{{ route('shop') }}">Shop</a>
                        </li>
                        {{-- <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="./about.html">About Us</a></li>
                                <li><a href="#">Shop Details</a></li>
                                <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                                <li><a href="./checkout.html">Check Out</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contacts</a></li> --}}
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#" class="search-switch"><img src="{{ asset('assets/img/icon/search.png') }}"
                            alt=""></a>
                    <a href="{{ route('wishlist') }}"><img src="{{ asset('assets/img/icon/heart.png') }}"
                            alt="">
                    </a>
                    <a href="{{ route('cart') }}"><img src="{{ asset('assets/img/icon/cart.png') }}" alt="">
                        @if (Auth::check())
                            <span>{{ Cart::instance('cart_' . Auth::user()->id)->content()->count() }}</span>
                        @endif
                    </a>
                    <!-- resources/views/landing/layout/header.blade.php -->
                    @if (Auth::check())
                        <a href="#" onclick="$('#userProfileModal').modal('show'); return false;"><img
                                src="{{ asset('assets/img/icon/user.png') }}" alt=""></a>
                        @include('landing.auth.user')
                    @else
                        <a href="{{ route('login') }}" class="user">
                            Log in
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>
<!-- Header Section End -->
