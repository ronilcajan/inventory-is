<x-auth-layout>
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="/"><img class="logo-icon me-2"
                                src="{{ asset('images/app-logo.svg') }}" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form" method="POST" action="{{ route('authenticate') }}">
                            @csrf
                            <div class="email mb-3">
                                <label class="sr-only" for="signin-email">Username</label>
                                <input id="signin-email" name="username" type="text"
                                    class="form-control signin-email" placeholder="Username" required="required">
                                @error('username')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>
                            <!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="signin-password">Password</label>
                                <input id="signin-password" name="password" type="password"
                                    class="form-control signin-password" placeholder="Password" required="required">
                                <span toggle="#signin-password"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                <div class="extra mt-3 row justify-content-between">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember_me"
                                                id="RememberPassword">
                                            <label class="form-check-label" for="RememberPassword">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <!--//col-6-->
                                    <div class="col-6">
                                        {{-- <div class="forgot-password text-end">
										<a href="reset-password.html">Forgot password?</a>
									</div> --}}
                                    </div>
                                    <!--//col-6-->
                                </div>
                                <!--//extra-->
                            </div>
                            <!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log
                                    In</button>
                            </div>
                        </form>

                        {{-- <div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link" href="signup.html" >here</a>.</div> --}}
                    </div>
                    <!--//auth-form-container-->

                </div>
                <!--//auth-body-->

                {{-- @include('partials._footer') --}}

            </div>
            <!--//flex-column-->
        </div>
        <!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            {{-- <div class="auth-background-overlay p-3 p-lg-5">
			<div class="d-flex flex-column align-content-end h-100">
				<div class="h-100"></div>
				<div class="overlay-content p-3 p-lg-4 rounded">
					<h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
					<div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
				</div>
			</div>
		</div><!--//auth-background-overlay--> --}}
        </div>
        <!--//auth-background-col-->

    </div>
    <!--//row-->
</x-auth-layout>
