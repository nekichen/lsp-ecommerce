@extends('dashboard.layout.layout')

@section('title', 'Create User')
@section('page', 'Add New User')
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <form action="{{ route('users.store') }}" method="POST" id="form">
                @csrf
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Name</span>
                            <input type="text" name="name" id="name"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="User's Name">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Email</span>
                            <input type="text" name="email" id="email"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="User's Email">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Password</span>
                            <input type="password" name="password" id="password"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="User's Password">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-semibold">Role</span>
                            <select name="role" id="role"
                                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="" disabled selected>Press to select</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm"></span>
                                </div>
                            </select>
                    </div>
                </div>
                <div class="px-4 py-3 mb-8">
                    <button type="submit" id="save"
                        class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-3 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const user = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const role = document.getElementById('role');
        const form = document.getElementById('form');
        const save = document.getElementById('save');

        function submit(e) {
            e.preventDefault();
            if (user.value === "") {
                user.focus();
                Swal.fire('Name is Required!', "Please enter user's name", 'error');
            } else if (email.value === "") {
                email.focus();
                Swal.fire('Email is Required!', "Please enter user's email", 'error');
            } else if (password.value === "") {
                password.focus();
                Swal.fire('Password is Required!', "Please enter user's password", 'error');
            } else if (role.value === "") {
                role.focus();
                Swal.fire('Role is Required!', "Please select user's role", 'error');
            } else {
                form.submit();
            }
        }

        save.addEventListener('click', submit);
    </script>
@endsection
