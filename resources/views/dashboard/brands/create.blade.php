@extends('dashboard.layout.layout')

@section('title', 'Create Brand')
@section('page', 'Add New Brand')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('brands.store') }}" method="POST" id="form">
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                        <input type="text" name="name" id="name"
                            class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Brand's Name">
                </div>
                <div class="px-4 py-3 mb-8 rounded-lg shadow-md">
                    <button type="submit" id="save"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('brands.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const categ = document.getElementById('name');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();
            if (categ.value === "") {
                categ.focus();
                Swal.fire('Name is Required!', "Please enter brand's name", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
