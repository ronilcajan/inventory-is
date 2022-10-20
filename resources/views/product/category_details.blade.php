<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
    </div>
    <!--//row-->
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Name</th>
                            <th class="cell">Description</th>
                            <th class="cell">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="cell"><span class="truncate"><a
                                        href="/admin/products/category/{{ $category->id }}/details">
                                        {{ $category->name }}</a>
                                </span></td>
                            <td class="cell"><span class="truncate">{{ $category->description }}</span></td>
                            <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($category->created_at)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--//table-responsive-->

        </div>
        <!--//app-card-body-->
    </div>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">Products</h1>
        </div>
    </div>
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Name</th>
                            <th class="cell">Barcode</th>
                            <th class="cell">Unit</th>
                            <th class="cell">Price(P)</th>
                            <th class="cell">Mark-up Price(P)</th>
                            <th class="cell">Stock In</th>
                            <th class="cell">Stock Out</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                            <tr>
                                <td class="cell"><span class="truncate"> <img
                                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/product.png') }}"
                                            width="30" alt="{{ $product->name }}"> {{ $product->name }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->barcode }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->unit }}</span></td>
                                <td class="cell"><span> {{ number_format($product->price, 2) }}</span></td>
                                <td class="cell"><span> {{ number_format($product->mark_up, 2) }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->stock_in_qty }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->stock_out_qty }}</span></td>
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
</x-admin-layout>
