<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <form class="docs-search-form row gx-1 align-items-center">
                            <div class="col-auto">
                                <input type="text" id="search-docs" name="search" class="form-control search-docs"
                                    placeholder="Search" value="{{ old('search') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn app-btn-secondary">Search</button>
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
                            <th class="cell">No</th>
                            <th class="cell">Delivery No.</th>
                            <th class="cell">Order No.</th>
                            <th class="cell">Quantity</th>
                            <th class="cell">Total Amount</th>
                            <th class="cell">Status</th>
                            <th class="cell">Date</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $count = 1;
                        @endphp
                        @foreach ($deliveries as $row)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $count }}</span></td>
                                <td class="cell">
                                    <span class="truncate"><a href="/admin/deliveries/{{ $row->id }}/details">
                                            {{ $row->delivery_or }}</a>
                                    </span>
                                </td>
                                <td class="cell">
                                    <span class="truncate"><a href="/admin/orders?search={{ $row->order_number }}">
                                            {{ $row->order_number }}</a>
                                    </span>
                                </td>
                                <td class="cell"><span class="truncate">{{ number_format($row->quantity) }}</span>
                                </td>
                                <td class="cell"><span class="truncate">{{ number_format($row->amount, 2) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate"><span
                                            class="badge bg-{{ $row->status == 'pending' ? 'warning' : 'success' }}">{{ $row->status }}</span>
                                </td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <a type="button" class="btn-sm app-btn-secondary"
                                                href="/admin/deliveries/{{ $row->id }}/details">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
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
            {{ $deliveries->links() }}
        </ul>
    </nav>
</x-admin-layout>
