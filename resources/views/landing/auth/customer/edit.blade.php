@extends('landing.layout.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Edit Customer Details</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('profile') }}">Profile</a>
                            <a href="{{ route('customer-address') }}">Customer's Addresses</a>
                            <span>Edit Customer Details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="spad">
        <div class="container">
            {{-- Form Customer Begin --}}
            <div class="checkout__form">
                <form action="{{ route('edit-address', $customer->id) }}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-md-12">
                        <h6 class="checkout__title">Edit Customer Details</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>First Name<span>*</span></p>
                                    <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}"
                                        placeholder="First Name">
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}"
                                        placeholder="Last Name">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Country & State<span>*</span></p>
                                    <select name="country_id" id="country-select" required>
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id', $customer->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="state" value="{{ old('state', $customer->state) }}" placeholder="State">
                                    @error('state')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Address<span>*</span></p>
                                    <input type="text" placeholder="Street Address" class="checkout__input__add"
                                        name="address" value="{{ old('address', $customer->address) }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="text" placeholder="Apartment, suite, unit, etc. (optional)"
                                        name="apartment" value="{{ old('apartment', $customer->apartment) }}">
                                    @error('apartment')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text" name="city" value="{{ old('city', $customer->city) }}" placeholder="City">
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $customer->zip_code) }}" placeholder="ZIP Code">
                            @error('zip_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="checkout__input">
                            <p>Phone<span>*</span></p>
                            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="Phone">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="site-btn">Update Details</button>
                        <a href="{{ route('customer-address') }}" class="site-btn">Back to customer's addresses</a>
                    </div>
                </form>
            </div>
            {{-- Form Customer End --}}
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Apply Select2 to the country select element
            $('#country-select').select2();
        });
    </script>
@endpush
