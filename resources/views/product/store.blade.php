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
                        <a type="button" href="{{ route('items-create') }}" class="btn app-btn-primary">
                            <i class="fa-solid fa-plus"></i>
                            Create Products
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
                            <th class="cell">Name</th>
                            <th class="cell">Barcode</th>
                            <th class="cell">Quantity</th>
                            <th class="cell">Unit</th>
                            <th class="cell">Mark Up Price(P)</th>
                            <th class="cell">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                            <tr>
                                <td class="cell"><span class="truncate"> <img
                                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/product.png') }}"
                                            width="30" alt="{{ $product->name }}"> {{ $product->name }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->barcode }}</span></td>
                                <td class="cell"><span class="truncate"> {{ $product->stock_out_qty ?? '0' }}</span>
                                </td>
                                <td class="cell"><span class="truncate"> {{ $product->unit }}</span></td>
                                <td class="cell"><span>₱ {{ number_format($product->mark_up, 2) }}</span></td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" class="btn-sm app-btn-secondary"
                                                data-bs-toggle="modal" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-quantity="{{ $product->stock_out_qty }}"
                                                data-unit="{{ $product->unit }}" data-price="{{ $product->mark_up }}"
                                                onclick="moveProducts(this)" data-bs-target="#moveProducts">
                                                Return to Warehouse
                                            </button>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="moveProducts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Return Products to Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('return-to-warehouse') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <div class="mb-3">
                                    <label> <strong>Product name</strong> </label>
                                    <input type="text" class="form-control" id="product" placeholder="Title"
                                        name="product" required value="{{ old('product') }}" readonly>
                                    @error('product')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="mb-3">
                                    <label> <strong>Quantity</strong> </label>
                                    <input type="text" class="form-control" id="quantity" placeholder="Title"
                                        name="quantity" required value="{{ old('quantity') }}" readonly>
                                    @error('quantity')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div class="mb-3">
                                    <label> <strong>Units</strong> </label>
                                    <input type="text" class="form-control" id="unit" placeholder="Unit"
                                        name="unit" required value="{{ old('unit') }}" readonly>
                                    @error('unit')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="mb-3">
                                    <label> <strong>Price(P)</strong> </label>
                                    <input type="number" min="0.00" step="0.01" id="price"
                                        class="form-control" placeholder="Title" name="price" required
                                        value="{{ old('price') }}" readonly>
                                    @error('price')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label> <strong>Enter Quantity</strong> </label>
                            <input type="number" min="0" class="form-control" placeholder="Quantity"
                                name="return_qty" id="stock_out_qty" required value="{{ old('return_qty') }}">
                            @error('return_qty')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="products_id" id="prod_id">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn app-btn-primary">Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
