<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials._head')

</head>

<body class="app">
    <header class="app-header fixed-top">

        @include('partials._topbar')
        @include('partials._sidebar')

    </header>
    <!--//app-header-->

    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                        class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                        class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> {{ session('error') }}
                    </div>
                @endif
                @if (session()->has('failures'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show"
                        class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Errors:</strong>
                        <ul>
                            @foreach (session('failures') as $failure)
                                @foreach ($failure->errors() as $error)
                                    <li>Row {{ $failure->row() . ' - ' . $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ $slot }}
            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-content-->
        {{-- @include('partials._footer') --}}

    </div>
    <!--//app-wrapper-->

    <!-- Modal -->
    <div class="modal fade" id="changePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/changePass" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" readonly placeholder="Username" name="username"
                                required value="{{ auth()->user()->username }}">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Create password" name="password"
                                required>
                            <label for="password">Create password</label>
                            @error('password')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Confirmed password"
                                name="password_confirmation" required>
                            <label for="password">Confirmed password</label>
                            @error('password_confirmation')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <button type="button" class="btn app-btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn app-btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @include('partials._footer-links')

</body>

</html>
