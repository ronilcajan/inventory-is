<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
    </div>
    <!--//row-->
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Barcode No.</th>
                            <th class="cell">Product</th>
                            <th class="cell">Quantity</th>
                            <th class="cell">Price</th>
                            <th class="cell">Total</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($sold_items as $row)
                            <tr>
                                <td class="cell">
                                    <span class="truncate">{{ $row->barcode }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">
                                        {{ $row->name }}
                                    </span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">
                                        {{ number_format($row->sale_qty) }}
                                    </span>
                                </td>
                                <td class="cell">₱ {{ number_format($row->sale_price, 2) }}</td>
                                <td class="cell">₱ {{ number_format($row->sale_price * $row->sale_qty, 2) }}</td>
                                <td>
                                    @role('admin')
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/sales/item/{{ $row->id }}/delete"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this sold item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete role">Delete</button>
                                            </form>
                                        </div>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!--//table-responsive-->

        </div>
        <!--//app-card-body-->
    </div>
    <!--//app-card-->
    <nav class="app-pagination mt-5">
        <ul class="pagination justify-content-center">
            {{ $sold_items->links() }}
        </ul>
    </nav>
</x-admin-layout>
