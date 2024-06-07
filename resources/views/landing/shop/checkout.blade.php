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
                                                <p id="selectedCustomerName">{{ $addresses->first()->first_name }} {{ $addresses->first()->last_name }}</p>
                                                <p id="selectedCustomerPhone">{{ $addresses->first()->phone }}</p>
                                                <p id="selectedCustomerAddress">{{ $addresses->first()->address }}</p>
                                                <p id="selectedCustomerCity">{{ $addresses->first()->city }}</p>
                                                <p id="selectedCustomerCountry">{{ $addresses->first()->country->name }}</p>
                                                <p id="selectedCustomerZip">{{ $addresses->first()->zip_code }}</p>
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <a class="btn btn-link" href="#">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Select Address<span>*</span></p>
                                <select id="address_id" name="address_id" class="form-control" required>
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}" 
                                                data-first_name="{{ $address->first_name }}"
                                                data-last_name="{{ $address->last_name }}"
                                                data-phone="{{ $address->phone }}"
                                                data-address="{{ $address->address }}"
                                                data-city="{{ $address->city }}"
                                                data-country="{{ $address->country->name }}"
                                                data-zip_code="{{ $address->zip_code }}">
                                            {{ $address->address }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkout__input">
                                <p>Order notes<span> (optional)</span></p>
                                <textarea id="notes" name="notes" class="form-control"
                                    placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach($cartItems as $item)
                                        <li>{{ $item->name }} ({{ $item->options->size }}) <span>${{ $item->price * $item->qty }}</span></li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span>${{ $total }}</span></li>
                                    <li>Total <span>${{ $total }}</span></li>
                                </ul>
                                <div class="checkout__input__checkbox">
                                    <label for="payment_method_cod">
                                        Cash on Delivery
                                        <input type="radio" id="payment_method_cod" name="payment_method" value="cod" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="payment_method_bank_transfer">
                                        Bank Transfer
                                        <input type="radio" id="payment_method_bank_transfer" name="payment_method" value="bank transfer" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="payment_method_paypal">
                                        Paypal
                                        <input type="radio" id="payment_method_paypal" name="payment_method" value="paypal" required>
                                        <span class="checkmark"></span>
                                    </label>
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
@endsection

@section('scripts')
<script>
    document.getElementById('address_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('selectedCustomerName').innerText = selectedOption.getAttribute('data-first_name') + ' ' + selectedOption.getAttribute('data-last_name');
        document.getElementById('selectedCustomerPhone').innerText = selectedOption.getAttribute('data-phone');
        document.getElementById('selectedCustomerAddress').innerText = selectedOption.getAttribute('data-address');
        document.getElementById('selectedCustomerCity').innerText = selectedOption.getAttribute('data-city');
        document.getElementById('selectedCustomerCountry').innerText = selectedOption.getAttribute('data-country');
        document.getElementById('selectedCustomerZip').innerText = selectedOption.getAttribute('data-zip_code');
    });
</script>
@endsection
