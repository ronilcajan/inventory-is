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
                            data-bs-target="#createRole">
                            <i class="fa-solid fa-plus"></i>
                            Create Role
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
                            <th class="cell">Permissions</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($roles as $role)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $role->name }}</span></td>
                                <td class="cell">{{ $role->description }}</td>
                                <td class="cell">
                                    @php
                                        $perm_id = [];
                                    @endphp
                                    @foreach ($role->permissions as $userpermission)
                                        <span class="badge bg-primary"> {{ $userpermission->name }}</span>
                                        @php
                                            $perm_id[] = $userpermission->id;
                                        @endphp
                                    @endforeach
                                </td>
                                <td class="cell">{{ date('Y-m-d h:i:s A', strtotime($role->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <button type="button" data-id="{{ $role->id }}"
                                                data-name="{{ $role->name }}" data-des="{{ $role->description }}"
                                                data-perm="{{ json_encode($perm_id) }}" onclick="editRole(this)"
                                                class="btn-sm app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#editRole">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/deleteRole/{{ $role->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to delete this role?');">
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

    <!-- Modal -->
    <div class="modal fade" id="createRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/createRole" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Title"
                                name="name" value="{{ old('name') }}" required>
                            <label for="floatingInput">Title</label>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a Description here" id="floatingTextarea2" style="height: 100px"
                                name="description" required>{{ old('description') }}</textarea>
                            <label for="floatingTextarea2">Description</label>
                            @error('description')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <label class="mb-2">Permission:</label>
                        @foreach ($permissions as $permission)
                            <div class="form-check mb-3 m">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->id }}" id="settings-checkbox-{{ $permission->id }}">
                                <label class="form-check-label" for="settings-checkbox-{{ $permission->id }}">
                                    {{ $permission->name }} - {{ $permission->description }}
                                </label>
                            </div>
                        @endforeach
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
    <div class="modal fade" id="editRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/updateRole" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="role_name" placeholder="Title"
                                name="name" value="{{ old('name') }}" required>
                            <label for="role_name">Title</label>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a Description here" id="role_desc" style="height: 100px"
                                name="description" required>{{ old('description') }}</textarea>
                            <label for="role_desc">Description</label>
                            @error('description')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <label class="mb-2">Permission:</label>
                        @foreach ($permissions as $permission)
                            <div class="form-check mb-3 m">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    value="{{ $permission->id }}" id="permi-{{ $permission->id }}">
                                <label class="form-check-label" for="permi-{{ $permission->id }}">
                                    {{ $permission->name }} - {{ $permission->description }}
                                </label>
                            </div>
                        @endforeach
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="role_id" id="role_id">
                    <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn app-btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
