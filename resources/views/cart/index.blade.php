@extends('layouts.app')

@section('title', 'Shopping Cart - Bookstore')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Shopping Cart</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(count($cart) > 0)
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            @foreach($cart as $id => $item)
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-6">
                                    <h5>{{ $item['title'] }}</h5>
                                    <p class="text-muted">by {{ $item['author'] }}</p>
                                </div>
                                <div class="col-md-2">
                                    <form method="POST" action="{{ route('cart.update', $id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                               min="1" class="form-control form-control-sm" style="width: 70px;" 
                                               onchange="this.form.submit()">
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <strong>${{ number_format($item['price'], 2) }}</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <form method="POST" action="{{ route('cart.remove', $id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <strong>${{ number_format($total, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span><strong>Total:</strong></span>
                                <strong class="text-success">${{ number_format($total, 2) }}</strong>
                            </div>
                            <button class="btn btn-success w-100 btn-lg">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Add some books to get started!</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    Browse Books
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection