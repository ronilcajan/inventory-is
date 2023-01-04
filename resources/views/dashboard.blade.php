<x-admin-layout>

    <h1 class="app-page-title">{{ $title }}</h1>
    <!--//app-card-->

    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">User</h4>
                    <div class="stats-figure">{{ number_format($user) }}</div>
                    <div class="stats-meta">active({{ number_format($user) }})</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="/admin/sales"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->


        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Items</h4>
                    <div class="stats-figure">{{ number_format($product) }}</div>
                    <div class="stats-meta">store({{ number_format(count($store)) }})</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="/admin/products/items"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Orders</h4>
                    <div class="stats-figure">{{ number_format(count($order_closed)) }}</div>
                    <div class="stats-meta">pending({{ count($order_pending) }})</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="/admin/orders"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Sales</h4>
                    <div class="stats-figure">₱{{ number_format($total_sales, 2) }}</div>
                    <div class="stats-meta">today sales(₱{{ number_format($today_sales, 2) }})</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="/admin/sales"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
    </div>
    <!--//row-->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">{{ date('Y') }} Revenue Analytics</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="chart-container">
                        <canvas id="canvas-barchart"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Order Analytics</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-4">
                    <div class="chart-container">
                        <canvas id="chart-doughnut"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
            <!--//col-->
            <!--//app-card-body-->
            {{-- <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Latest Product Sold</h4>
                        </div>
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table" style="font-size: 12px">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach ($product_sold as $row)
                                <tr>
                                    <td class="cell">{{ $row->name }}</td>
                                    <td class="cell">{{ $row->sale_qty }}</td>
                                    <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!--//app-card-body-->
            </div> --}}
            <!--//app-card-->
        </div>
        <!--//col-->

    </div>
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Most Sold Products</h4>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table table-borderless" style="font-size: 12px">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                        </thead>
                        <tbody>
                            @foreach ($most_product as $row)
                                <tr>
                                    <td class="cell">{{ $row->name }}</td>
                                    <td class="cell">{{ $row->count_qty }}</td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Latest Sold Products </h4>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">

                    <table class="table  table-borderless" style="font-size: 12px">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach ($product_sold as $row)
                                <tr>
                                    <td class="cell">{{ $row->name }}</td>
                                    <td class="cell">{{ $row->sale_qty }}</td>
                                    <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->

    </div>

</x-admin-layout>
