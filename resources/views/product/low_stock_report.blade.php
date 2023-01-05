<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">
                {{ $title }}{{ $_GET['from'] ?? null ? ': from ' . date('F d, Y', strtotime($_GET['from'])) : null }}{{ $_GET['to'] ?? null ? ' to ' . date('F d, Y', strtotime($_GET['to'])) : null }}
            </h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form class="docs-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="submit" name="export" class="btn btn-danger text-white" value="Export">
                            </div>
                        </form>
                    </div>
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
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
                            <th class="cell">Barcode</th>
                            <th class="cell">Name</th>
                            <th class="cell">Total Quantity</th>
                            <th class="cell">Unit</th>
                            <th class="cell">Mark Up Price(P)</th>
                            <th class="cell">Minimum Stocks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $row)
                            @if ($row->stock_in_qty + $row->stock_out_qty < $row->min_stocks)
                                <tr>
                                    <td class="cell">
                                        <span class="truncate">{{ $row->barcode }}</span>
                                    </td>
                                    <td class="cell"><span class="truncate"> <img
                                                src="{{ $row->image ? asset('storage/' . $row->image) : asset('/images/product.png') }}"
                                                width="30" alt="{{ $row->name }}"> {{ $row->name }}</span>
                                    </td>
                                    <td class="cell">
                                        <span
                                            class="truncate">{{ number_format($row->stock_in_qty + $row->stock_out_qty) }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="truncate">{{ $row->unit }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="truncate">₱
                                            {{ number_format($row->mark_up_price, 2) }}</span>
                                    </td>
                                    <td class="cell">
                                        <span class="truncate">{{ $row->min_stocks }}</span>
                                    </td>
                                </tr>
                            @endif
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
            {{ $stocks->links() }}
        </ul>
    </nav>
    <!-- Modal -->
</x-admin-layout>
