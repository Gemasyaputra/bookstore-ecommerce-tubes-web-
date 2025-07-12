@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">All Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Items</th>
                <th>Total</th>
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
                <td>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>
                    @if($order->status == 'success')
                        {{ $order->updated_at->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('admin.orders.confirm', $order->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                Confirm Payment
                            </button>
                        </form>
                    @else
                        <span class="text-success">Paid</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
