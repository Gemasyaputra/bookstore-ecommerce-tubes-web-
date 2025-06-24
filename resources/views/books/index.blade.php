@extends('layouts.app')

@section('title', 'All Books - Bookstore')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">All Books</h1>
            
            <!-- Search and Filter -->
            <div class="row mb-4">
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
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">by {{ $book->author->name }}</p>
                            <p class="card-text">
                                <small class="text-muted">{{ $book->category->name }}</small>
                            </p>
                            <p class="card-text">{{ Str::limit($book->description, 80) }}</p>
                            <p class="card-text">
                                <strong class="text-success">${{ number_format($book->price, 2) }}</strong>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Stock: {{ $book->stock }}</small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm w-100">
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
            <div class="d-flex justify-content-center">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection