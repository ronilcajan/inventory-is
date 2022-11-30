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
                        <button type="button" class="btn app-btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createDiscount">
                            <i class="fa-solid fa-plus"></i>
                            Create Discount
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
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>

                            <th class="cell">Coupon</th>
                            <th class="cell">Discount(%)</th>
                            <th class="cell">Use</th>
                            <th class="cell">Description</th>
                            <th class="cell">Status</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $row)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $row->coupon }}</span></td>
                                <td class="cell"><span class="truncate">{{ $row->discount }}</span></td>
                                <td class="cell"><span class="truncate">{{ $row->use }}</span></td>
                                <td class="cell"><span class="truncate">{{ $row->description }}</span></td>
                                <td class="cell"> <span class="truncate"><span
                                            class="badge bg-{{ $row->status == 'active' ? 'success' : 'danger' }}">{{ $row->status }}</span>
                                </td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-name="{{ $row->name }}" data-desc="{{ $row->description }}"
                                                onclick="editCategory(this)" class="btn-sm app-btn-secondary"
                                                data-bs-toggle="modal" data-bs-target="#editDiscount">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/discount/{{ $row->id }}/delete"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete discount">Delete</button>
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
            {{ $discounts->links() }}
        </ul>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="createDiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('discount-create') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Coupon Code</strong> </label>
                            <input type="text" class="form-control" placeholder="Coupon" name="coupon"
                                value="{{ old('coupon') }}" required>
                            @error('coupon')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Discount(%)</strong> </label>
                            <input type="number" class="form-control" placeholder="Discount" name="discount"
                                value="{{ old('discount') }}" required>
                            @error('discount')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Number of Uses</strong> </label>
                            <input type="number" class="form-control" placeholder="Use" name="use"
                                value="{{ old('use') }}" required>
                            @error('use')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Description</strong> </label>
                            <textarea class="form-control" placeholder="Description" name="description" style="height: 100px">{{ old('description') }}</textarea>
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
    <div class="modal fade" id="editDiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('discount-create') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Coupon Code</strong> </label>
                            <input type="text" class="form-control" placeholder="Coupon" name="coupon"
                                value="{{ old('coupon') }}" required>
                            @error('coupon')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Discount(%)</strong> </label>
                            <input type="number" class="form-control" placeholder="Discount" name="discount"
                                value="{{ old('discount') }}" required>
                            @error('discount')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Number of Uses</strong> </label>
                            <input type="number" class="form-control" placeholder="Use" name="use"
                                value="{{ old('use') }}" required>
                            @error('use')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="item-label mb-1"><strong>Description</strong> </label>
                            <textarea class="form-control" placeholder="Description" name="description" style="height: 100px">{{ old('description') }}</textarea>
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
