@extends('landing.layout.main')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Customer's Addresses</h4>
                        <div class="breadcrumb__links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('profile') }}">Profile</a>
                            <span>Customer's Addresses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- List Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="col-lg-12">
                <h6 class="checkout__title">Customer's Addresses</h6>
                @foreach ($customers as $item)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5>{{ $item->first_name }} {{ $item->last_name }}</h5>
                                    <p>{{ $item->address }}, {{ $item->city }}, {{ $item->zip_code }}</p>
                                    <p>{{ $item->phone }}</p>
                                    @foreach ($countries as $country)
                                        @if ($item->country_id == $country->id)
                                            <p>{{ $country->name }}</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-end">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('edit-address-page', $item->id) }}"
                                        class="btn btn-sm btn-info mr-2">Edit</a>
                                    <!-- Tombol Aktifkan -->
                                    <form action="{{ route('activate-address', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Activate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <a href="{{ route('add-address-page') }}" class="primary-btn">Add Address</a>
                        <a href="{{ route('profile') }}" class="primary-btn">Back to Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- List Section End -->

@endsection

@push('styles')
    <style>
        .breadcrumb__links a {
            margin-right: 5px;
        }

        .checkout__title {
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .card-body {
            padding: 20px;
        }
    </style>
@endpush
