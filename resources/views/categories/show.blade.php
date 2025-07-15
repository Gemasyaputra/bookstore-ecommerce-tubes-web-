@extends('layouts.app')

@section('title', $category->name . ' Books - Bookstore')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Category Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-2">
                                <i class="fas fa-tag me-2 text-primary"></i>
                                {{ $category->name }}
                            </h1>
                            <p class="text-muted mb-0">{{ $category->description }}</p>
                        </div>
                        <div>
                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                All Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Books Grid -->
            <div class="row">
                @forelse($books as $book)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <!-- Book Image -->
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $book->image) }}" 
                                 alt="{{ $book->title }}" 
                                 class="card-img-top" 
                                 style="height: 250px; object-fit: cover;">
                            
                            <!-- Stock Badge -->
                            @if ($book->stock == 0)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                                    Out of Stock
                                </span>
                            @elseif ($book->stock < 5)
                                <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">
                                    Low Stock
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Book Title -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('books.show', $book) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $book->title }}
                                </a>
                            </h5>
                            
                            <!-- Author -->
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-user me-1"></i>
                                by {{ $book->author->name }}
                            </p>
                            
                            <!-- Description -->
                            <p class="card-text text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($book->description, 100) }}
                            </p>
                            
                            <!-- Price and Stock Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="h5 text-success mb-0">
                                        ${{ number_format($book->price, 2) }}
                                    </span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-box me-1"></i>
                                        {{ $book->stock }} in stock
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="card-footer bg-transparent border-top-0 pt-0">
                            <div class="d-grid gap-2">
                                <a href="{{ route('books.show', $book) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    View Details
                                </a>
                                
                                @if ($book->stock > 0)
                                <div class="row g-1">
                                    <div class="col-7">
                                        <form method="POST" action="{{ route('cart.add', $book) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-cart-plus me-1"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-5">
                                        <form method="POST" action="{{ route('wishlist.add', $book->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <div class="row g-1">
                                    <div class="col-7">
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times me-1"></i>
                                            Out of Stock
                                        </button>
                                    </div>
                                    <div class="col-5">
                                        <form method="POST" action="{{ route('wishlist.add', $book->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-book-open text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted mb-3">No books found in this category</h4>
                        <p class="text-muted mb-4">
                            We're constantly adding new books to our collection. Check back later for new additions!
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Browse All Books
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($books->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Books pagination">
                    {{ $books->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: box-shadow 0.3s ease;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
@endsection