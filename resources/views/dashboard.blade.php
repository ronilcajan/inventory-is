<x-admin-layout>

    <h1 class="app-page-title">{{ $title }}</h1>
    <!--//app-card-->

    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Sales</h4>
                    <div class="stats-figure">₱{{ number_format($total_sales, 2) }}</div>
                    <div class="stats-meta">Income</div>
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
                    <div class="stats-meta">products</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Store</h4>
                    <div class="stats-figure">{{ number_format($stock_in) }}</div>
                    <div class="stats-meta">quantity</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Warehouse</h4>
                    <div class="stats-figure">{{ number_format($stock_out) }}</div>
                    <div class="stats-meta">quantity</div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
    </div>
    <!--//row-->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">{{ date('Y') }} Full Monthly Sales</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
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
        <div class="col-12 col-lg-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
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

                    <table class="table">
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
