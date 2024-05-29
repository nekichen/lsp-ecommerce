@extends('dashboard.layout.layout')

@section('title', 'Edit Discount')
@section('page', 'Edit Discount')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('discounts.update', $discount->id) }}" method="POST" id="form">
                @csrf
                @method('PUT')
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Code</span>
                            <input type="text" name="code" id="code"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('code', $discount->code) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                            <input type="text" name="name" id="name"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('name', $discount->name) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Max Uses</span>
                            <input type="number" name="max_use" id="max_use"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('max_use', $discount->max_use) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Max Users</span>
                            <input type="number" name="max_user" id="max_user"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('max_user', $discount->max_user) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Type</span>
                            <select name="type" id="type"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm"></span>
                                </div>
                            </select>
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Amount</span>
                            <input type="number" name="amount" id="amount"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('amount', $discount->amount) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Minimum Amount</span>
                            <input type="number" name="min_amount" id="min_amount"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('min_amount', $discount->min_amount) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Start Date</span>
                            <input type="datetime-local" name="start_date" id="start_date"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ old('start_date', $discount->start_date) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">End Date</span>
                            <input type="datetime-local" name="end_date" id="end_date"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" value="{{ old('end_date', $discount->end_date) }}">
                        </label>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Status</span>
                            <select name="is_active" id="is_active"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="1" {{ old('is_active', $discount->is_active) == '1' ? 'selected' : '' }}>True</option>
                                <option value="0" {{ old('is_active', $discount->is_active) == '0' ? 'selected' : '' }}>False</option>
                            </select>
                        </label>
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
        const discount = document.getElementById('code');
        const type = document.getElementById('type');
        const amount = document.getElementById('amount');
        const status = document.getElementById('is_active');
        const start_date = document.getElementById('start_date');
        const end_date = document.getElementById('end_date');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();

            if (discount.value === "") {
                discount.focus();
                Swal.fire('Code is Required!', "Please enter coupon's code", 'error');
            } else if (type.value === "") {
                type.focus();
                Swal.fire('Type is Required!', "Please enter discount's type", 'error');
            } else if (amount.value === "") {
                amount.focus();
                Swal.fire('Amount is Required!', "Please enter discount's amount", 'error');
            } else if (status.value === "") {
                status.focus();
                Swal.fire('Status is Required!', "Please enter coupon's status", 'error');
            } else if (start_date.value === "") {
                start_date.focus();
                Swal.fire('Start date is Required!', "Please set the coupon's start date", 'error');
            } else if (end_date.value === "") {
                end_date.focus();
                Swal.fire('End date is Required!', "Please set the coupon's end date", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
