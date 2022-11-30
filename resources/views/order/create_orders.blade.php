<x-admin-layout>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <div class="page-utilities">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <button type="button" class="btn app-btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createProduct">
                            <i class="fa-solid fa-plus"></i>
                            Product
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
    <form action="{{ route('orders-save') }}" method="post">
        @csrf
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table w-50 table-borderless app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Order Number: </th>
                                <th class="cell">
                                    <input type="text" class="form-control" readonly name="order_no"
                                        value="ORN-{{ empty($order) ? date('Y') . '-' . 10001 : date('Y') . '-' . $order->id + 1 }}">
                                </th>
                            </tr>
                            <tr>
                                <th class="cell">Supplier: </th>
                                <th>
                                    <select class="form-control w-50" id="supplier_id" name="supplier_id">
                                        <option disabled>Select Supplier</option>
                                        @foreach ($suppliers as $row)
                                            <option value="{{ $row->id }}">{{ $row->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table app-table-hover mb-0 text-left" id="order_table">
                        <thead>
                            <tr>
                                <th class="cell">No</th>
                                <th class="cell" style="width: 300px">Barcode</th>
                                <th class="cell">Product Name</th>
                                <th class="cell">Quantity</th>
                                <th class="cell">Price(P)</th>
                                <th class="cell">Total Amount</th>
                                <th class="cell text-center">
                                    <button type="button" class="btn app-btn-primary" onclick="addRow()">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="cell">1</td>
                                <td>
                                    <select class="form-control barcode" name="product_id[]"
                                        onchange="loadProducts(this)" required>
                                        <option value="">Search Barcode or Item</option>
                                    </select>
                                </td>
                                <td class="cell">
                                    <input type="text" class="form-control product_name" name="product_name"
                                        readonly>
                                </td>
                                <td class="cell">
                                    <input type="number" min='0' class="form-control product_qty"
                                        name="product_qty[]" onchange="calculateTotalAmount(this)" required>
                                </td>
                                <td class="cell">
                                    <input type="number" class="form-control product_price text-right"
                                        name="product_price[]" onchange="calculateTotalAmount1(this)" required>
                                </td>
                                <td class="cell">
                                    <input type="number" class="form-control product_amount" readonly
                                        name="product_amount[]">
                                </td>
                                <td class="cell">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="cell" colspan=""></th>
                                <th class="cell"></th>
                                <th class="cell" style="font-size: 18px">Total QTY:</th>
                                <th class="cell">
                                    <input style="font-size: 18px" type="text" name="total_qty" readonly
                                        class="form-control" id="totalQty" value="0">
                                </th>
                                <th class="cell" style="font-size: 18px">Grand Total(P):</th>
                                <th class="cell">
                                    <input style="font-size: 18px" type="text" name="grand_total" readonly
                                        class="form-control" id="grandTotal" value="0.00">
                                </th>
                                <th class="cell text-center">
                                    <button type="submit" class="btn app-btn-primary">Submit
                                    </button>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!--//table-responsive-->

            </div>
            <!--//app-card-body-->
        </div>
    </form>
    <!--//app-card-->
    <!-- Modal -->
    <div class="modal fade" id="createProduct" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product-create') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Categories</strong> </label>
                            <select class="form-select" aria-label="Select supplier" name="category_id" required>
                                <option value="" selected>Open this to Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Product Barcode</strong> </label>
                            <input type="text" class="form-control" placeholder="Product barcode"
                                value="{{ empty($products) ? 10001 : $products->barcode + 1 }}" name="barcode"
                                required>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Product Name</strong> </label>
                            <input type="text" class="form-control" placeholder="Product name" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Minimum Stock</strong> </label>
                            <input type="number" class="form-control" placeholder="Minimum Stock" name="min_stocks"
                                value="{{ old('min_stocks') }}" required>
                            @error('min_stocks')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Units</strong> </label>
                            <input type="text" class="form-control" placeholder="Product unit" name="unit"
                                value="{{ old('unit') }}" required>
                            @error('unit')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Description</strong> </label>
                            <textarea class="form-control" placeholder="Enter product description" style="height: 100px" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn app-btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
