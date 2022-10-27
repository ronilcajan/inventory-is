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
                                <input type="date" name="from" class="form-control search-docs"
                                    value="{{ $_GET['from'] ?? null ? date('Y-m-d', strtotime($_GET['from'])) : null }}">
                            </div>
                            <div class="col-auto">
                                <input type="date" name="to" class="form-control search-docs"
                                    value="{{ $_GET['to'] ?? null ? date('Y-m-d', strtotime($_GET['to'])) : null }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn app-btn-secondary">Filter</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ Request::url() }}" class="btn btn-info text-white">Refresh</a>
                            </div>
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
                <table class="table app-table-hover mb-0 text-left" id="sales-report">
                    <thead>
                        <tr>
                            <th class="cell">Date</th>
                            <th class="cell">Receipt</th>
                            <th class="cell">Item</th>
                            <th class="cell">Quantity</th>
                            <th class="cell">Price</th>
                            <th class="cell">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $row)
                            <tr>
                                <td class="cell" style="font-size: 12px">
                                    <span
                                        class="truncate">{{ date('Y-m-d h:i:s ', strtotime($row->created_at)) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $row->sales_id }}</span>
                                </td>
                                <td class="cell"><span class="truncate"> <img
                                            src="{{ $row->image ? asset('storage/' . $row->image) : asset('/images/product.png') }}"
                                            width="30" alt="{{ $row->name }}"> {{ $row->name }}</span></td>
                                <td class="cell qty">
                                    <span class="truncate">{{ number_format($row->sale_qty) }}</span>
                                </td>
                                <td class="cell discount">
                                    <span class="truncate">₱
                                        {{ number_format($row->sale_price, 2) }}</span>
                                </td>
                                <td class="cell paid">
                                    <span class="truncate">₱
                                        {{ number_format($row->sale_qty * $row->sale_price, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align: right">Total:</th>
                            <th class="text-right" id="total_qty"></th>
                            <th class="text-right" id="total_discount"></th>
                            <th class="text-right" id="total_paid"></th>
                        </tr>
                    </tfoot>

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
            {{ $items->links() }}
        </ul>
    </nav>
    <!-- Modal -->
</x-admin-layout>
