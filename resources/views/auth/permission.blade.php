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
                            data-bs-target="#createPermission">
                            <i class="fa-solid fa-plus"></i>
                            Create Permission
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

                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $permission->name }}</span></td>
                                <td class="cell">{{ $permission->description }}</td>
                                <td class="cell">
                                    {{ date('Y-m-d h:i:s A', strtotime($permission->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" onclick="editPerm(this)"
                                                data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"
                                                data-des="{{ $permission->description }}"
                                                class="btn-sm app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#editPermission">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/deletePermission/{{ $permission->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this permission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete permission">Delete</button>
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

    <!-- Modal -->
    <div class="modal fade" id="createPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/createPermission" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Title"
                                name="name" required>
                            <label for="floatingInput">Title</label>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a Description here" id="floatingTextarea2" style="height: 100px"
                                name="description" required></textarea>
                            <label for="floatingTextarea2">Description</label>
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
    <div class="modal fade" id="editPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/updatePermission" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="pname" placeholder="Title"
                                name="name">
                            <label for="pname">Title</label>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a Description here" id="pdesc" style="height: 100px"
                                name="description"></textarea>
                            <label for="pdesc">Description</label>
                            @error('description')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>


                </div>
                <div class="modal-footer">
                    <input type="hidden" id="permission_id" name="permission_id">
                    <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn app-btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
