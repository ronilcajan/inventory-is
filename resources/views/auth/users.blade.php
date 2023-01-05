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
                            data-bs-target="#createUser">
                            <i class="fa-solid fa-plus"></i>
                            Create User
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
                            <th class="cell">Username</th>
                            <th class="cell">Fullname</th>
                            <th class="cell">Contact No</th>
                            <th class="cell">Designation</th>
                            <th class="cell">Created At</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td class="cell"><span class="truncate">{{ $user->username }}</span></td>
                                <td class="cell"><span
                                        class="truncate">{{ $user->firstname . ' ' . $user->lastname }}</span></td>
                                <td class="cell"><span class="truncate">{{ $user->contact_no }}</span></td>
                                <td class="cell">
                                    @php
                                        $role_id = [];
                                    @endphp
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary"> {{ $role->name }}</span>
                                        @php
                                            $role_id[] = $role->id;
                                        @endphp
                                    @endforeach
                                </td>
                                <td class="cell">
                                    {{ date('Y-m-d h:i:s A', strtotime($user->created_at)) }}
                                </td>
                                <td>
                                    <div class="row w-75">
                                        <div class="col-auto p-0">
                                            <form class="p-0 m-0" action="/admin/resetPassword/{{ $user->id }}"
                                                method="post"
                                                onsubmit="return confirm('Do you wish to reset this user password?');">
                                                @csrf
                                                <button class="btn-sm app-btn-secondary" type="submit"
                                                    title="Delete User">Reset</button>
                                            </form>
                                        </div>
                                        <div class="col-auto p-0">
                                            <button type="button" onclick="editUser(this)"
                                                data-id="{{ $user->id }}" data-uname="{{ $user->username }}"
                                                data-fname="{{ $user->firstname }}" data-lname="{{ $user->lastname }}"
                                                data-contact="{{ $user->contact_no }}"
                                                data-role="{{ json_encode($role_id) }}"
                                                class="btn-sm app-btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#editUser">
                                                Edit
                                            </button>
                                        </div>
                                        @if ($user->username != 'admin')
                                            <div class="col-auto p-0">
                                                <form class="p-0 m-0" action="/admin/deleteUser/{{ $user->id }}"
                                                    method="post"
                                                    onsubmit="return confirm('Do you wish to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn-sm app-btn-secondary" type="submit"
                                                        title="Delete User">Delete</button>
                                                </form>
                                            </div>
                                        @endif
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
            {{ $users->links() }}
        </ul>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="createUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="user/store" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Title"
                                name="username" required value="{{ old('username') }}">
                            <label for="floatingInput">Username</label>
                            @error('username')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput1" placeholder="Title"
                                name="firstname" required value="{{ old('firstname') }}">
                            <label for="floatingInput1">Firstname</label>
                            @error('firstname')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput2" placeholder="Title"
                                name="lastname" required value="{{ old('lastname') }}">
                            <label for="floatingInput2">Lastname</label>
                            @error('lastname')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput3" placeholder="Title"
                                name="contact_no" required value="{{ old('contact_no') }}">
                            <label for="floatingInput3">Contact No.</label>
                            @error('contact_no')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Select or assign a role"
                                name="name">
                                <option value="" selected>Open this to select</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Select or assign a role</label>
                            @error('name')
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
    <div class="modal fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/updateUser" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" readonly id="username" placeholder="Title"
                                name="username" required>
                            <label for="username">Username</label>
                            @error('username')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fname" placeholder="Title"
                                name="firstname" required value="{{ old('firstname') }}">
                            <label for="floatingInput1">Firstname</label>
                            @error('firstname')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="lname" placeholder="Title"
                                name="lastname" required value="{{ old('lastname') }}">
                            <label for="floatingInput2">Lastname</label>
                            @error('lastname')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="contact_no" placeholder="Title"
                                name="contact_no" required value="{{ old('contact_no') }}">
                            <label for="floatingInput3">Contact No.</label>
                            @error('contact_no')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="roles_id" aria-label="Select or assign a role"
                                name="name">
                                <option value="" selected>Open this to select</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label for="roles_id">Select or assign a role</label>
                            @error('name')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user_id" name="user_id">
                    <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn app-btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
