<x-auth-layout>
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2"
                                src="{{ asset('images/app-logo.svg') }}" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>

                    <div class="auth-form-container text-start mx-auto">
                        <form class="auth-form auth-signup-form" method="POST" action="/auth/signup">
                            @csrf
                            <div class="email mb-3">
                                <label class="sr-only" for="signup-email">Your Name</label>
                                <input id="signup-name" name="username" type="text" class="form-control signup-name"
                                    placeholder="Username" required="required" value="{{ old('username') }}">
                                @error('username')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="password mb-3">
                                <label class="sr-only" for="signup-password">Password</label>
                                <input id="signup-password" name="password" type="password"
                                    class="form-control signup-password" placeholder="Create a password"
                                    required="required">
                                @error('password')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <div class="password mb-3">
                                <label class="sr-only" for="signup-password1">Password</label>
                                <input id="signup-password1" name="password_confirmation" type="password"
                                    class="form-control signup-password" placeholder="Confirm password"
                                    required="required">
                                @error('password_confirmation')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign
                                    Up</button>
                            </div>
                        </form>
                        <!--//auth-form-->

                        {{-- <div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="login.html" >Log in</a></div> --}}
                    </div>
                    <!--//auth-form-container-->



                </div>
                <!--//auth-body-->

                @include('partials._footer')
            </div>
            <!--//flex-column-->
        </div>
        <!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                    {{-- <div class="overlay-content p-3 p-lg-4 rounded">
					    <h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
					    <div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
				    </div> --}}
                </div>
            </div>
            <!--//auth-background-overlay-->
        </div>
        <!--//auth-background-col-->

    </div>
    <!--//row-->
</x-auth-layout>
