<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <div class="mb-4 flex">
            <h2 class="w-full my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                @yield('page')
            </h2>
            @if (!request()->routeIs('dashboard') && !request()->routeIs('*.create') && !request()->routeIs('*.edit') && !request()->routeIs('payments.*') && !request()->routeIs('orders.*'))
                <div class="w-full inline-flex justify-end items-center">
                    <a href="@yield('link')"
                        class="flex justify-between mt-6 px-4 py-2 text-sm font-semibold leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
                        <!-- https://feathericons.dev/?search=file-plus&iconset=feather -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" class="w-4 h-4"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="12" x2="12" y1="18" y2="12" />
                            <line x1="9" x2="15" y1="15" y2="15" />
                        </svg>
                        <span class="ml-2">Add New Item</span>
                    </a>
                </div>
            @endif
        </div>
