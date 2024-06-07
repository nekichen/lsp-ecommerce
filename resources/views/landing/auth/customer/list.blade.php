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
            {{-- <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h6 class="checkout__title">Customer's Addresses</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer as $item)
                                <tr>
                                    <th scope="row">First Name</th>
                                    <td>{{ $item->first_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Last Name</th>
                                    <td>{{ $item->last_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Country</th>
                                    <td>{{ $item->country }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address</th>
                                    <td>{{ $item->address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Zip Code</th>
                                    <td>{{ $item->zip_code }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone</th>
                                    <td>{{ $item->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
            <div class="col-lg-12">
                <h6 class="checkout__title">Customer's Addresses</h6>
                @foreach ($customer as $item)
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>
                                        <h4>{{ $item->first_name }} {{ $item->last_name }}</h4>
                                        <p>{{ $item->address }}, {{ $item->zip_code }}, {{ $item->city }}</p>
                                        <h5>{{ $item->country }}</h5>
                                    </td>
                                    <td>
                                        <a href="#" class="primary-btn d-flex justify-content-end">Edit</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <a href="{{ route('add-address-page') }}" class="primary-btn">Add Address</a>
                </div>
            </div>
        </div>
    </section>
    {{-- List Section End --}}
@endsection
