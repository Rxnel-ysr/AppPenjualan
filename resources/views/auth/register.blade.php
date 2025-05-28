@extends('layouts.guest')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center bg-dark" style="min-height: 90dvh;">
    <div class="card shadow-lg overflow-hidden bg-dark" style="max-width: 1200px; border-radius: 1rem; padding: 5rem; border: 1px solid #333;">
        <div class="row g-0">
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-5">
                <img src="{{ asset('storage/developer/Book-3D-BGR.png') }}"
                    class="img-fluid"
                    style="max-height: 70vh; width: auto; user-select: none; filter: brightness(0.8);"
                    alt="SMKN2 3D Illustration">
            </div>

            <div class="col-lg-6">
                <div class="card-body p-4 p-md-5 shadow-sm bg-dark text-light" style="border-radius: 0.5rem;">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-light">{{__('Register Staff')}}</h3>
                        <p class="text-muted text-light-emphasis">{{__('Please enter your credentials')}}</p>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label text-light">Username</label>
                                <input type="text"
                                    class="form-control py-2 bg-dark text-light border-secondary"
                                    id="username"
                                    name="username"
                                    placeholder="Enter your username"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-light">Password</label>
                                <input type="password"
                                    class="form-control py-2 bg-dark text-light border-secondary"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label text-light">Repeat Password</label>
                                <input type="password"
                                    class="form-control py-2 bg-dark text-light border-secondary"
                                    id="password-confirm"
                                    name="password_confirmation"
                                    placeholder="Enter your password"
                                    required>
                            </div>

                            <div class="mb-4">
                                <p class="text-center">{{__('Already registered?')}} <span><a href="{{ route('login') }}" class="link-info">{{__('Login')}}</a></span></p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection