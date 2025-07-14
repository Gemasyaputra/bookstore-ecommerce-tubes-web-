@extends('layouts.app')

@section('title', 'All Books - Bookstore')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold text-center">Explore Our Book Collection</h2>

    <!-- Search and Filter -->
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('books.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Search books..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4">
            <form method="GET" action="{{ route('books.index') }}">
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
    </div>

    <!-- Books Grid -->
    <div class="row">
    @forelse($books as $book)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm d-flex flex-row">
                @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" 
                         class="img-fluid" 
                         alt="{{ $book->title }}"
                         style="width: 150px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/150x200?text=No+Image" 
                         class="img-fluid" 
                         alt="No image" 
                         style="width: 150px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold mb-1">{{ $book->title }}</h6>
                    <p class="text-muted mb-1">by {{ $book->author->name }}</p>
                    <p class="text-muted mb-1"><small>{{ $book->category->name }}</small></p>
                    <p class="small mb-2">{{ Str::limit($book->description, 60) }}</p>
                    <p class="text-success fw-semibold mb-1">${{ number_format($book->price, 2) }}</p>
                    <p class="text-muted mb-2">Stock: {{ $book->stock }}</p>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm mt-auto w-100">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h4>No books found</h4>
                <p>Try adjusting your search or filter criteria.</p>
            </div>
        </div>
    @endforelse
</div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection
