@extends('layouts.app')

@section('title', $category->name . ' Books - Bookstore')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>{{ $category->name }}</h1>
                    <p class="text-muted">{{ $category->description }}</p>
                </div>
                <div>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> All Books
                    </a>
                </div>
            </div>
            
            <!-- Books in this category -->
            <div class="row">
                @forelse($books as $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">by {{ $book->author->name }}</p>
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
                        <h4>No books found in this category</h4>
                        <p>Check back later for new additions!</p>
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