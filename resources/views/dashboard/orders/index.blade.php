@extends('dashboard.layout.layout')

@section('title', 'Orders')
@section('page', 'Orders')
@section('link', $create)
@section('content')
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Invoice Number</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($orders as $i => $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $i + 1 . '. ' }}
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('orders.edit', $item->id) }}"
                                    class="hover:text-orange-800">
                                    {{ $item->invoice_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->customer_id)
                                    @php($customer = $customers->firstWhere('id', $item->customer_id))
                                    @if ($customer)
                                        {{ $customer->first_name . ' ' . $customer->last_name }}
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ $item->order_date }}
                            </td>
                            @if ($item->status == 'Pending')
                                <td class="px-4 py-3">
                                    {{ $item->status }}
                                </td>
                            @else
                                <td class="px-4 py-3">
                                    {{ $item->status }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center col-span-3">
            Showing {{ $orders->firstItem() }} - {{ $orders->lastItem() }} of {{ $orders->total() }}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        {{ $orders->links() }}
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
