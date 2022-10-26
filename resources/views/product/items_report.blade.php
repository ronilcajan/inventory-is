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
                            <div class="col-auto">
                                <input type="submit" class="btn btn-danger text-white" value="Export" name="export">
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
                            <th class="cell">Date</th>
                            <th class="cell">Name</th>
                            <th class="cell">Status</th>
                            <th class="cell">Quantity</th>
                            <th class="cell">Unit</th>
                            <th class="cell">Unit Cost</th>
                            <th class="cell">Total Cost</th>
                            <th class="cell">Reference No.</th>
                            <th class="cell">Supplier</th>
                            <th class="cell">Mark Up Price(P)</th>
                            <th class="cell">Store Incharge</th>
                            <th class="cell">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $row)
                            <tr>
                                <td class="cell">
                                    <span class="truncate">{{ date('m/d/Y', strtotime($row->created_at)) }}</span>
                                </td>
                                <td class="cell"><span class="truncate"> <img
                                            src="{{ $row->image ? asset('storage/' . $row->image) : asset('/images/product.png') }}"
                                            width="30" alt="{{ $row->name }}"> {{ $row->name }}</span></td>
                                <td class="cell">
                                    <span
                                        class="badge bg-{{ $row->status == 'stock-in' ? 'success' : 'danger' }}">{{ $row->status }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ number_format($row->quantity) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $row->unit }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">₱
                                        {{ number_format($row->price, 2) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">₱
                                        {{ number_format($row->quantity * $row->price, 2) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $row->reference }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $row->supplier_name }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">₱
                                        {{ number_format($row->mark_up_price, 2) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">{{ $row->incharge }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate">
                                        {{ number_format($row->balance) }}
                                    </span>
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
            {{ $products->links() }}
        </ul>
    </nav>
    <!-- Modal -->
</x-admin-layout>
