@extends('landing.layout.main')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/hero/hero-1.png') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>HOSHI-ON! PRESENTING</h6>
                                <h2>The New Era of Fashion</h2>
                                <p>"Style Speaks Louder Than Words: Unveil Your Fashion Identity Today!"</p>
                                <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{ asset('assets/img/hero/hero-2.png') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Our Picks</li>
                        <li data-filter=".best-seller">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @foreach ($bestSeller as $item)
                    @if ($item->active == 'yes' && $item->stock > 0)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix best-seller">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="
                        @php($productImages = $images->where('product_id', $item->id))
                                @if ($productImages->count() > 0) @foreach ($productImages as $image)
                                            {{ asset('storage/' . $image->image) }}"
                                        @endforeach @endif>
                                <span class="label">
                                    BEST SELLER</span>
                                    <ul class="product__hover">
                                        <li><a href="#"
                                                onclick="addToWishlist({{ $item->id }}, '{{ $item->name }}', 1, '{{ $item->price }}')">
                                                <img src="{{ asset('assets/img/icon/heart.png') }}" alt=""></a></li>
                                        <li><a href="{{ route('product', $item->slug) }}"><img
                                                    src="{{ asset('assets/img/icon/search.png') }}" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $item->name }}</h6>
                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item->averageRating)
                                                <i class="fa fa-star" style="color: gold;"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <h5>${{ $item->price }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @foreach ($products as $item)
                    @if ($item->active == 'yes' && $item->stock > 0 && !in_array($item->id, $bestSeller->pluck('id')->toArray()))
                        <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="
                        @php($productImages = $images->where('product_id', $item->id))
                                @if ($productImages->count() > 0) @foreach ($productImages as $image)
                                            {{ asset('storage/' . $image->image) }}"
                                        @endforeach @endif>
                                <span class="label">
                                    New</span>
                                    <ul class="product__hover">
                                        <li><a href="#"
                                                onclick="addToWishlist({{ $item->id }}, '{{ $item->name }}', 1, '{{ $item->price }}')">
                                                ><img src="{{ asset('assets/img/icon/heart.png') }}" alt=""></a>
                                        </li>
                                        <li><a href="{{ route('product', $item->slug) }}"><img
                                                    src="{{ asset('assets/img/icon/search.png') }}" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $item->name }}</h6>
                                    <a href="{{ route('product', $item->slug) }}" class="add-cart">+ Add To Cart</a>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $item->averageRating)
                                                <i class="fa fa-star" style="color: gold;"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <h5>${{ $item->price }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <script>
        function addToWishlist(id, name, quantity, price) {
            $.ajax({
                type: "POST",
                url: "{{ route('wishlist-add') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name,
                    quantity: quantity,
                    price: price
                },
                success: function(data) {
                    window.location.reload();
                }
            })
        }
    </script>
@endsection
