@php
$system = DB::table('settings')
    ->get()
    ->first();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials._head')

</head>

<body class="app">
    <header class="app-header fixed-top">

        <div class="container-fluid py-2">
            <div class="app-header-content">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="app-utility-item app-notifications-dropdown dropdown">
                            <a class="app-logo" href="/admin/dashboard"><img class="logo-icon me-2"
                                    src="{{ !empty($system->logo) ? asset('storage/' . $system->logo) : asset('/images/app-logo.svg') }}"
                                    alt="logo" width="40"><span
                                    class="logo-text">{{ $system->system_name ?? 'POS System' }}</span></a>
                        </div>
                    </div>
                    <div class="col-auto ">
                        <div class="clock row">
                            <div class="datetime-content">
                                <ul>
                                    <li id="hours"></li>
                                    <li id="point1">:</li>
                                    <li id="min"></li>
                                    <li id="point">:</li>
                                    <li id="sec"></li>
                                    <li id="ampm"></li>
                                </ul>
                            </div>
                            <div class="datetime-content">
                                <div id="Date" class=""></div>
                            </div>

                        </div>
                    </div>

                    <div class="app-utilities col-auto">

                        <div class="app-utility-item app-user-dropdown dropdown">
                            <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                href="#" role="button" aria-expanded="false"><img
                                    src="{{ asset('/images/person.png') }}" alt="user profile"
                                    class="rounded-circle"></a>
                            <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                {{-- @if (!empty(auth()))
                                    <li><a class="dropdown-item" href="/admin/user/account">Account</a>
                                    </li>
                                @endif --}}

                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#changePassword">Change Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post"
                                        onsubmit="return confirm('Do you wish to logout?');">
                                        @csrf
                                        <input class="dropdown-item" type="submit" value="Logout">
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!--//app-user-dropdown-->
                    </div>
                    <!--//app-utilities-->
                </div>
                <!--//row-->
            </div>
            <!--//app-header-content-->
        </div>
        <!--//app-header-inner-->


    </header>
    <!--//app-header-->
    <div class="pt-3 p-md-3 p-lg-4">
        <div class="container-fluid">
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="pos-msg"
                style="display: none;">
                <strong>Success!</strong> Sold items has been saved!
            </div>
            {{ $slot }}
            <!--//container-fluid-->
        </div>

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
