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
                            data-bs-target="#createSupplier">
                            <i class="fa-solid fa-plus"></i>
                            Create Supplier
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
                            <th class="cell">Name</th>
                            <th class="cell">Email</th>
                            <th class="cell">Contact No</th>
                            <th class="cell">Company</th>
                            <th class="cell">Address</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td class="cell"><span class="truncate"> <a
                                            href="/admin/supplier/{{ $supplier->id }}/details">{{ $supplier->supplier_name }}</a>
                                    </span></td>
                                <td class="cell"><span class="truncate"><a
                                            href="mailto:{{ $supplier->supplier_email }}">{{ $supplier->supplier_email }}</a>
                                    </span></td>
                                <td class="cell">{{ $supplier->supplier_contact_no }}</td>
                                <td class="cell">{{ $supplier->supplier_company }}</td>
                                <td class="cell">{{ $supplier->supplier_address }}</td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($supplier->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" data-id="{{ $supplier->id }}"
                                                data-name="{{ $supplier->supplier_name }}"
                                                data-email="{{ $supplier->supplier_email }}"
                                                data-contact_no="{{ $supplier->supplier_contact_no }}"
                                                data-company="{{ $supplier->supplier_company }}"
                                                data-address="{{ $supplier->supplier_address }}"
                                                onclick="editSupplier(this)" class="btn-sm app-btn-secondary"
                                                data-bs-toggle="modal" data-bs-target="#editSupplier">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/supplier/destroy/{{ $supplier->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this supplier?');">
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
            {{ $suppliers->links() }}
        </ul>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="createSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supplier-create') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Supplier name" name="supplier_name"
                                value="{{ old('supplier_name') }}" required>
                            @error('supplier_name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Supplier email"
                                name="supplier_email" value="{{ old('supplier_email') }}" required>
                            @error('supplier_email')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Supplier contact no."
                                name="supplier_contact_no" value="{{ old('supplier_contact_no') }}" required>
                            @error('supplier_contact_no')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Company name"
                                name="supplier_company" value="{{ old('supplier_company') }}">
                            @error('supplier_company')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Enter supplier address" style="height: 100px" name="supplier_address"
                                required>{{ old('supplier_address') }}</textarea>
                            @error('supplier_address')
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
    <!-- Modal -->
    <div class="modal fade" id="editSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supplier-update') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Supplier name"
                                name="supplier_name" id="name" required>
                            @error('supplier_name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Supplier email"
                                name="supplier_email" id="email" required>
                            @error('supplier_email')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Supplier contact no."
                                name="supplier_contact_no" id="contact_no" required>
                            @error('supplier_contact_no')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Company name"
                                name="supplier_company" id="company">
                            @error('supplier_company')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Enter supplier address" style="height: 100px" name="supplier_address"
                                id="address"></textarea>
                            @error('supplier_address')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="supplier_id" id="sup_id">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn app-btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
