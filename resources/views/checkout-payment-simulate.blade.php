@extends('layouts.app')

@section('title', 'Sandbox Payment Simulation - Al Barr | Kashmiri Organic Staples')

@section('styles')
    <style>
        .simulate-wrap {
            padding: 80px 0 100px;
            background-color: var(--color-cream);
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .simulate-card {
            background: var(--color-cream-card);
            border: 2px dashed var(--color-gold);
            border-radius: var(--radius-sm);
            padding: var(--spacing-xl);
            max-width: 500px;
            width: 100%;
            box-shadow: var(--shadow-md);
            text-align: center;
        }

        .sandbox-badge {
            background-color: var(--color-gold-light);
            color: var(--color-gold-hover);
            border: 1px solid var(--color-gold);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .simulate-title {
            font-family: var(--font-secondary);
            font-size: 1.5rem;
            color: var(--color-brand-green);
            font-weight: 800;
            margin-bottom: 10px;
        }

        .simulate-desc {
            font-size: 0.9rem;
            color: var(--color-text-secondary);
            margin-bottom: var(--spacing-lg);
            line-height: 1.5;
        }

        .order-info-box {
            background-color: rgba(1, 136, 73, 0.02);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: var(--spacing-xl);
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.88rem;
        }

        .info-row:last-child {
            margin-bottom: 0;
            padding-top: 8px;
            border-top: 1px solid var(--color-border-light);
        }

        .info-label {
            color: var(--color-text-muted);
            font-weight: 600;
        }

        .info-val {
            color: var(--color-text-primary);
            font-weight: 700;
        }

        .info-val.total {
            color: var(--color-brand-green);
            font-size: 1.1rem;
            font-weight: 800;
        }

        .btn-group-simulate {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-sim {
            width: 100%;
            padding: 14px 20px;
            border-radius: 50px;
            font-family: var(--font-secondary);
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-sim-success {
            background: var(--color-brand-green);
            color: #fff;
            box-shadow: 0 4px 15px rgba(1, 136, 73, 0.2);
        }

        .btn-sim-success:hover {
            background-color: var(--color-brand-green-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(1, 136, 73, 0.3);
        }

        .btn-sim-fail {
            background-color: #fff;
            border: 1.5px solid var(--color-red);
            color: var(--color-red);
        }

        .btn-sim-fail:hover {
            background-color: var(--color-red);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(186, 60, 28, 0.15);
        }

        .sim-spinner {
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 2.5px solid #fff;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: none;
        }

        .btn-sim-fail .sim-spinner {
            border-color: rgba(186, 60, 28, 0.3);
            border-top-color: var(--color-red);
        }

        .btn-sim-fail:hover .sim-spinner {
            border-color: rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <div class="simulate-wrap">
        <div class="simulate-card">
            <span class="sandbox-badge">Sandbox Simulation</span>
            
            <h1 class="simulate-title">{{ $method }} Payment Gateway</h1>
            <p class="simulate-desc">You have been redirected to the simulated payment portal. Choose an option below to simulate the transaction response.</p>
            
            <div class="order-info-box">
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span class="info-val" style="font-family: var(--font-mono)">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-val">{{ $order->shipping_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-val">{{ $order->payment_method }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Amount Due:</span>
                    <span class="info-val total">₹{{ number_format($order->grand_total, 2) }}</span>
                </div>
            </div>

            <div class="btn-group-simulate">
                <button class="btn-sim btn-sim-success" id="btn-success" onclick="processSimulated('success')">
                    <span class="sim-spinner" id="spin-success"></span>
                    <span>Simulate Successful Payment</span>
                </button>
                
                <button class="btn-sim btn-sim-fail" id="btn-fail" onclick="processSimulated('failed')">
                    <span class="sim-spinner" id="spin-fail"></span>
                    <span>Simulate Failed Payment</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function processSimulated(status) {
            const btnSuccess = document.getElementById('btn-success');
            const btnFail = document.getElementById('btn-fail');
            const spinSuccess = document.getElementById('spin-success');
            const spinFail = document.getElementById('spin-fail');

            // Disable buttons and show spinner
            btnSuccess.disabled = true;
            btnFail.disabled = true;
            if (status === 'success') {
                spinSuccess.style.display = 'inline-block';
            } else {
                spinFail.style.display = 'inline-block';
            }

            const payload = {
                order_number: '{{ $order->order_number }}',
                status: status,
                payment_method: '{{ $order->payment_method }}'
            };

            fetch('/checkout/payment/simulate/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (status === 'success') {
                        // Clear the local cart on successful verification
                        if (typeof AlBarrCart !== 'undefined') {
                            AlBarrCart.clear();
                        } else {
                            localStorage.removeItem('al_barr_cart');
                        }
                        sessionStorage.removeItem('al_barr_coupon_applied');
                        window.location.href = data.redirect_url;
                    } else {
                        // On failed payment, redirect back to checkout and display message
                        sessionStorage.setItem('al_barr_checkout_error', 'Your payment via ' + payload.payment_method + ' failed. Please select an alternate payment method.');
                        window.location.href = '/checkout';
                    }
                } else {
                    alert(data.error || 'Verification failed.');
                    btnSuccess.disabled = false;
                    btnFail.disabled = false;
                    spinSuccess.style.display = 'none';
                    spinFail.style.display = 'none';
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred during simulation verification.');
                btnSuccess.disabled = false;
                btnFail.disabled = false;
                spinSuccess.style.display = 'none';
                spinFail.style.display = 'none';
            });
        }
    </script>
@endsection
