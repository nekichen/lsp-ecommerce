@extends('dashboard.layout.layout')

@section('title', 'Customers')
@section('page', 'Customers')
@section('link', $create)
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($customers as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $item->first_name . ' ' . $item->last_name }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->user_id)
                                    @php($user = $users->firstWhere('id', $item->user_id))
                                    @if ($user)
                                        {{ $user->email }}
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ $item->phone }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->country_id)
                                    @php($countries = $country->firstWhere('id', $item->country_id))
                                    @if ($countries)
                                        {{ $item->address . ', ' . $item->city . ', ' . $item->zip_code }}
                                        <br>
                                        {{ $item->state . ', ' . $countries->name }}
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <form action="{{ route('customers.destroy', $item->id) }}" method="post" id="form"
                                    class="inline-flex">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" id="delete" onclick="return confirm('Are you sure?')"
                                        class="items-center justify-between px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center col-span-3">
            Showing {{ $customers->firstItem() }}-{{ $customers->lastItem() }} of {{ $customers->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            {{ $customers->links() }}
        </span>
    </div>
    </div>

    @if (Session::has('message'))
        <script>
            Toast.fire({
                timer: 3000,
                icon: 'success',
                title: '{{ Session::get('message') }}',
            });
        </script>
    @endif

    {{-- <script>
        const del = document.getElementById('delete')
        const form = document.getElementById('form')

        function deleteItem(e) {
            e.preventDefault();
            const buttonDelete = Swal.mixin({
                customClass: {
                    confirmButton: "bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-1",
                    cancelButton: "bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-1"
                },
                buttonsStyling: false
            });
            buttonDelete.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Toast.fire({
                        timer: 1500,
                        title: "Cancelled",
                        icon: "error"
                    });
                }
            });
        }

        del.addEventListener('click', function(e) {
            deleteItem(e);
        });
    </script> --}}
@endsection
