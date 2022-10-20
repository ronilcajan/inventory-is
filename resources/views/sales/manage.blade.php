<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
        <!--//col-auto-->
    </div>
    <!--//row-->
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Receipt No.</th>
                            <th class="cell">Total QTY</th>
                            <th class="cell">Amount Paid</th>
                            <th class="cell">Discount</th>
                            <th class="cell">Cashier</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($sales as $row)
                            <tr>
                                <td class="cell">
                                    <span class="truncate">{{ $row->id }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">
                                        {{ number_format($row->total_qty) }}
                                    </span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">₱
                                        {{ number_format($row->total_amount - $row->total_amount * ($row->discount / 100), 2) }}
                                    </span>
                                </td>
                                <td class="cell">₱ {{ number_format($row->total_amount * ($row->discount / 100), 2) }}
                                </td>
                                <td class="cell">{{ $row->username }}</td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <a type="button" class="btn-sm app-btn-secondary"
                                                href="/admin/sales/{{ $row->id }}/view">View</a>
                                        </div>
                                        <div class="col-auto p-0">
                                            <a type="button" class="btn-sm app-btn-secondary"
                                                href="/admin/sales/{{ $row->id }}" target="_blank">Receipt</a>
                                        </div>
                                        @role('admin')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="/admin/sales/{{ $row->id }}/delete"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this sales record?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn-sm app-btn-secondary" type="submit"
                                                        title="Delete role">Delete</button>
                                                </form>
                                            </div>
                                        @endrole

                                    </div>
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
            {{ $sales->links() }}
        </ul>
    </nav>
</x-admin-layout>
