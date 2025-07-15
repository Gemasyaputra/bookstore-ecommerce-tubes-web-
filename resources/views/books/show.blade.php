@extends('layouts.app')

@section('title', $book->title . ' - Bookstore')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Book Header -->
                        <div class="mb-4">
                            <h1 class="h2 mb-2">{{ $book->title }}</h1>
                            <p class="text-muted mb-0">by <strong>{{ $book->author->name }}</strong></p>
                        </div>

                        <!-- Book Details Grid -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex flex-column gap-2">
                                    <div>
                                        <span class="text-muted">Category:</span>
                                        <span class="badge bg-secondary ms-2">{{ $book->category->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">ISBN:</span>
                                        <span class="ms-2">{{ $book->isbn }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Stock:</span>
                                        <span class="ms-2">
                                            @if ($book->stock == 0)
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @elseif ($book->stock < 5)
                                                <span class="badge bg-warning text-dark">{{ $book->stock }} left</span>
                                            @else
                                                <span class="badge bg-success">{{ $book->stock }} available</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="price-section">
                                    <h2 class="text-success mb-0">${{ number_format($book->price, 2) }}</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5 class="mb-3">Description</h5>
                            <p class="text-muted">{{ $book->description }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2">
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('cart.add', $book) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg w-100" {{ $book->stock == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus me-2"></i>
                                        {{ $book->stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('wishlist.add', $book->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-lg w-100">
                                        <i class="fas fa-heart me-2"></i>
                                        Add to Wishlist
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Stock Warning -->
                        @if ($book->stock == 0)
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                This book is currently out of stock. Add it to your wishlist to be notified when it's available!
                            </div>
                        @elseif ($book->stock < 5)
                            <div class="alert alert-warning mt-3" role="alert">
                                <i class="fas fa-clock me-2"></i>
                                Hurry! Only {{ $book->stock }} copies left in stock.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Book Image -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $book->image) }}" 
                                 alt="{{ $book->title }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>
                            About the Author
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-primary mb-2">{{ $book->author->name }}</h6>
                        <p class="text-muted small mb-0">{{ $book->author->bio }}</p>
                    </div>
                </div>

                <!-- Related Books -->
                @if ($relatedBooks->count() > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-book me-2"></i>
                                Related Books
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach ($relatedBooks as $relatedBook)
                                <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('books.show', $relatedBook) }}" 
                                               class="text-decoration-none">
                                                {{ $relatedBook->title }}
                                            </a>
                                        </h6>
                                        <p class="text-muted small mb-1">by {{ $relatedBook->author->name }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-success fw-semibold">
                                                ${{ number_format($relatedBook->price, 2) }}
                                            </span>
                                            @if ($relatedBook->stock == 0)
                                                <span class="badge bg-danger small">Out of Stock</span>
                                            @elseif ($relatedBook->stock < 5)
                                                <span class="badge bg-warning text-dark small">Low Stock</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection