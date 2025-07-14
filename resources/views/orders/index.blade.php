@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="container py-4">
        <h2>My Orders</h2>

        @forelse ($orders as $order)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <strong>Order #{{ $order->id }}</strong> - {{ $order->created_at->format('d M Y') }}
                    </div>
                    <td>
                        <span
                            class="badge bg-{{ $order->status === 'pending'
                                ? 'warning'
                                : ($order->status === 'success'
                                    ? 'success'
                                    : ($order->status === 'rejected'
                                        ? 'danger'
                                        : 'secondary')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item->book->title }}</strong><br>
                                    <small>Qty: {{ $item->quantity }} | Price: ${{ number_format($item->price, 2) }}</small>
                                </div>
                                <div>${{ number_format($item->price * $item->quantity, 2) }}</div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <strong>Payment Method:</strong> {{ $order->payment_method }}<br>
                            <strong>Shipping:</strong> {{ $order->shipping_address }}
                        </div>
                        <h5>Total: ${{ number_format($order->total, 2) }}</h5>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">You have no orders yet.</div>
        @endforelse
    </div>
@endsection
