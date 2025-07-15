@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Progress Steps -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="step-item completed">
                                    <div class="step-number">1</div>
                                    <div class="step-title">Cart</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="step-item active">
                                    <div class="step-number">2</div>
                                    <div class="step-title">Checkout</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="step-item">
                                    <div class="step-number">3</div>
                                    <div class="step-title">Complete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Checkout Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Shipping Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-shipping-fast me-2 text-primary"></i>
                                        Shipping Information
                                    </h5>
                                    <div class="mb-3">
                                        <label for="shipping_address" class="form-label fw-bold">
                                            Shipping Address <span class="text-danger">*</span>
                                        </label>
                                        <textarea 
                                            name="shipping_address" 
                                            id="shipping_address" 
                                            class="form-control form-control-lg" 
                                            rows="4" 
                                            placeholder="Enter your complete shipping address including city, postal code, and country"
                                            required
                                        ></textarea>
                                        <div class="form-text">
                                            Please provide a complete address for accurate delivery
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-credit-card me-2 text-primary"></i>
                                        Payment Information
                                    </h5>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label fw-bold">
                                            Payment Method <span class="text-danger">*</span>
                                        </label>
                                        <select name="payment_method" id="payment_method" class="form-select form-select-lg" required>
                                            <option value="">-- Select Payment Method --</option>
                                            <option value="transfer">
                                                <i class="fas fa-university"></i> Bank Transfer
                                            </option>
                                            <option value="cod">
                                                <i class="fas fa-hand-holding-usd"></i> Cash on Delivery
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Payment Proof Section -->
                                    <div class="mb-3" id="payment_proof_section" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Bank Transfer Details
                                            </h6>
                                            <p class="mb-2">Please transfer the total amount to:</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="bg-light p-3 rounded">
                                                        <div class="mb-2">
                                                            <strong>Bank Name:</strong> Bank Mandiri
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong>Account Name:</strong> PT. Bookstore Indonesia
                                                        </div>
                                                        <div class="mb-0">
                                                            <strong>Account Number:</strong> 
                                                            <span class="badge bg-primary">123-456-7890</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <label for="payment_proof" class="form-label fw-bold">
                                            Upload Payment Proof <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="file" 
                                            name="payment_proof" 
                                            id="payment_proof" 
                                            class="form-control form-control-lg" 
                                            accept="image/*,application/pdf"
                                        >
                                        <div class="form-text">
                                            Upload your transfer receipt (JPG, PNG, or PDF format)
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-receipt me-2 text-primary"></i>
                                                Order Summary
                                            </h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 mb-0">Total Amount:</span>
                                                <span class="h4 mb-0 text-primary fw-bold">
                                                    ${{ number_format($total, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg py-3">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            Place Order
                                        </button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Your order is secure and protected
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .step-item {
            position: relative;
            padding: 10px;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 10px;
            border: 2px solid #e9ecef;
        }
        
        .step-item.completed .step-number {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
        
        .step-item.active .step-number {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .step-title {
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
        }
        
        .step-item.completed .step-title,
        .step-item.active .step-title {
            color: #495057;
            font-weight: 600;
        }
        
        .card {
            border: none;
            border-radius: 10px;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .alert-info {
            border: none;
            background-color: #e3f2fd;
            color: #0d47a1;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .step-title {
                font-size: 12px;
            }
            
            .step-number {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }
    </style>
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
                
                // Smooth scroll to payment proof section
                setTimeout(() => {
                    proofSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest' 
                    });
                }, 100);
            } else {
                proofSection.style.display = 'none';
                proofInput.removeAttribute('required');
            }
        }

        // Form validation feedback
        function showValidationFeedback() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });
        }

        // Event listeners
        paymentMethod.addEventListener('change', toggleProofRequirement);
        window.addEventListener('DOMContentLoaded', function() {
            toggleProofRequirement();
            showValidationFeedback();
        });

        // File upload preview
        document.getElementById('payment_proof').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                // Show file info
                let fileInfo = document.getElementById('file-info');
                if (!fileInfo) {
                    fileInfo = document.createElement('div');
                    fileInfo.id = 'file-info';
                    fileInfo.className = 'alert alert-success mt-2';
                    e.target.parentNode.appendChild(fileInfo);
                }
                
                fileInfo.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>File selected:</strong> ${fileName} (${fileSize} MB)
                `;
            }
        });
    </script>
@endsection