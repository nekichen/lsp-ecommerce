@extends('landing.layout.main')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Wishlist</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Wishlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            @if ($wishlistItems->count() > 0)
                <div class="row">
                    <div class="col-lg-12">
                        @if ($wishlistItems->count() > 1)
                            <p>Showing {{ $wishlistItems->count() }} items in your wishlist. 
                                <a href="javascript:void(0)" onclick="clearWishlist()">Clear</a>
                            </p>
                        @else
                            <p>Showing {{ $wishlistItems->count() }} item in your wishlist. 
                                <a href="javascript:void(0)" onclick="clearWishlist()">Clear</a>
                            </p>
                        @endif
                    </div>
                    @foreach ($wishlistItems as $item)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="
                                        @if (isset($images[$item->id])) {{ asset('storage/' . $images[$item->id]->image) }} @endif">
                                    <ul class="product__hover">
                                        <li><a href="javascript:void(0)"
                                                onclick="removeFromWishlist('{{ $item->rowId }}')">
                                                <img src="{{ asset('assets/img/icon/heart-red.png') }}" alt="">
                                            </a>
                                        </li>
                                        <li><a href="{{ route('product', $item->model->slug) }}"><img
                                                    src="{{ asset('assets/img/icon/search.png') }}" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $item->model->name }}</h6>
                                    @if (isset($item))
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('add-to-cart').submit()"
                                            class="add-cart">
                                            + Add To Cart
                                        </a>
                                        <form action="{{ route('add-to-cart') }}" id="add-to-cart" method="POST">
                                            @csrf
                                            @if (isset($item->id))
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                            @endif
                                            <input type="hidden" name="quantity" value="1">
                                        </form>
                                    @endif
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <h5>${{ $item->model->price }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Your wishlist is empty</h2>
                        <h5 class="mt-3">Add items to get started</h5>
                        <a href="{{ route('shop') }}" class="primary-btn mt-5">Continue Shopping</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Shop Section End -->

    <form action="{{ route('wishlist-remove') }}" id="wishlist-remove" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="rowId" id="rowId">
    </form>

    <form action="{{ route('wishlist-clear') }}" id="wishlist-clear" method="post">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function removeFromWishlist(rowId) {
            $('#rowId').val(rowId);
            $('#wishlist-remove').submit();
        }

        function clearWishlist() {
            $('#wishlist-clear').submit();
        }
    </script>
    {{-- <script>
        function sortByPrice() {
            var sortValue = document.getElementById('sort').value;
            var url = new URL(window.location.href);

            if (sortValue !== '1') {
                url.searchParams.set('sort', sortValue);
            } else {
                url.searchParams.delete('sort');
            }

            window.location.href = url.toString();
        }

        $('.brand-select').change(function() {
            filterByBrand();
        });

        function filterByBrand() {
            var brands = [];

            $('.brand-select').each(function() {
                if (this.checked) {
                    brands.push(this.value);
                }
            });

            var url = new URL(window.location.href);

            if (brands.length > 0) {
                url.searchParams.set('brand', brands.toString());
            } else {
                url.searchParams.delete('brand');
            }

            window.location.href = url.toString();
        }
    </script> --}}
@endsection
