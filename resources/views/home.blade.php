@extends('layouts.app')

@section('title', 'Home - Bookstore')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-primary text-white p-5 rounded">
                <h1 class="display-4">Welcome to Our Bookstore</h1>
                <p class="lead">Discover amazing books from various categories</p>
                <a href="{{ route('books.index') }}" class="btn btn-light btn-lg">Browse Books</a>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Categories</h2>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="text-muted">{{ $category->books_count }} books</p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary">View Books</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Books -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Featured Books</h2>
            <div class="row">
                @foreach($featuredBooks as $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">by {{ $book->author->name }}</p>
                            <p class="card-text">
                                <small class="text-muted">{{ $book->category->name }}</small>
                            </p>
                            <p class="card-text">
                                <strong class="text-success">${{ number_format($book->price, 2) }}</strong>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection