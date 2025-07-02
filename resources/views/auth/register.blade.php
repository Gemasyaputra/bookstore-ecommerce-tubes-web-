@extends('layouts.app')

@section('title', 'Register - Bookstore')

@section('content')
<div class="container-fluid mt-2 pt-5 mb-2 pb-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <!-- Register Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <div class="mb-2">
                        <i class="fas fa-user-plus fa-3x mb-2"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ __('Create Account') }}</h3>
                    <p class="mb-0 opacity-75">{{ __('Join our bookstore community') }}</p>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-dark">
                                <i class="fas fa-user me-2 text-primary"></i>{{ __('Name') }}
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus 
                                   placeholder="Enter your name">
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email Address') }}
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="fas fa-lock me-2 text-primary"></i>{{ __('Password') }}
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold text-dark">
                                <i class="fas fa-check-circle me-2 text-primary"></i>{{ __('Confirm Password') }}
                            </label>
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-control form-control-lg" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Confirm your password">
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                            </button>
                        </div>

                        <!-- Already have account -->
                        <div class="text-center">
                            <small class="text-muted">
                                {{ __('Already have an account?') }}
                                <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-medium">
                                    {{ __('Login here') }}
                                </a>
                            </small>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light text-center py-3 rounded-bottom-4">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>{{ __('Your data is secure and protected') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles (reuse from login) -->
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%) !important;
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 15px;
        }

        .card-body {
            padding: 2rem 1.5rem !important;
        }
    }
</style>
@endsection

