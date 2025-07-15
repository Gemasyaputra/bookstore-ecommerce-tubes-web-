@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="h2 mb-1">Orders Management</h1>
                        <p class="text-muted mb-0">Manage and track all customer orders</p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary fs-6">{{ count($orders) }} orders</span>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">All Orders</a></li>
                                <li><a class="dropdown-item" href="#">Pending</a></li>
                                <li><a class="dropdown-item" href="#">Confirmed</a></li>
                                <li><a class="dropdown-item" href="#">Rejected</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Orders Cards -->
                <div class="row g-4">
                    @forelse ($orders as $order)
                        <div class="col-12">
                            <div class="order-management-card card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <!-- Order Header -->
                                        <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                                            <div class="order-header">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="order-icon me-3">
                                                        <i class="fas fa-receipt"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-primary">Order #{{ $order->id }}</h6>
                                                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Customer Info -->
                                                <div class="customer-info d-flex align-items-center mt-3">
                                                    <div class="avatar bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold small">{{ $order->user->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.8rem;">{{ $order->user->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Items -->
                                        <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                                            <div class="order-items">
                                                <h6 class="text-muted mb-2 small">
                                                    <i class="fas fa-box me-1"></i>Items
                                                </h6>
                                                <div class="items-scroll">
                                                    @foreach ($order->items as $item)
                                                        <div class="item-card d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded">
                                                            <div class="item-info">
                                                                <div class="item-title small fw-semibold">{{ Str::limit($item->book->title, 20) }}</div>
                                                                <div class="item-price text-muted" style="font-size: 0.75rem;">${{ number_format($item->price, 2) }}</div>
                                                            </div>
                                                            <span class="badge bg-secondary">{{ $item->quantity }}x</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Details -->
                                        <div class="col-lg-2 col-md-4 mb-3 mb-md-0">
                                            <div class="order-details text-center">
                                                <div class="total-amount mb-2">
                                                    <small class="text-muted d-block">Total</small>
                                                    <h5 class="mb-0 text-success fw-bold">${{ number_format($order->total, 2) }}</h5>
                                                </div>
                                                
                                                <!-- Payment Method -->
                                                <div class="payment-method mb-2">
                                                    <small class="text-muted d-block">Payment</small>
                                                    @if ($order->payment_method === 'transfer')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-university me-1"></i>Transfer
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-truck me-1"></i>COD
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Proof -->
                                        <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                                            <div class="payment-proof text-center">
                                                <small class="text-muted d-block mb-2">Payment Proof</small>
                                                @if ($order->payment_method === 'transfer')
                                                    @if ($order->payment_proof)
                                                        <div class="proof-actions">
                                                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                                                class="btn btn-outline-info btn-sm mb-1" title="View Proof">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ asset('storage/' . $order->payment_proof) }}" download
                                                                class="btn btn-outline-primary btn-sm" title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle me-1"></i>No Proof
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Status & Actions -->
                                        <div class="col-lg-2 col-md-6">
                                            <div class="status-actions text-center">
                                                <!-- Status -->
                                                <div class="status-section mb-3">
                                                    @php
                                                        $statusConfig = [
                                                            'pending' => ['class' => 'warning text-dark', 'icon' => 'clock'],
                                                            'success' => ['class' => 'success', 'icon' => 'check-circle'],
                                                            'rejected' => ['class' => 'danger', 'icon' => 'times-circle'],
                                                        ];
                                                        $config = $statusConfig[$order->status] ?? ['class' => 'secondary', 'icon' => 'question'];
                                                    @endphp
                                                    <span class="status-badge badge bg-{{ $config['class'] }} px-3 py-2 rounded-pill">
                                                        <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>

                                                <!-- Confirmed Date -->
                                                @if ($order->status == 'success')
                                                    <div class="confirmed-date mb-3">
                                                        <small class="text-muted d-block">Confirmed</small>
                                                        <div class="text-success fw-medium small">{{ $order->updated_at->format('d M Y') }}</div>
                                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $order->updated_at->format('H:i') }}</div>
                                                    </div>
                                                @endif

                                                <!-- Actions -->
                                                @if ($order->status === 'pending')
                                                    <div class="action-buttons d-grid gap-2">
                                                        <form method="POST" action="{{ route('admin.orders.confirm', $order->id) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success btn-sm w-100 rounded-pill"
                                                                onclick="return confirm('Confirm this order?')">
                                                                <i class="fas fa-check me-1"></i>Confirm
                                                            </button>
                                                        </form>

                                                        <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}"
                                                            onsubmit="return confirm('Are you sure you want to reject this order?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill">
                                                                <i class="fas fa-times me-1"></i>Reject
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="final-status">
                                                        <span class="badge bg-light text-dark border">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-orders text-center py-5">
                                <div class="empty-icon mb-4">
                                    <i class="fas fa-shopping-cart fa-4x text-muted opacity-50"></i>
                                </div>
                                <h3 class="h4 mb-3">No Orders Found</h3>
                                <p class="text-muted mb-4">There are no orders to display at the moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-management-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: 1px solid #f1f3f4;
        }
        
        .order-management-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        
        .order-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #1976d2;
        }
        
        .avatar {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
        }
        
        .items-scroll {
            max-height: 120px;
            overflow-y: auto;
        }
        
        .items-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .items-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .items-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .item-card {
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .item-card:hover {
            border-color: #dee2e6;
            background-color: #f8f9fa !important;
        }
        
        .status-badge {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            min-width: 90px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .action-buttons .btn {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.4rem 1rem;
            transition: all 0.2s ease;
        }
        
        .action-buttons .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .proof-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .proof-actions .btn {
            width: 35px;
            height: 35px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .empty-orders {
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .empty-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .alert {
            border-radius: 12px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .bg-warning.text-dark {
            background: #ffc107 !important;
            color: #212529 !important;
        }
        
        .bg-success {
            background: #28a745 !important;
        }
        
        .bg-danger {
            background: #dc3545 !important;
        }
        
        .bg-info {
            background: #17a2b8 !important;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .order-management-card .card-body {
                padding: 1.5rem;
            }
            
            .status-actions,
            .payment-proof,
            .order-details {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .order-management-card .card-body {
                padding: 1rem;
            }
            
            .order-header,
            .order-items,
            .order-details,
            .payment-proof,
            .status-actions {
                text-align: center;
                margin-bottom: 1.5rem;
            }
            
            .customer-info {
                justify-content: center;
            }
            
            .items-scroll {
                max-height: 100px;
            }
            
            .proof-actions {
                justify-content: center;
            }
        }
    </style>
@endsection