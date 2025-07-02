@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Welcome, {{ Auth::user()->name }}</h2>
        <p class="text-muted">Here is the overview of your system.</p>

        <div class="row mt-4">
            <!-- Total Books -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Books</h5>
                        <p class="card-text display-6">{{ $stats['total_books'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-left-success">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text display-6">{{ $stats['total_categories'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Authors -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <h5 class="card-title">Authors</h5>
                        <p class="card-text display-6">{{ $stats['total_authors'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text display-6">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Low Stock Books -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm border-left-danger">
                    <div class="card-body">
                        <h5 class="card-title">Low Stock Books (&lt; 10)</h5>
                        <p class="card-text display-6 text-danger">{{ $stats['low_stock_books'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <h4>Latest Books</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestBooks as $index => $book)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->category->name ?? '-' }}</td>
                            <td>{{ $book->author->name ?? '-' }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td class="{{ $book->stock < 10 ? 'text-danger fw-bold' : '' }}">{{ $book->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No book data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



    </div>
@endsection
