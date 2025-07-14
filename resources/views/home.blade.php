@extends('layouts.app')

@section('title', 'Home - Bookstore')
@section('transparent', true)
@section('content')
    <div class="container-fluid px-0">
        <!-- Hero Section -->
        <div class="hero-section position-relative overflow-hidden mb-5">
            <div class="hero-bg"></div>
            <div class="container py-5">
                <div class="row align-items-center min-vh-50">
                    <div class="col-lg-6">
                        <div class="hero-content text-white">
                            <h1 class="display-3 fw-bold mb-4 animate-fadeInUp">
                                Welcome to Our <span class="text-info">Bookstore</span>
                            </h1>
                            <p class="lead mb-4 animate-fadeInUp" style="animation-delay: 0.2s;">
                                Discover thousands of amazing books from various categories. 
                                Your next great read is just a click away.
                            </p>
                            <div class="d-flex gap-3 animate-fadeInUp" style="animation-delay: 0.4s;">
                                <a href="{{ route('books.index') }}" class="btn btn-info btn-lg px-4 py-2 fw-semibold" role="button">
                                    <i class="fas fa-book me-2"></i>Browse Books
                                </a>
                                <a href="#categories" class="btn btn-outline-light btn-lg px-4 py-2">
                                    <i class="fas fa-list me-2"></i>Categories
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image text-center animate-fadeInRight">
                            <div class="floating-books">
                                <i class="fas fa-book-open fa-3x text-info opacity-75"></i>
                                <i class="fas fa-book fa-2x text-light opacity-50"></i>
                                <i class="fas fa-bookmark fa-2x text-primary opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Bar -->
        <div class="stats-section bg-light py-4 mb-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="stat-item">
                            <i class="fas fa-book text-primary fa-2x mb-2"></i>
                            <h3 class="fw-bold text-primary">1000+</h3>
                            <p class="text-muted">Books Available</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <i class="fas fa-users text-primary fa-2x mb-2"></i>
                            <h3 class="fw-bold text-primary">500+</h3>
                            <p class="text-muted">Happy Customers</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <i class="fas fa-star text-primary fa-2x mb-2"></i>
                            <h3 class="fw-bold text-primary">4.8</h3>
                            <p class="text-muted">Average Rating</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <i class="fas fa-shipping-fast text-primary fa-2x mb-2"></i>
                            <h3 class="fw-bold text-primary">24h</h3>
                            <p class="text-muted">Fast Delivery</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="container mb-5" id="categories">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Explore Categories</h2>
                    <p class="lead text-muted">Find your favorite genre and discover new worlds</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="category-card card h-100 border-0 shadow-sm hover-lift">
                            <div class="card-body text-center p-4">
                                <div class="category-icon mb-3">
                                    <i class="fas fa-book-open fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-book me-1"></i>
                                    {{ $category->books_count }} books available
                                </p>
                                <a href="{{ route('categories.show', $category) }}" 
                                   class="btn btn-outline-primary btn-sm px-3">
                                    <i class="fas fa-arrow-right me-1"></i>Explore
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Featured Books Section -->
        <div class="featured-books-section bg-light py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h2 class="display-5 fw-bold mb-3">Featured Books</h2>
                        <p class="lead text-muted">Handpicked selections from our collection</p>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="book-card card h-100 border-0 shadow-sm hover-lift">
                                <div class="book-image-container position-relative">
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" 
                                             class="card-img-top book-image" 
                                             alt="{{ $book->title }}">
                                    @else
                                        <img src="{{ asset('images/default-book.png') }}" 
                                             class="card-img-top book-image" 
                                             alt="No Image">
                                    @endif
                                    <div class="book-overlay">
                                        <a href="{{ route('books.show', $book) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Quick View
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="card-title fw-bold mb-2 text-truncate">{{ $book->title }}</h6>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-user me-1"></i>{{ $book->author->name }}
                                    </p>
                                    <p class="card-text mb-2">
                                        <span class="badge bg-light text-dark">{{ $book->category->name }}</span>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price fw-bold text-primary">
                                            ${{ number_format($book->price, 2) }}
                                        </span>
                                        <div class="rating text-info">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 p-3 pt-0">
                                    <a href="{{ route('books.show', $book) }}" 
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-info-circle me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-book me-2"></i>View All Books
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        {{-- <div class="newsletter-section bg-primary text-white py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h3 class="fw-bold mb-3">Stay Updated</h3>
                        <p class="mb-0">Subscribe to our newsletter and get notified about new arrivals and special offers.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="email" class="form-control form-control-lg" 
                                   placeholder="Enter your email address">
                            <button class="btn btn-info btn-lg px-4" type="button">
                                <i class="fas fa-paper-plane me-1"></i>Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <style>
        .hero-section {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            min-height: 60vh;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" fill-opacity="0.1"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        .book-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-image-container {
            overflow: hidden;
        }

        .book-image-container:hover .book-image {
            transform: scale(1.05);
        }

        .book-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .book-image-container:hover .book-overlay {
            opacity: 1;
        }

        .floating-books {
            position: relative;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .floating-books i {
            position: absolute;
            animation: float 3s ease-in-out infinite;
        }

        .floating-books i:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }

        .floating-books i:nth-child(2) {
            top: 60%;
            right: 30%;
            animation-delay: 1s;
        }

        .floating-books i:nth-child(3) {
            bottom: 20%;
            left: 60%;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-fadeInRight {
            animation: fadeInRight 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .stats-section .stat-item {
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .stats-section .stat-item:hover {
            transform: translateY(-5px);
        }

        .price {
            font-size: 1.1em;
        }

        .rating {
            font-size: 0.9em;
        }

        .min-vh-50 {
            min-height: 50vh;
        }

        .newsletter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-warning {
            color: #000;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 50vh;
            }
            
            .display-3 {
                font-size: 2.5rem;
            }
            
            .floating-books {
                height: 200px;
            }
        }
    </style>
@endsection