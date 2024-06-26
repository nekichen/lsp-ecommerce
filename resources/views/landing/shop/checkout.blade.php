@extends('landing.layout.main')

@section('content')
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="coupon__code"><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click
                                    here</a> to enter your code</h6>
                            <h6 class="checkout__title">Billing Details</h6>
                            <div class="checkout__input">
                                <div class="card mb-5">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @if ($addresses->isNotEmpty())
                                                    <p id="selectedCustomerName">{{ $addresses->first()->first_name }}
                                                        {{ $addresses->first()->last_name }}</p>
                                                    <p id="selectedCustomerPhone">{{ $addresses->first()->phone }}</p>
                                                    <p id="selectedCustomerAddress">{{ $addresses->first()->address }}</p>
                                                    <p id="selectedCustomerCity">{{ $addresses->first()->city }}</p>
                                                    <p id="selectedCustomerCountry">{{ $addresses->first()->country->name }}
                                                    </p>
                                                    <p id="selectedCustomerZip">{{ $addresses->first()->zip_code }}</p>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <a href="{{ route('customer-address') }}"
                                                    class="btn btn-sm btn-primary">Change Address</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Order notes<span> (Optional)</span></p>
                                <input type="text" placeholder="Notes about your order, e.g. special notes for delivery."
                                    name="notes">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach ($cartItems as $item)
                                        <li>{{ $item->name }} ({{ $item->options->size }}) x {{ $item->qty }}
                                            <span>${{ number_format($item->price * $item->qty, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                @if (is_numeric($total) && is_numeric($total_amount))
                                    <ul class="checkout__total__all">
                                        <li>Subtotal <span>${{ number_format($total, 2) }}</span></li>
                                        <li>Total <span>${{ number_format($total_amount, 2) }}</span></li>
                                        @if (session('total_amount') != session('discounted_total'))
                                            <li> Discount <span>${{ number_format(session('discount_amount'), 2) }}</span>
                                            </li>
                                            <li class="discount">Discount applied <b>({{ session('discount_code') }})</b>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                                <input type="hidden" name="address_id" value="{{ $addresses->first()->id }}">
                                <div class="checkout__input__checkbox">
                                    <label for="cod">
                                        Cash on Delivery
                                        <input type="radio" id="cod" name="payment_method" value="cod" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="bank_transfer">
                                        Bank Transfer
                                        <input type="radio" id="bank_transfer" name="payment_method"
                                            value="bank transfer">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        PayPal
                                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="account_number_field" id="account_number_field" style="display: none;">
                                    Account Number<span>*</span>: <input type="text" name="account_number">
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <script>
        // Get the radio buttons
        var codRadio = document.getElementById('cod');
        var bankTransferRadio = document.getElementById('bank_transfer');
        var paypalRadio = document.getElementById('paypal');
        var accountNumberField = document.getElementById('account_number_field');

        // Add event listener to cod radio button
        codRadio.addEventListener('change', function() {
            // If cod is selected, show the account number field
            if (this.checked) {
                accountNumberField.style.display = 'none';
            }
        });
        
        // Add event listener to bank transfer radio button
        bankTransferRadio.addEventListener('change', function() {
            // If bank transfer is selected, show the account number field
            if (this.checked) {
                accountNumberField.style.display = 'block';
            } else {
                // If not, hide the account number field
                accountNumberField.style.display = 'none';
            }
        });

        // Add event listener to paypal radio button
        paypalRadio.addEventListener('change', function() {
            // If paypal is selected, hide the account number field
            if (this.checked) {
                accountNumberField.style.display = 'none';
            }
        });
    </script>
@endsection
