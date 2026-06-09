@extends('master.layout')
@section('content')

<main>
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Log In</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-area section-padding30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>Welcome</span>
                        <h2>HOSPITAL KUALA LUMPUR</h2>
                    </div>
                </div>
            </div>

            {{-- XSS PREVENTION: display validation errors using Blade's {{ }} (auto-escaped) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                {{--
                    CSRF PREVENTION: @csrf generates a hidden token field.
                    Laravel's VerifyCsrfToken middleware rejects any POST
                    without a valid token, blocking cross-site request forgery.

                    FIX: Original login button was an <a href> link — it bypassed
                    the form entirely and never submitted credentials to the server.
                    Now it is a proper submit button inside the form.
                --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            {{-- INPUT VALIDATION (client-side): type="email" and required --}}
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                placeholder="Enter email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                maxlength="255">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="password">Password</label>
                            {{-- INPUT VALIDATION (client-side): minlength enforced --}}
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                placeholder="Password"
                                required
                                minlength="8"
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- AUTHENTICATION: remember me option --}}
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('register') }}" class="btn btn-link">Register</a>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
