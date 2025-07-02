@extends('layouts.app')

@section('title', 'Login - Bookstore')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <!-- Login Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header with Logo/Icon -->
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <div class="mb-2">
                        <i class="fas fa-book-open fa-3x mb-2"></i>
                    </div>
                    <h3 class="mb-0 fw-bold">{{ __('Welcome Back') }}</h3>
                    <p class="mb-0 opacity-75">{{ __('Sign in to your bookstore account') }}</p>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email Address') }}
                            </label>
                            <div class="input-group">
                                <input id="email" 
                                       type="email" 
                                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus
                                       placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="fas fa-lock me-2 text-primary"></i>{{ __('Password') }}
                            </label>
                            <div class="input-group">
                                <input id="password" 
                                       type="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Keep me signed in') }}
                                </label>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-semibold">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Sign In') }}
                            </button>
                        </div>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="text-decoration-none text-primary fw-medium" 
                                   href="{{ route('password.request') }}">
                                    <i class="fas fa-question-circle me-1"></i>{{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light text-center py-3 rounded-bottom-4">
                    <small class="text-muted">
                        {{ __("Don't have an account?") }} 
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-medium">
                                {{ __('Create one here') }}
                            </a>
                        @endif
                    </small>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>{{ __('Your data is secure and protected') }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
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
    
    .input-group .form-control {
        border-right: none;
    }
    
    .input-group .btn-outline-secondary {
        border-left: none;
        background: transparent;
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

<!-- JavaScript for Password Toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    }
});
</script>
@endsection