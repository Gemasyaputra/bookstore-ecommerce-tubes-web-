@extends('layouts.app')

@section('title', $book->title . ' - Bookstore')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">{{ $book->title }}</h1>
                        <p class="text-muted mb-3">by {{ $book->author->name }}</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Category:</strong> {{ $book->category->name }}</p>
                                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                <p><strong>Stock:</strong> {{ $book->stock }} available</p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">${{ number_format($book->price, 2) }}</h3>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>Description</h5>
                            <p>{{ $book->description }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('cart.add', $book) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>About the Author</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $book->author->name }}</h6>
                        <p>{{ $book->author->bio }}</p>
                    </div>
                </div>

                <!-- Related Books -->
                @if ($relatedBooks->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5>Related Books</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($relatedBooks as $relatedBook)
                                <div class="d-flex mb-3">
                                    <div class="flex-grow-1">
                                        <h6><a
                                                href="{{ route('books.show', $relatedBook) }}">{{ $relatedBook->title }}</a>
                                        </h6>
                                        <small class="text-muted">${{ number_format($relatedBook->price, 2) }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection@extends('layouts.app')

@section('title', $book->title . ' - Bookstore')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">{{ $book->title }}</h1>
                        <p class="text-muted mb-3">by {{ $book->author->name }}</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Category:</strong> {{ $book->category->name }}</p>
                                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                <p><strong>Stock:</strong> {{ $book->stock }} available</p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-success">${{ number_format($book->price, 2) }}</h3>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>Description</h5>
                            <p>{{ $book->description }}</p>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-lg">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>About the Author</h5>
                    </div>
                    <div class="card-body">
                        <h6>{{ $book->author->name }}</h6>
                        <p>{{ $book->author->bio }}</p>
                    </div>
                </div>

                <!-- Related Books -->
                @if ($relatedBooks->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5>Related Books</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($relatedBooks as $relatedBook)
                                <div class="d-flex mb-3">
                                    <div class="flex-grow-1">
                                        <h6><a
                                                href="{{ route('books.show', $relatedBook) }}">{{ $relatedBook->title }}</a>
                                        </h6>
                                        <small class="text-muted">${{ number_format($relatedBook->price, 2) }}</small>
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
