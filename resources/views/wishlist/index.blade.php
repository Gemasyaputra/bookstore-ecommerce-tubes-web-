@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">My Wishlist</h2>
                    <p class="text-muted mb-0">{{ count($wishlist) }} {{ count($wishlist) === 1 ? 'book' : 'books' }} in your wishlist</p>
                </div>
                @if(count($wishlist) > 0)
                    <div class="d-flex gap-2">
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Add More Books
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Wishlist Items -->
    <div class="row">
        @forelse($wishlist as $book)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="row g-0 h-100">
                        <!-- Book Image -->
                        <div class="col-4">
                            <div class="position-relative h-100">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="img-fluid rounded-start h-100"
                                         style="object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light rounded-start">
                                        <i class="fas fa-book fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Book Details -->
                        <div class="col-8">
                            <div class="card-body h-100 d-flex flex-column p-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-2 text-truncate" title="{{ $book->title }}">
                                        {{ $book->title }}
                                    </h5>
                                    <p class="card-text text-muted mb-2 small">
                                        <i class="fas fa-user me-1"></i>{{ $book->author->name }}
                                    </p>
                                    
                                    @if(isset($book->category))
                                        <span class="badge bg-secondary mb-2">{{ $book->category->name }}</span>
                                    @endif
                                    
                                    <div class="price-section mb-3">
                                        <span class="h5 text-primary mb-0">${{ number_format($book->price, 2) }}</span>
                                    </div>
                                    
                                    @if(isset($book->stock))
                                        @if($book->stock > 0)
                                            <p class="card-text small text-success mb-0">
                                                <i class="fas fa-check-circle me-1"></i>In Stock ({{ $book->stock }} available)
                                            </p>
                                        @else
                                            <p class="card-text small text-danger mb-0">
                                                <i class="fas fa-exclamation-circle me-1"></i>Out of Stock
                                            </p>
                                        @endif
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="mt-3">
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('cart.add', $book->id) }}" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-success btn-sm w-100 {{ isset($book->stock) && $book->stock == 0 ? 'disabled' : '' }}"
                                                    {{ isset($book->stock) && $book->stock == 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('wishlist.remove', $book->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Remove from wishlist">
                                                <i class="fas fa-heart-broken"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted mb-2">Your wishlist is empty</h4>
                        <p class="text-muted">Start adding books you love to your wishlist!</p>
                    </div>
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Books
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.hover-shadow {
    transition: box-shadow 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title {
    line-height: 1.3;
}

.price-section {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 0.5rem 0;
}

@media (max-width: 768px) {
    .card .row {
        flex-direction: column;
    }
    
    .card .col-4,
    .card .col-8 {
        flex: 0 0 auto;
        width: 100%;
    }
    
    .card .col-4 {
        max-height: 200px;
    }
}
</style>
@endsection