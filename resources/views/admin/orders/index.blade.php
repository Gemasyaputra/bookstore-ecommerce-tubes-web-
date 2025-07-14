@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">All Orders</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Proof</th> <!-- Tambahan kolom -->
                    <th>Status</th>
                    <th>Confirmed At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}<br><small>{{ $order->user->email }}</small></td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->book->title }} × {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>${{ number_format($order->total, 2) }}</td>

                        <!-- Bukti Pembayaran -->
                        <td>
                            @if ($order->payment_method === 'transfer')
                                @if ($order->payment_proof)
                                    <div class="d-flex flex-column gap-1">
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                            class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-eye me-1"></i> View Proof
                                        </a>
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" download
                                            class="btn btn-primary btn-sm text-white">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </div>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> No Proof
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-primary">
                                    <i class="fas fa-truck me-1"></i> COD
                                </span>
                            @endif
                        </td>




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

                        <td>
                            @if ($order->status == 'success')
                                {{ $order->updated_at->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($order->status === 'pending')
                                @if ($order->payment_method === 'transfer' && $order->payment_proof)
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                        class="btn btn-info btn-sm mb-1">
                                        View Proof
                                    </a>
                                    <a href="{{ route('admin.orders.downloadProof', $order->id) }}"
                                        class="btn btn-secondary btn-sm mb-1">
                                        Download
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('admin.orders.confirm', $order->id) }}"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm mb-1">Confirm</button>
                                </form>

                                <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to reject this order?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                <span class="text-{{ $order->status === 'success' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
