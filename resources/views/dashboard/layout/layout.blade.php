<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | @yield('title')</title>

    @include('dashboard.layout.link-script')
    <style>
        .product-images {
            display: flex;
            flex-wrap: wrap;
        }

        .product-images .relative {
            position: relative;
            margin: 5px;
            /* Adjust the margin as needed */
        }

        .product-images img {
            border-radius: 5px;
        }

        .product-images .absolute {
            position: absolute;
        }
    </style>
</head>

<body>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('dashboard.layout.header')
        @include('dashboard.layout.main')
        @yield('content')
        </main>
    </div>
</body>

@if (Session::has('success'))
    <script>
        Toast.fire({
            timer: 3000,
            icon: 'success',
            title: '{{ session('success') }}',
        })
    </script>
@endif

@if (Session::has('error'))
    <script>
        Toast.fire({
            timer: 3000,
            icon: 'error',
            title: '{{ session('error') }}',
        })
    </script>
@endif


</html>
