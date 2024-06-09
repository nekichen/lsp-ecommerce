@extends('landing.layout.main')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('shop') }}">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            @if ($cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="shopping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        @if ($item->model)
                                            <tr>
                                                <td class="product__cart__item">
                                                    <div class="product__cart__item__pic">
                                                        <a href="{{ route('product', $item->model->slug) }}">
                                                            @if (isset($images[$item->id]))
                                                                <img src="{{ asset('storage/' . $images[$item->id]->image) }}"
                                                                    alt="{{ $item->model->name }}" class="cart-img">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="product__cart__item__text">
                                                        <a href="{{ route('product', $item->model->slug) }}">
                                                            <h6>{{ $item->model->name }} ({{ $item->options->size }})</h6>
                                                        </a>
                                                        <h5>${{ $item->price }}</h5>
                                                    </div>
                                                </td>
                                                <td class="quantity__item">
                                                    <div class="quantity">
                                                        <div class="pro-qty-2">
                                                            <input type="text" data-rowid="{{ $item->rowId }}"
                                                                value="{{ $item->qty }}"
                                                                onchange="updateQuantity(this)">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart__price">${{ number_format($item->price * $item->qty, 2) }}
                                                </td>
                                                <td class="cart__close">
                                                    <a onclick="removeItem('{{ $item->rowId }}')">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn">
                                    <a href="{{ route('shop') }}">Continue Shopping</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn update__btn">
                                    <button onclick="clearCart()"><i class="fa fa-rotate-right"></i> Clear cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__discount">
                            <h6>Discount codes</h6>
                            <form action="{{ route('apply-coupon') }}" method="POST">
                                @csrf
                                <input type="text" placeholder="Coupon code" name="coupon_code">
                                <button type="submit">Apply</button>
                            </form>
                        </div>
                        <div class="cart__total">
                            <h6>Cart total</h6>
                            <ul>
                                <li>Subtotal
                                    @if (session('discounted_total'))
                                        <span>${{ number_format(session('discounted_total'), 2) }}</span>
                                    @else
                                        <span>${{ Cart::instance('cart_' . Auth::user()->id)->subtotal() }}</span>
                                    @endif
                                </li>
                                <li>Total
                                    @if (session('discounted_total'))
                                        <span>${{ number_format(session('discounted_total'), 2) }}</span>
                                    @else
                                        <span>${{ Cart::instance('cart_' . Auth::user()->id)->total() }}</span>
                                    @endif
                                </li>
                                <li>Discount
                                    @if (session('discount_amount'))
                                        <span>
                                            -
                                            ${{ number_format(session('discount_amount'), 2) }}</span>
                                    @else
                                        <span>$0.00</span>
                                    @endif
                                </li>
                            </ul>
                            <a href="{{ route('checkout') }}" class="primary-btn">Proceed to checkout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Your cart is empty</h2>
                        <h5 class="mt-3">Add items to get started</h5>
                        <a href="{{ route('shop') }}" class="primary-btn mt-5">Continue Shopping</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Shopping Cart Section End -->

    <form action="{{ route('update-cart') }}" id="update-cart" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="rowId" id="rowId">
        <input type="hidden" name="quantity" id="quantity">
    </form>

    <form action="{{ route('remove-item') }}" id="item-remove" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="rowId_D" id="rowId_D">
    </form>

    <form action="{{ route('clear-cart') }}" id="clear-cart" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Function to update item subtotal
        function updateItemSubtotal(input) {
            var rowId = $(input).data('rowid');
            var quantity = $(input).val();
            var price = parseFloat($(input).closest('tr').find('.cart__price').data('price'));
            var subtotal = quantity * price;
            $(input).closest('tr').find('.cart__price').text('$' + subtotal.toFixed(2));

            // Recalculate total by summing up all item subtotals
            var total = 0;
            $('.cart__price').each(function() {
                total += parseFloat($(this).text().replace('$', ''));
            });
            // Update displayed total
            $('.cart__total span').text('$' + total.toFixed(2));
        }

        // Bind quantity change event to all quantity inputs
        $('.quantity__item input').on('change', function() {
            updateItemSubtotal(this);
        });

        // JavaScript function to handle quantity change event
        function updateQuantity(qty) {
            var rowId = $(qty).data('rowid');
            var quantity = $(qty).val();

            $('#rowId').val(rowId);
            $('#quantity').val(quantity);

            $('#update-cart').submit();
        }

        function removeItem(rowId) {
            $('#rowId_D').val(rowId);
            $('#item-remove').submit();
        }

        function clearCart() {
            $('#clear-cart').submit();
        }
    </script>
@endsection
