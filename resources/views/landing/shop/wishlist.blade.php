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
            <div class="row">
                {{-- <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="{{ url()->current() }}" method="GET">
                                @if (request()->get('brand'))
                                    <input type="hidden" name="brand" value="{{ request()->get('brand') }}">
                                @endif
                                @if (request()->get('sort'))
                                    <input type="hidden" name="sort" value="{{ request()->get('sort') }}">
                                @endif
                                <input type="text" placeholder="Search..." name="search"
                                    value="{{ $request->get('search') }}">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul>
                                                    <li><a href="{{ route('shop') }}"
                                                            class="{{ $categorySelected == null ? 'active' : '' }}">All</a>
                                                    </li>
                                                    @foreach ($categories as $item)
                                                        <li>
                                                            <a href="{{ route('shop.category', $categorySlug = $item->slug) }}"
                                                                class="{{ $categorySelected == $item->id ? 'active' : '' }}">
                                                                {{ $item->name }}
                                                                @if ($item->products)
                                                                    ({{ $item->products->where('active', 'yes')->count() }})
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__brand">
                                                <ul>
                                                    @foreach ($brands as $item)
                                                        <li>
                                                            <input
                                                                {{ in_array($item->slug, $brandSlugs) ? 'checked' : '' }}
                                                                type="checkbox" id="{{ $item->id }}" name="brand[]"
                                                                value="{{ $item->slug }}" class="brand-select">
                                                            <label class="brand-label" for="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing
                                        @if ($products->count() > 0)
                                            {{ $products->firstItem() }}–{{ $products->count() }}
                                        @else
                                            {{ $products->count() }}
                                        @endif
                                        of {{ $products->total() }} results
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select id="sort" onchange="sortByPrice()">
                                        <option value="low" {{ $sort == 'low' ? 'selected' : '' }}>Low to High</option>
                                        <option value="high" {{ $sort == 'high' ? 'selected' : '' }}>High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> --}}
                        @foreach ($wishlistItems as $item)
                            {{-- @if ($item->active == 'yes') --}}
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="
                                        @if (isset($images[$item->id])) {{ asset('storage/' . $images[$item->id]->image) }} @endif">
                                        <ul class="product__hover">
                                            @if (isset($item))
                                                <li><a href="#"
                                                        onclick="event.preventDefault(); document.getElementById('wishlist-add').submit()">
                                                        <img src="{{ asset('assets/img/icon/heart.png') }}" alt="">
                                                    </a>
                                                    <form action="{{ route('wishlist-add') }}" id="wishlist-add"
                                                        method="POST">
                                                        @csrf
                                                        @if (isset($item->id))
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                        @endif
                                                        <input type="hidden" name="quantity" value="1">
                                                    </form>
                                                </li>
                                            @endif
                                            <li><a href="{{ route('product', $product->slug) }}">
                                                    <img src="{{ asset('assets/img/icon/search.png') }}" alt="">
                                                </a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6>{{ $item->name }}</h6>
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
                                        <h5>${{ $item->price }}</h5>
                                    </div>
                                </div>
                            </div>
                            {{-- @endif --}}
                        @endforeach
                    </div>
                    {{-- <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                {{ $wishlistItems->links() }}
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

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
