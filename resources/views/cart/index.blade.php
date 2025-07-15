@extends('layouts.app')

@section('title', 'Shopping Cart - Bookstore')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <h1 class="h2 mb-0 me-3">Shopping Cart</h1>
                    @if (count($cart) > 0)
                        <span class="badge bg-primary rounded-pill">{{ count($cart) }} items</span>
                    @endif
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (count($cart) > 0)
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0 text-muted">Cart Items</h5>
                                </div>
                                <div class="card-body p-0">
                                    @foreach ($cart as $id => $item)
                                        <div class="cart-item p-4 border-bottom">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-start">
                                                        <div class="book-placeholder bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px; min-width: 60px;">
                                                            <i class="fas fa-book text-muted"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">{{ $item['title'] }}</h6>
                                                            <p class="text-muted mb-0 small">by {{ $item['author'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="row align-items-center text-center">
                                                        <div class="col-4">
                                                            <label class="form-label small text-muted mb-1">Quantity</label>
                                                            <form method="POST" action="{{ route('cart.update', $id) }}" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                                           min="1" class="form-control text-center border-0 bg-light"
                                                                           onchange="this.form.submit()">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        
                                                        <div class="col-4">
                                                            <label class="form-label small text-muted mb-1">Price</label>
                                                            <div class="fw-semibold">${{ number_format($item['price'], 2) }}</div>
                                                        </div>
                                                        
                                                        <div class="col-4">
                                                            <label class="form-label small text-muted mb-1">Total</label>
                                                            <div class="fw-bold text-success">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-12 text-end">
                                                    <form method="POST" action="{{ route('cart.remove', $id) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0 text-muted">Order Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="summary-row d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Subtotal ({{ array_sum(array_column($cart, 'quantity')) }} items)</span>
                                        <span class="fw-semibold">${{ number_format($total, 2) }}</span>
                                    </div>
                                    
                                    <div class="summary-row d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Shipping</span>
                                        <span class="text-success fw-semibold">Free</span>
                                    </div>
                                    
                                    <div class="summary-row d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Tax</span>
                                        <span class="text-success fw-semibold">Free</span>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <div class="summary-row d-flex justify-content-between align-items-center mb-4">
                                        <span class="h5 mb-0">Total</span>
                                        <span class="h4 mb-0 text-success fw-bold">${{ number_format($total, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg rounded-pill">
                                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                        </a>
                                        
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-cart text-center py-5">
                        <div class="empty-cart-icon mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted opacity-50"></i>
                        </div>
                        <h3 class="h4 mb-3">Your cart is empty</h3>
                        <p class="text-muted mb-4">Discover amazing books and add them to your cart!</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-book me-2"></i>Browse Books
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .cart-item {
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: #f8f9fa;
        }
        
        .cart-item:last-child {
            border-bottom: none !important;
        }
        
        .book-placeholder {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .summary-row {
            padding: 0.25rem 0;
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        
        .empty-cart {
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .empty-cart-icon {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0,-15px,0);
            }
            70% {
                transform: translate3d(0,-7px,0);
            }
            90% {
                transform: translate3d(0,-2px,0);
            }
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .input-group-sm .form-control {
            font-size: 0.875rem;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.65em;
        }
        
        .alert {
            border-radius: 0.75rem;
        }
        
        .btn-outline-danger:hover {
            transform: scale(1.05);
        }
        
        .sticky-top {
            z-index: 1000;
        }
    </style>
@endsection