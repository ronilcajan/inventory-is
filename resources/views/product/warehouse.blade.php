@php
$system = DB::table('settings')
    ->get()
    ->first();
@endphp
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
                            <th class="cell">Price(P)</th>
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
                                <td class="cell"><span class="truncate">
                                        {{ number_format($product->stock_in_qty) ?? '0' }}</span>
                                </td>
                                <td class="cell"><span class="truncate"> {{ $product->unit }}</span></td>
                                <td class="cell"><span>₱ {{ number_format($product->price, 2) }}</span></td>

                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" class="btn-sm app-btn-secondary"
                                                data-bs-toggle="modal" data-bs-target="#moveProducts"
                                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                data-quantity="{{ $product->stock_in_qty }}"
                                                data-unit="{{ $product->unit }}" data-price="{{ $product->price }}"
                                                onclick="moveProducts(this)"> Move
                                                Products </button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Move Products in Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('move-to-store') }}" method="post">
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
                                name="stock_out_qty" id="stock_out_qty" required value="{{ old('stock_out_qty') }}">
                            @error('stock_out_qty')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label> <strong>Enter Percentage Price</strong> </label>
                            <input type="number" min="0" class="form-control" placeholder="Percentage price"
                                id="percent" name="percentage" required value="{{ old('percent') }}"
                                onchange="addpercent(this)">
                            @error('percent')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label> <strong>Markup Price(+<span id="vat">{{ $system->vat ?? 6 }}</span>%
                                    Vat)</strong> </label>
                            <input type="number" min="0.00" step="0.01" class="form-control"
                                placeholder="Markup price" id="mark_up" name="mark_up" required
                                value="{{ old('mark_up') }}">
                            @error('mark_up')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label> <strong>Incharge</strong> </label>
                            <input type="text" class="form-control" placeholder="Incharge person" name="incharge"
                                required value="{{ old('incharge') }}">
                            @error('incharge')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="products_id" id="prod_id">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn app-btn-primary">Move</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
