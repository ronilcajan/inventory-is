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
                            <th class="cell">Unit</th>
                            <th class="cell">Price(P)</th>
                            <th class="cell">Mark-up Price(P)</th>
                            <th class="cell">Warehouse</th>
                            <th class="cell">Store</th>
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
                                <td class="cell"><span class="truncate"> {{ $product->unit }}</span></td>
                                <td class="cell"><span>₱ {{ number_format($product->price, 2) }}</span></td>
                                <td class="cell"><span>₱ {{ number_format($product->mark_up, 2) }}</span></td>
                                <td class="cell"><span class="truncate">
                                        {{ number_format($product->stock_in_qty) }}</span></td>
                                <td class="cell">
                                    <span
                                        class="text-{{ $product->stock_out_qty <= $product->min_stocks ? 'danger' : 'dark' }}">
                                        {{ number_format($product->stock_out_qty) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <a type="button" href="/admin/products/{{ $product->id }}/stock-card"
                                                class="btn-sm app-btn-secondary">
                                                Stock Card
                                            </a>
                                        </div>
                                        <div class="col-auto p-0">
                                            <a type="button" href="/admin/products/{{ $product->id }}/edit"
                                                class="btn-sm app-btn-secondary">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/products/delete/{{ $product->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this products? All data associated with this product will be deleted.');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete role">Delete</button>
                                            </form>
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
</x-admin-layout>
