@extends('master.layout')
@section('content')

<main>
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Register</h2>
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

            {{-- XSS PREVENTION: all errors rendered with {{ }} (auto-escaped, never raw) --}}
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
                {{-- CSRF PREVENTION: @csrf token in every form --}}
                <form method="POST" action="{{ url('register') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Full Name</label>
                        {{-- INPUT VALIDATION (client-side): required, pattern restricts to letters/spaces --}}
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            maxlength="255"
                            pattern="[A-Za-z\s\-]+"
                            title="Name may only contain letters, spaces, and hyphens">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            maxlength="255"
                            autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        {{--
                            AUTHENTICATION: client-side minlength; server enforces
                            mixed case + numbers + symbols via Password rule object
                        --}}
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            minlength="8"
                            autocomplete="new-password">
                        <small class="text-muted">
                            Minimum 8 characters — must include uppercase, lowercase, a number, and a symbol.
                        </small>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            required
                            minlength="8"
                            autocomplete="new-password">
                    </div>

                    <button class="btn btn-primary" type="submit">Register</button>
                    <a href="{{ route('login') }}" class="btn btn-link">Already have an account?</a>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
