@extends('dashboard.layout.layout')

@section('title', 'Edit Size')
@section('page', 'Edit Size')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('sizes.update', $size->id) }}" method="POST" id="form">
                @method('PUT')
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                            <input type="text" name="name" id="name"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('name', $size->name) }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Code</span>
                            <input type="text" name="code" id="code"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                value="{{ old('name', $size->code) }}">
                    </div>
                </div>
                <div class="px-4 py-3 mb-8">
                    <button type="submit" id="save"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('sizes.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const size = document.getElementById('name');
        const code = document.getElementById('code');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();
            if (size.value === "") {
                size.focus();
                Swal.fire('Name is Required!', "Please enter size's name", 'error');
            } else if (code.value === "") {
                code.focus();
                Swal.fire('Code is Required!', "Please enter size's code", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
