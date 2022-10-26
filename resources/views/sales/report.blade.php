<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}
                {{ $_GET['from'] ?? null ? ': from ' . date('F d, Y', strtotime($_GET['from'])) : null }}</h1>
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
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Receipt No.</th>
                            <th class="cell">Total QTY</th>
                            <th class="cell">Amount Paid</th>
                            <th class="cell">Discount</th>
                            <th class="cell">Cashier</th>
                            <th class="cell">Date</th>
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
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->sale_created)) }}
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
