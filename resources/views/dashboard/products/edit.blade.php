@extends('dashboard.layout.layout')

@section('title', 'Edit Product')
@section('page', 'Edit Product')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('products.update', $product->id) }}" method="POST" id="form"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    {{-- <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Image</span>
                            <input type="file" name="image[]" id="image"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                multiple>
                    </div> --}}
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                            <input type="text" name="name" id="name"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('name', $product->name) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Slug</span>
                            <input type="text" name="slug" id="slug"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('slug', $product->slug) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Category</span>
                            <select name="category_id" id="category"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id}}"
                                            @if (old('category_id', $product->category_id) == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                                <div
                                    class="absolute
                                inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm"></span>
                                </div>
                            </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Brand</span>
                            <select name="brand_id" id="brand"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            @if (old('brand_id', $product->brand_id) == $brand->id) selected @endif>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                @endif
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm"></span>
                                </div>
                            </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">SKU</span>
                            <input type="text" name="sku" id="sku"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('sku', $product->sku) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Stock</span>
                            <input type="number" name="stock" id="stock"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('stock', $product->stock) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Price</span>
                            <input type="number" name="price" id="price"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Description</span>
                            <textarea name="description" id="description"
                                class="block w-full h-32 mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Active</span>
                            <select name="active" id="active"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="no" {{ old('active', $product->active) == 'no' ? 'selected' : '' }}>No
                                </option>
                                <option value="yes" {{ old('active', $product->active) == 'yes' ? 'selected' : '' }}>Yes
                                </option>
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm"></span>
                                </div>
                            </select>
                    </div>
                </div>
                <div class="px-4 py-3 mb-8">
                    <button type="submit" id="save"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // const image = document.getElementById('image');
        const products = document.getElementById('name');
        const categ = document.getElementById('category');
        const brand = document.getElementById('brand');
        const sku = document.getElementById('sku');
        const price = document.getElementById('price');
        const desc = document.getElementById('description');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();
            if (products.value === "") {
                products.focus();
                Swal.fire('Name is Required!', "Please enter product's name", 'error');
            } else if (categ.value === "") {
                categ.focus();
                Swal.fire('Category is Required!', "Please choose product's category", 'error');
            } else if (brand.value === "") {
                brand.focus();
                Swal.fire('Brand is Required!', "Please choose product's brand", 'error');
            } else if (sku.value === "") {
                sku.focus();
                Swal.fire('SKU is Required!', "Please enter product's code", 'error');
            } else if (price.value === "0") {
                price.focus();
                Swal.fire('Price is Required!', "Please enter product's price", 'error');
            } else if (desc.value === "") {
                desc.focus();
                Swal.fire('Description is Required!', "Please enter product's description", 'error');
            // } else if (image.value === "") {
            //     image.focus();
            //     Swal.fire('Image is Required!', "Please input product's image at least 1", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
