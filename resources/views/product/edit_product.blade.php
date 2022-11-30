<x-admin-layout>
    <h1 class="app-page-title">{{ $title }}</h1>
    <hr class="mb-4">
    <form method="POST" action="/admin/products/{{ $product->id }}/update" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row gy-4 mb-4">
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                    <div class="app-card-body px-4 w-100">
                        <div class="item py-2 mb-2">
                            <div class="text-center">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/product.png') }}"
                                    width="180" class="rounded" alt="...">
                                <div>
                                    <input class="form-control" type="file" name="image">
                                </div>
                            </div>
                        </div>
                        <!--//item-->
                        <div class="item py-2 mb-2">
                            <label class="item-label mb-1"><strong>Suppliers</strong> </label>
                            <select class="form-select" id="supplier_id" aria-label="Select supplier" name="supplier_id"
                                required>
                                <option value="" selected>Open this to select</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ $supplier->id == $product->supplier_id ? 'selected' : null }}
                                        value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                            <!--//row-->
                        </div>
                        <!--//item-->
                        <div class="item py-2 mb-2">
                            <label class="item-label mb-1"><strong>Categories</strong> </label>
                            <select class="form-select" id="category" aria-label="Select supplier" name="category_id"
                                required>
                                <option value="" selected>Open this to select</option>
                                @foreach ($categories as $category)
                                    <option {{ $category->id == $product->category_id ? 'selected' : null }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                            <!--//row-->
                        </div>
                        <!--//item-->
                    </div>
                </div>
                <!--//app-card-->
            </div>
            <!--//col-->
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                    <div class="app-card-body px-4 w-100">

                        <div class="item border-bottom py-3">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Barcode(must be unique):</strong> </label>
                                    <input type="text" class="form-control" placeholder="Enter barcode"
                                        value="{{ $product->barcode }}" name="barcode" required readonly>
                                    @error('barcode')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Product Name:</strong> </label>
                                    <input type="text" class="form-control" placeholder="Enter product name"
                                        value="{{ $product->name }}" name="name" required>
                                    @error('product')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!--//row-->
                            <div class="row">
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Quantity</strong></label>
                                    <input type="number" class="form-control" placeholder="Enter quantity"
                                        value="{{ $product->stock_in_qty }}" name="quantity" readonly>
                                    @error('quantity')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Minimum Stocks</strong></label>
                                    <input type="number" class="form-control" placeholder="Enter quantity"
                                        value="{{ $product->min_stocks }}" name="min_stocks" required>
                                    @error('min_stocks')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Unit</strong> </label>
                                    <input type="text" class="form-control" placeholder="Enter unit"
                                        value="{{ $product->unit }}" name="unit" required>
                                    @error('unit')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label class="item-label"><strong>Mark-up Price(P)</strong> </label>
                                    <input type="number" min="0.00" step="0.01" class="form-control"
                                        placeholder="Enter price" value="{{ $product->price }}" name="price"
                                        required>
                                    @error('price')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!--//row-->
                            <div class="row">
                                <div class="col-sm-12 mb-4">
                                    <label class="item-label"><strong>Description:</strong> </label>
                                    <textarea class="form-control" name="description" id="description" style="height: 100px">{{ $product->description }}</textarea>
                                    @error('description')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn app-btn-primary mt-4 mb-4">Save Changes</button>
                    </div>

                    <!--//app-card-footer-->

                </div>
                <!--//app-card-->
            </div>
        </div>
    </form>
</x-admin-layout>
