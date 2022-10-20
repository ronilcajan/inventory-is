<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <button type="button" onclick="printDiv('printArea')" class="btn btn-danger text-white">
                            <i class="fa-solid fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
        <!--//col-auto-->
    </div>
    <!--//row-->
    <div class="app-card app-card-orders-table shadow-sm mb-5 p-5" id="printArea">
        <div class="text-center">
            <h3 class="font-weight-bold">{{ $title }}</h3>
        </div>
        <div class="d-flex flex-row p-2">
            <div class="d-flex flex-column">
                <span class="font-weight-bold">Order Details</span>
                <small>Order No.: {{ $order->order_number }}</small>
                <span class="truncate mt-2"><span
                        class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">{{ $order->status }}</span>
            </div>
        </div>
        <hr>
        <div class="table-responsive p-2">
            <table class="table app-table-hover table-borderless">
                <tbody>
                    <tr>
                        <td class="cell">Supplier:</td>
                    </tr>
                    <tr>
                        <td class="cell">
                            Company: {{ $supplier->supplier_company }}
                            <br>Attn:{{ $supplier->supplier_name }}
                            <br>Contacts: {{ $supplier->supplier_contact_no }}
                            <br> {{ $supplier->supplier_address }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="d-flex flex-column  p-2">
            <small>Items</small>
        </div>
        <div class="table-responsive">

            <table class="table app-table-hover">
                <thead>
                    <tr>
                        <th class="cell">No</th>
                        <th class="cell">Product Name</th>
                        <th class="cell">QTY</th>
                        <th class="cell">Unit</th>
                        <th class="cell">Price</th>
                        <th class="cell text-center">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($order_items as $row)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->quantity }}</td>
                            <td>{{ $row->unit }}</td>
                            <td>₱ {{ number_format($row->price, 2) }}</td>
                            <td class="text-center">₱ {{ number_format($row->quantity * $row->price, 2) }}
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table app-table-hover table-borderless">
                <tbody>
                    <tr class="add">
                        <td></td>
                        <td>Total Quantity</td>
                        <td class="text-center">Grand Total</td>
                    </tr>
                    <tr class="content">
                        <td></td>
                        <td>{{ number_format($order->quantity) }}</td>
                        <td class="text-center">₱ {{ number_format($order->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <!--//app-card-body-->
    </div>
</x-admin-layout>
