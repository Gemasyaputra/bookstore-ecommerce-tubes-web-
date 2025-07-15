@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="h2 mb-1">My Orders</h1>
                        <p class="text-muted mb-0">Track and manage your book orders</p>
                    </div>
                    @if (count($orders) > 0)
                        <span class="badge bg-primary rounded-pill fs-6">{{ count($orders) }} orders</span>
                    @endif
                </div>

                @forelse ($orders as $order)
                    <div class="order-card card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="order-icon me-3">
                                            <i class="fas fa-receipt text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-semibold">Order #{{ $order->id }}</h5>
                                            <p class="text-muted mb-0 small">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                Placed on {{ $order->created_at->format('d M Y, g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <span
                                        class="status-badge badge rounded-pill px-3 py-2 
                                        {{ $order->status === 'pending' ? 'bg-warning text-dark' : '' }}
                                        {{ $order->status === 'success' ? 'bg-success' : '' }}
                                        {{ $order->status === 'rejected' ? 'bg-danger' : '' }}
                                        {{ !in_array($order->status, ['pending', 'success', 'rejected']) ? 'bg-secondary' : '' }}">
                                        <i
                                            class="fas fa-{{ $order->status === 'pending' ? 'clock' : ($order->status === 'success' ? 'check-circle' : ($order->status === 'rejected' ? 'times-circle' : 'question-circle')) }} me-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-box me-2"></i>Order Items
                                    </h6>
                                    <div class="order-items">
                                        @foreach ($order->items as $item)
                                            <div class="order-item d-flex align-items-center mb-3 p-3 bg-light rounded">
                                                <div class="book-thumbnail me-3">
                                                    <div class="book-placeholder bg-white rounded shadow-sm d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 65px;">
                                                        <i class="fas fa-book text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold">{{ $item->book->title }}</h6>
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <span class="me-3">
                                                            <i class="fas fa-hashtag me-1"></i>
                                                            Qty: {{ $item->quantity }}
                                                        </span>
                                                        <span>
                                                            <i class="fas fa-dollar-sign me-1"></i>
                                                            Unit Price: ${{ number_format($item->price, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="item-total fw-bold text-success">
                                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="order-summary bg-light rounded p-3">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-info-circle me-2"></i>Order Details
                                        </h6>

                                        <div class="detail-row mb-3">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-credit-card text-muted me-2 mt-1"></i>
                                                <div>
                                                    <small class="text-muted d-block">Payment Method</small>
                                                    <span class="fw-semibold">{{ ucfirst($order->payment_method) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-row mb-3">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-shipping-fast text-muted me-2 mt-1"></i>
                                                <div>
                                                    <small class="text-muted d-block">Shipping Address</small>
                                                    <span class="fw-semibold">{{ $order->shipping_address }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-3">

                                        <div class="total-section">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h6 mb-0">Total Amount</span>
                                                <span class="h5 mb-0 text-success fw-bold">
                                                    ${{ number_format($order->total, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-grid gap-2">
                                        @if ($order->status === 'pending')
                                            <button class="btn btn-outline-danger btn-sm"
                                                onclick="event.preventDefault(); document.getElementById('cancel-form-{{ $order->id }}').submit();">
                                                <i class="fas fa-times me-1"></i>Cancel Order
                                            </button>

                                            <!-- Hidden Cancel Form -->
                                            <form id="cancel-form-{{ $order->id }}"
                                                action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-orders text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-clipboard-list fa-4x text-muted opacity-50"></i>
                        </div>
                        <h3 class="h4 mb-3">No Orders Yet</h3>
                        <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders
                            here!</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .order-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .order-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .status-badge {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            min-width: 100px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .book-placeholder {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
        }

        .order-item {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .order-item:hover {
            border-color: #dee2e6;
            background-color: #f8f9fa !important;
        }

        .order-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
        }

        .detail-row {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.75rem;
        }

        .detail-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .item-total {
            font-size: 1.1rem;
        }

        .empty-orders {
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .empty-icon {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .bg-warning.text-dark {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
        }

        .bg-success {
            background: #28a745 !important;
        }

        .bg-danger {
            background: #dc3545 !important;
        }

        .bg-secondary {
            background: #6c757d !important;
        }

        @media (max-width: 768px) {
            .order-card .col-md-4 {
                margin-top: 1rem;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }

            .book-thumbnail {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
