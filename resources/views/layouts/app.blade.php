<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bookstore')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        .transition-navbar {
            transition: background-color 0.4s ease, box-shadow 0.4s ease;
        }

        .navbar.scrolled {
            background-color: #0d6efd !important;
            /* sama dengan bg-primary */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }
    </style>

</head>

<body class="d-flex flex-column h-100">
    <!-- Navbar -->
    <nav id="mainNavbar"
        class="navbar navbar-expand-lg navbar-dark 
    {{ View::hasSection('transparent') ? 'bg-transparent position-fixed top-0 start-0 w-100 z-3 transition-navbar' : 'bg-primary' }}">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-book me-1"></i> Bookstore
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Kiri -->
                <ul class="navbar-nav me-auto">
                    @unless (Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('books.index') }}">
                                <i class="fas fa-book-open me-1"></i> Books
                            </a>
                        </li>
                    @endunless

                    @auth
                        @if (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Admin Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-box me-1"></i> Manage Orders
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <i class="fas fa-list me-1"></i> My Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('wishlist.index') }}">
                                    <i class="fas fa-heart me-1"></i> Wishlist
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
{{-- kanan --}}
                <ul class="navbar-nav ms-auto">
                    @unless (Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Cart
                                @if (session('cart') && count(session('cart')) > 0)
                                    <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </li>
                    @endunless

                    @auth
                        <li class="nav-item d-flex align-items-center me-2 text-white">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>


    <!-- Content -->
    <main class="flex-shrink-0 pt-0">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} <a href="{{ route('home') }}"
                    class="text-white text-decoration-none">Bookstore</a>. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
