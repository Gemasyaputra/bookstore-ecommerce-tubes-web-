@extends('layouts.app')

@section('title', 'All Books - Bookstore')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="h2 mb-3">
            <i class="fas fa-book-open me-2 text-primary"></i>
            Explore Our Book Collection
        </h1>
        <p class="text-muted">Discover your next great read from our extensive library</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Search Form -->
                <div class="col-lg-6">
                    <form method="GET" action="{{ route('books.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search " 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category Filter -->
                <div class="col-lg-3">
                    <form method="GET" action="{{ route('books.index') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Sort Options -->
                <div class="col-lg-3">
                    <form method="GET" action="{{ route('books.index') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort by...</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                                Title (A-Z)
                            </option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                                Title (Z-A)
                            </option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Price (Low to High)
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Price (High to Low)
                            </option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Newest First
                            </option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('category') || request('sort'))
            <div class="mt-3 pt-3 border-top">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="text-muted small">Active filters:</span>
                    
                    @if(request('search'))
                    <span class="badge bg-primary">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('books.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" 
                           class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    @if(request('category'))
                    <span class="badge bg-secondary">
                        Category: {{ $categories->find(request('category'))->name ?? 'Unknown' }}
                        <a href="{{ route('books.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" 
                           class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    @if(request('sort'))
                    <span class="badge bg-info">
                        Sort: {{ ucfirst(str_replace('_', ' ', request('sort'))) }}
                        <a href="{{ route('books.index', array_filter(['search' => request('search'), 'category' => request('category')])) }}" 
                           class="text-white ms-1">×</a>
                    </span>
                    @endif
                    
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
                        Clear all filters
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Results Summary -->
    @if($books->count() > 0)
    <div class="mb-3">
        <p class="text-muted">
            Showing {{ $books->firstItem() }}-{{ $books->lastItem() }} of {{ $books->total() }} books
        </p>
    </div>
    @endif

    <!-- Books Grid -->
    <div class="row">
        @forelse($books as $book)
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="row g-0 h-100">
                    <!-- Book Image -->
                    <div class="col-4">
                        <div class="position-relative h-100">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" 
                                     class="img-fluid w-100 h-100" 
                                     alt="{{ $book->title }}"
                                     style="object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="fas fa-book text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if ($book->stock == 0)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-1 small">
                                    Out of Stock
                                </span>
                            @elseif ($book->stock < 5)
                                <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-1 small">
                                    Low Stock
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="col-8">
                        <div class="card-body d-flex flex-column h-100 p-3">
                            <!-- Title -->
                            <h6 class="card-title mb-1">
                                <a href="{{ route('books.show', $book) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $book->title }}
                                </a>
                            </h6>
                            
                            <!-- Author -->
                            <p class="text-muted mb-1 small">
                                <i class="fas fa-user me-1"></i>
                                by {{ $book->author->name }}
                            </p>
                            
                            <!-- Category -->
                            <p class="mb-2">
                                <span class="badge bg-light text-dark small">
                                    {{ $book->category->name }}
                                </span>
                            </p>
                            
                            <!-- Description -->
                            <p class="text-muted small mb-2 flex-grow-1">
                                {{ Str::limit($book->description, 80) }}
                            </p>
                            
                            <!-- Price and Stock -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success fw-semibold">
                                    ${{ number_format($book->price, 2) }}
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $book->stock }} in stock
                                </small>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-1">
                                <a href="{{ route('books.show', $book) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>
                                    View Details
                                </a>
                                
                                @if ($book->stock > 0)
                                <div class="row g-1">
                                    <div class="col-8">
                                        <form method="POST" action="{{ route('cart.add', $book) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-cart-plus me-1"></i>
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-4">
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
                                    <div class="col-8">
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times me-1"></i>
                                            Out of Stock
                                        </button>
                                    </div>
                                    <div class="col-4">
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
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted mb-3">No books found</h4>
                <p class="text-muted mb-4">
                    @if(request('search') || request('category'))
                        Try adjusting your search or filter criteria.
                    @else
                        We're working on adding more books to our collection.
                    @endif
                </p>
                @if(request('search') || request('category'))
                <a href="{{ route('books.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>
                    View All Books
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Books pagination">
           {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}

        </nav>
    </div>
    @endif
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-title a:hover {
    color: #0d6efd !important;
}

.input-group-text {
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}

.input-group .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

</style>
@endsection