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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-images mb-6">
                                @php($productImages = $images->where('product_id', $product->id))
                                @if ($productImages->count() > 0)
                                    @foreach ($productImages as $image)
                                        <div class="relative flex items-center justify-center m-1">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->image }}"
                                                class="w-32 h-32 object-cover inline">
                                            <a href="{{ route('products.deleteImage', ['id' => $image->id]) }}"
                                                class="absolute top-0 right-0">
                                                <img src="{{ asset('assets/img/icon/x-circle-white.png') }}" alt=""
                                                    class="w-6 h-6">
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="dark:text-gray-300">No images available.</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-6">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400 font-semibold">Add New Images</span>
                                    <input type="file" name="images[]" id="images" multiple
                                        class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                </label>
                            </div>
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
                                                <option value="{{ $category->id }}"
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
                            <!-- Save and Cancel buttons -->
                            <div class="px-4 py-3 mb-8">
                                <button type="submit" id="save"
                                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                <a href="{{ route('products.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();
            const fields = [{
                    id: 'name',
                    message: "Please enter product's name"
                },
                {
                    id: 'category',
                    message: "Please choose product's category"
                },
                {
                    id: 'brand',
                    message: "Please choose product's brand"
                },
                {
                    id: 'sku',
                    message: "Please enter product's code"
                },
                {
                    id: 'price',
                    message: "Please enter product's price"
                },
                {
                    id: 'description',
                    message: "Please enter product's description"
                }
            ];

            for (const field of fields) {
                const input = document.getElementById(field.id);
                if (input.value === "" || (field.id === 'price' && input.value === "0")) {
                    input.focus();
                    Swal.fire(`${field.id.charAt(0).toUpperCase() + field.id.slice(1)} is Required!`, field.message,
                        'error');
                    return;
                }
            }
            form.submit();
        }

        save.addEventListener('click', submit);
    </script>
@endsection
