@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Checkout</h3>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="shipping_address" class="form-label">Shipping Address</label>
                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Select --</option>
                    <option value="transfer">Bank Transfer</option>
                    <option value="cod">Cash on Delivery</option>
                </select>
            </div>

            <div class="mb-3" id="payment_proof_section" style="display: none;">
                <label for="payment_proof" class="form-label">Upload Payment Proof</label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*">
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

@section('scripts')
    <script>
        const paymentMethod = document.getElementById('payment_method');
        const proofSection = document.getElementById('payment_proof_section');
        const proofInput = document.getElementById('payment_proof');

        function toggleProofRequirement() {
            if (paymentMethod.value === 'transfer') {
                proofSection.style.display = 'block';
                proofInput.setAttribute('required', 'required');
            } else {
                proofSection.style.display = 'none';
                proofInput.removeAttribute('required');
            }
        }

        paymentMethod.addEventListener('change', toggleProofRequirement);
        window.addEventListener('DOMContentLoaded', toggleProofRequirement); // on page load
    </script>

@endsection
