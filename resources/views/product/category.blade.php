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
                            data-bs-target="#createCategory">
                            <i class="fa-solid fa-plus"></i>
                            Create Categories
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
                            <th class="cell">Description</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>
                                <td class="cell"><span class="truncate"><a
                                            href="/admin/products/category/{{ $category->id }}/details">
                                            {{ $category->name }}</a>
                                    </span></td>
                                <td class="cell"><span class="truncate">{{ $category->description }}</span></td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($category->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                data-desc="{{ $category->description }}" onclick="editCategory(this)"
                                                class="btn-sm app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#editCategory">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0"
                                                action="/admin/products/category/destroy/{{ $category->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this category?');">
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
            {{ $categories->links() }}
        </ul>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="createCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('category-create') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Product category name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Enter product category description" style="height: 100px"
                                name="description">{{ old('description') }}</textarea>
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
    <!-- Modal -->
    <div class="modal fade" id="editCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('category-update') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Product category name"
                                name="name" id="name" required>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Enter product category description" style="height: 100px"
                                name="description" id="description"></textarea>
                            @error('description')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="category_id" name="category_id">
                        <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn app-btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
