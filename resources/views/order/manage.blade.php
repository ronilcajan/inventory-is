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
                    <div class="col-auto">
                        <a type="button" class="btn app-btn-primary" href="{{ route('orders-create') }}">
                            <i class="fa-solid fa-plus"></i>
                            Create Orders
                        </a>
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
                        @foreach ($orders as $order)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $count }}</span></td>
                                <td class="cell"><span class="truncate"><a
                                            href="/admin/orders/{{ $order->id }}/details">
                                            {{ $order->order_number }}</a>
                                    </span></td>
                                <td class="cell"><span class="truncate">{{ number_format($order->quantity) }}</span>
                                </td>
                                <td class="cell"><span class="truncate">₱
                                        {{ number_format($order->amount, 2) }}</span>
                                </td>
                                <td class="cell">
                                    <span class="truncate"><span
                                            class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">{{ $order->status }}</span>
                                </td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($order->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        @if ($order->status == 'pending')
                                            <div class="col-auto p-0">
                                                <a type="button" class="btn-sm app-btn-secondary"
                                                    href="/admin/orders/{{ $order->id }}/delivered"
                                                    title="Clcik to mark as Delivered"
                                                    onclick="return confirm('Mark this order as delivered?');">
                                                    Recieved
                                                </a>
                                            </div>
                                            <div class="col-auto p-0">
                                                <a type="button" class="btn-sm app-btn-secondary"
                                                    href="/admin/orders/{{ $order->id }}/edit">
                                                    Edit
                                                </a>
                                            </div>
                                        @endif

                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/orders/destroy/{{ $order->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this order?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete role">Delete</button>
                                            </form>
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
            {{ $orders->links() }}
        </ul>
    </nav>
</x-admin-layout>
