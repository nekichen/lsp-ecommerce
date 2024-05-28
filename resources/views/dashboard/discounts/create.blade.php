@extends('dashboard.layout.layout')

@section('title', 'Create Discount')
@section('page', 'Add New Discount')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('discounts.store') }}" method="POST" id="form">
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                            <input type="text" name="name" id="name"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Discount's Name">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Products</span>
                            <div class="block mt-3">
                                @if (isset($products) && count($products) > 0)
                                    <div class="grid grid-cols-6">
                                        <input type="checkbox" id="all-products">
                                        <label for="all-products" class="dark:text-gray-200">All</label>
                                        @foreach ($products as $item)
                                            <input id="product-{{ $item->id }}" type="checkbox"
                                                value="{{ $item->id }}" name="product_id[]">
                                            <label for="product-{{ $item->id }}"
                                                class="dark:text-gray-200">{{ $item->name }}</label>
                                        @endforeach
                                    </div>
                                @else
                                    <input type="text" disabled
                                        class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="No products available">
                                @endif
                            </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Percentage</span>
                            <input type="number" name="percentage" id="percentage"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="%">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Start Date</span>
                            <input type="date" name="start_date" id="start_date"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">End Date</span>
                            <input type="date" name="end_date" id="end_date"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                    </div>
                </div>
                <div class="px-4 py-3 mb-8">
                    <button type="submit" id="save"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('discounts.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('all-products').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('input[name="product_id[]"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        const discount = document.getElementById('name');
        const percentage = document.getElementById('percentage');
        const start_date = document.getElementById('start_date');
        const end_date = document.getElementById('end_date');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();

            let checkboxes = document.querySelectorAll('input[name="product_id[]"]');
            let productsChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (discount.value === "") {
                discount.focus();
                Swal.fire('Name is Required!', "Please enter discount's name", 'error');
            } else if (!productsChecked) {
                Swal.fire('Products is Required!', "Please choose at least one discount's product", 'error');
            } else if (percentage.value === "") {
                percentage.focus();
                Swal.fire('Percentage is Required!', "Please enter discount's percentage", 'error');
            } else if (start_date.value === "") {
                start_date.focus();
                Swal.fire('Start date is Required!', "Please set the discount's start date", 'error');
            } else if (end_date.value === "") {
                end_date.focus();
                Swal.fire('End date is Required!', "Please set the discount's end date", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
