@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Checkout</h3>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address</label>
            <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select" required>
                <option value="cod">Cash on Delivery</option>
                <option value="bank">Bank Transfer</option>
            </select>
        </div>

        <h5>Total: <strong>${{ number_format($total, 2) }}</strong></h5>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart"></i> Place Order
            </button>
        </div>
    </form>
</div>
@endsection
