@extends('landing.layout.main')
@section('content')
    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('shop') }}">Shop</a>
                            <span>{{ $product->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="owl-carousel">
                            @foreach ($images as $item)
                                <div>
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->name }}</h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            <h3>${{ $product->price }}</h3>
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    @foreach ($size as $item)
                                        <label for="{{ $item->name }}">{{ $item->code }}</label>
                                        <input type="radio" id="{{ $item->name }}" name="size"
                                            value="{{ $item->code }}" required>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" id="qty">
                                    </div>
                                </div>
                                @if (isset($product))
                                    <button class="primary-btn"
                                        onclick="addToCart()">add
                                        to cart</button>
                                    <form action="{{ route('add-to-cart') }}" id="add-to-cart" method="POST">
                                        @csrf
                                        @if (isset($product->id))
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                        @endif
                                        <input type="hidden" name="quantity" id="hidden-qty">
                                        <input type="hidden" name="size" id="selected-size" value="">
                                    </form>
                                @else
                                    <p>Product not found.</p>
                                @endif
                            </div>
                            <div class="product__details__btns__option">
                                @if (isset($product))
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('wishlist-add-{{ $product->id }}').submit()">
                                        <i class="fa fa-heart"></i> add to wishlist
                                    </a>
                                    <form action="{{ route('wishlist-add') }}" id="wishlist-add-{{ $product->id }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                    </form>
                                @else
                                    <p>Product not found.</p>
                                @endif
                            </div>
                            <div class="product__details__last__option">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                        role="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                        Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $product->description }}</p>
                                        <div class="product__details__tab__content__item">
                                            <div class="product__details__last__option">
                                                <ul>
                                                    <li><span>SKU:</span> {{ $product->sku }}</li>
                                                    <li><span>Categories:</span> {{ $category->name }}</li>
                                                    <li><span>Brand:</span> {{ $brand->name }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                                a touchscreen and touchpad.</p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                                $350.00, a new Pocket PC can now be purchased.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                                worn all year round.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Product</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProducts as $item)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="
                                @php($productImages = $relatedImages->where('product_id', $item->id))
                                @if ($productImages->count() > 0) @foreach ($productImages as $image)
                                        {{ asset('storage/' . $image->image) }}"
                                    @endforeach @endif>
                                <ul class="product__hover">
                                <li><a href="#"><img src="{{ asset('assets/img/icon/heart.png') }}"
                                            alt=""></a></li>
                                <li><a href="{{ route('product', $item->slug) }}"><img
                                            src="{{ asset('assets/img/icon/search.png') }}" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $item->name }}</h6>
                                <a href="#" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <h5>${{ $item->price }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Section End -->

    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            var imageCount = owl.find('img').length;
            var maxItems = 4; // Set the maximum number of items to display

            owl.owlCarousel({
                loop: true,
                nav: true,
                margin: 10,
                items: Math.min(imageCount, maxItems),
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: Math.min(imageCount, maxItems)
                    }
                }
            });

            owl.on('mousewheel', '.owl-stage', function(e) {
                if (e.originalEvent.deltaY > 0) {
                    owl.trigger('next.owl.carousel');
                } else {
                    owl.trigger('prev.owl.carousel');
                }
                e.preventDefault();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputs = document.querySelectorAll('input[name="size"]');
            const selectedSizeInput = document.getElementById('selected-size');

            sizeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    selectedSizeInput.value = this.value;
                });
            });

            // Set the default size if one is selected by default
            const defaultSize = document.querySelector('input[name="size"]:checked');
            if (defaultSize) {
                selectedSizeInput.value = defaultSize.value;
            }
        });

        function addToCart() {
            const qtyInput = document.getElementById('qty');
            const hiddenQtyInput = document.getElementById('hidden-qty');
            hiddenQtyInput.value = qtyInput.value; // Update hidden input value
            document.getElementById('add-to-cart').submit(); // Submit the form
        }
    </script>
@endsection
