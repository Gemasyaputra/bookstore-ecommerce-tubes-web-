@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h2>My Wishlist</h2>
        </div>
        @forelse($wishlist as $book)
            <div class="col-md-4 mb-3">
                <div class="card h-100 d-flex flex-row shadow-sm">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" 
                             alt="{{ $book->title }}" 
                             style="width: 100px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/100x150?text=No+Image" 
                             alt="No image" 
                             style="width: 100px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-1">{{ $book->title }}</h5>
                        <p class="card-text text-muted mb-2">by {{ $book->author->name }}</p>
                        <p class="card-text mb-2">Price: ${{ number_format($book->price, 2) }}</p>
                        <form method="POST" action="{{ route('wishlist.remove', $book->id) }}" class="mt-auto text-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>You have no books in your wishlist yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

