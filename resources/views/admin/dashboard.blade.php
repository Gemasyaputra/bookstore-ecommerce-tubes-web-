@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-muted mb-0">Here's what's happening with your library system today.</p>
            </div>
            <div class="text-end">
                <small class="text-muted">{{ date('l, F j, Y') }}</small>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <!-- Total Books -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-gradient p-3">
                                    <i class="fas fa-book text-white fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Total Books</h6>
                                <h3 class="mb-0 fw-bold text-primary">{{ number_format($stats['total_books']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-gradient p-3">
                                    <i class="fas fa-tags text-white fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Categories</h6>
                                <h3 class="mb-0 fw-bold text-success">{{ number_format($stats['total_categories']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Authors -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-info bg-gradient p-3">
                                    <i class="fas fa-users text-white fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Authors</h6>
                                <h3 class="mb-0 fw-bold text-info">{{ number_format($stats['total_authors']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-warning bg-gradient p-3">
                                    <i class="fas fa-user-friends text-white fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Users</h6>
                                <h3 class="mb-0 fw-bold text-warning">{{ number_format($stats['total_users']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Section for Low Stock -->
        @if($stats['low_stock_books'] > 0)
            <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Low Stock Alert!</strong> 
                        You have <span class="badge bg-danger">{{ $stats['low_stock_books'] }}</span> books with less than 10 items in stock.
                    </div>
                </div>
            </div>
        @endif

        <!-- Latest Books Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">📚 Latest Books</h4>
                        <small class="text-muted">Recently added books in your library</small>
                    </div>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-plus me-1"></i> Add New Book
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 text-muted fw-semibold">#</th>
                                <th class="border-0 text-muted fw-semibold">Book Details</th>
                                <th class="border-0 text-muted fw-semibold">Category</th>
                                <th class="border-0 text-muted fw-semibold">Author</th>
                                <th class="border-0 text-muted fw-semibold">Price</th>
                                <th class="border-0 text-muted fw-semibold">Stock</th>
                                <th class="border-0 text-muted fw-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestBooks as $index => $book)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-gradient rounded p-2 me-3">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $book->title }}</h6>
                                                <small class="text-muted">ID: {{ $book->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if($book->category)
                                            <span class="badge bg-success bg-gradient">{{ $book->category->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">No Category</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($book->author)
                                            <span class="text-dark">{{ $book->author->name }}</span>
                                        @else
                                            <span class="text-muted">No Author</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="fw-semibold text-success">${{ number_format($book->price, 2) }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if($book->stock < 10)
                                            <span class="badge bg-danger">{{ $book->stock }} - Low Stock</span>
                                        @elseif($book->stock < 20)
                                            <span class="badge bg-warning">{{ $book->stock }} - Medium</span>
                                        @else
                                            <span class="badge bg-success">{{ $book->stock }} - Good</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.books.edit', $book) }}" 
                                               class="btn btn-outline-primary" 
                                               title="Edit Book">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger" 
                                                        title="Delete Book">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-book-open fa-3x mb-3"></i>
                                            <h5>No books available yet</h5>
                                            <p>Start by adding your first book to the library</p>
                                            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Add First Book
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($latestBooks->hasPages())
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-center">
                        {{ $latestBooks->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .btn-group-sm > .btn, .btn-sm {
            border-radius: 0.375rem;
        }
        
        .badge {
            font-size: 0.75em;
        }
        
        .alert {
            border-radius: 0.5rem;
        }
        
        .rounded-circle {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection