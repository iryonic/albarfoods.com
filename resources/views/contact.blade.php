@extends('layouts.app')

@section('title', 'Contact Us - Al Barr | Kashmiri Organic Staples Support')

@section('styles')
<style>
    .contact-page-wrap {
        padding: var(--spacing-xxl) 0;
        background-color: var(--color-cream);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.3fr;
        gap: var(--spacing-xxl);
        align-items: start;
    }

    /* Left Side Contact Info */
    .contact-info-column {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
        text-align: left;
    }

    .contact-heading {
        font-family: var(--font-secondary);
        font-size: 2.5rem;
        color: var(--color-blue-dark);
        font-weight: 700;
        margin-bottom: var(--spacing-xs);
    }

    .contact-sub {
        color: var(--color-text-secondary);
        font-size: 1.05rem;
        margin-bottom: var(--spacing-md);
        max-width: 450px;
    }

    .info-card-premium {
        background: var(--color-cream-card);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-md);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        display: flex;
        gap: var(--spacing-md);
        align-items: flex-start;
        transition: var(--transition-fast);
    }

    .info-card-premium:hover {
        border-color: var(--color-card-border-gold);
        transform: translateY(-2px);
    }

    .info-card-icon {
        font-size: 1.8rem;
        background: var(--color-blue-light);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-xs);
        color: var(--color-blue-dark);
        flex-shrink: 0;
    }

    .info-card-title {
        font-family: var(--font-secondary);
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-blue-dark);
        margin-bottom: 4px;
    }

    .info-card-value {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .info-card-link {
        color: var(--color-blue-medium);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 6px;
        text-decoration: none;
    }

    .info-card-link:hover {
        color: var(--color-blue-dark);
        text-decoration: underline;
    }

    /* Right Side Form */
    .contact-form-card {
        background: var(--color-cream-card);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-md);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        text-align: left;
    }

    .form-title {
        font-family: var(--font-secondary);
        font-size: 1.6rem;
        color: var(--color-blue-dark);
        font-weight: 600;
        margin-bottom: var(--spacing-xs);
    }

    .form-desc {
        color: var(--color-text-secondary);
        font-size: 0.9rem;
        margin-bottom: var(--spacing-lg);
    }

    .contact-form {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .input-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--color-text-secondary);
    }

    .contact-input,
    .contact-textarea {
        width: 100%;
        padding: 12px 16px;
        background-color: var(--color-cream);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-xs);
        font-size: 0.95rem;
        color: var(--color-text-primary);
        transition: var(--transition-fast);
    }

    .contact-input:focus,
    .contact-textarea:focus {
        border-color: var(--color-blue-medium);
        background-color: #fff;
        box-shadow: 0 0 0 3px var(--color-blue-light);
    }

    .contact-textarea {
        resize: vertical;
        height: 120px;
    }

    .submit-btn-premium {
        background: var(--color-gold-gradient);
        color: var(--color-text-primary);
        border: none;
        padding: 14px 28px;
        font-weight: 700;
        font-family: var(--font-secondary);
        border-radius: var(--radius-xs);
        cursor: pointer;
        transition: var(--transition-normal);
        box-shadow: var(--shadow-gold);
        text-align: center;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: var(--spacing-xs);
        font-size: 1rem;
    }

    .submit-btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(255, 179, 0, 0.3);
    }

    .submit-btn-premium:disabled {
        background: var(--color-text-muted);
        color: #fff;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    /* Mock Map */
    .mock-map-wrap {
        margin-top: var(--spacing-xxl);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-sm);
        height: 300px;
        background-color: var(--color-cream-dark);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .mock-map-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.15;
        background-image: radial-gradient(var(--color-blue-dark) 1px, transparent 1px);
        background-size: 20px 20px;
    }

    .mock-map-content {
        z-index: 2;
        padding: var(--spacing-lg);
    }

    @media (max-width: 991px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<main class="contact-page-wrap">
    <div class="container">
        
        <div class="contact-grid">
            
            <!-- Left: contact info -->
            <div class="contact-info-column">
                <div>
                    <h1 class="contact-heading">Get in Touch</h1>
                    <p class="contact-sub">Have a question about our sourcing practices, bulk order discounts, or direct bank transfer confirmation? We are here to help!</p>
                </div>

                <!-- Card 1: Phone -->
                <div class="info-card-premium">
                    <div class="info-card-icon">📞</div>
                    <div>
                        <h3 class="info-card-title">Phone & WhatsApp Support</h3>
                        <div class="info-card-value">
                            Call / Message: <strong>{{ $settings['phone_number'] ?? '+91-9419000000' }}</strong><br>
                            Support Hours: Monday to Saturday (9:00 AM - 7:00 PM)
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['phone_number'] ?? '919419000000') }}?text=Hello%20Al%20barr%20Team" target="_blank" class="info-card-link">
                            Chat on WhatsApp &rarr;
                        </a>
                    </div>
                </div>

                <!-- Card 2: Email -->
                <div class="info-card-premium">
                    <div class="info-card-icon">✉️</div>
                    <div>
                        <h3 class="info-card-title">Email Support</h3>
                        <div class="info-card-value">
                            General Queries: <strong>{{ $settings['email_address'] ?? 'support@albarr.com' }}</strong><br>
                            Wholesale & Bulk: <strong>{{ $settings['wholesale_email'] ?? 'trade@albarr.com' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Address -->
                <div class="info-card-premium">
                    <div class="info-card-icon">📍</div>
                    <div>
                        <h3 class="info-card-title">Head Office Location</h3>
                        <div class="info-card-value">
                            <strong>Al Barr (Khalis Wa Shifaf)</strong><br>
                            SMC Complex, Zakura,<br>
                            Near J&K Bank, Srinagar,<br>
                            Jammu & Kashmir – 190006
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: feedback form -->
            <div class="contact-form-card">
                <h2 class="form-title">Send Us a Message</h2>
                <p class="form-desc">Fill out the form below, and our support coordinators will get back to you within 24 hours.</p>
                
                <form class="contact-form" id="contact-feedback-form" onsubmit="handleContactSubmit(event)">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="contact-name" class="input-label">Full Name *</label>
                            <input type="text" id="contact-name" class="contact-input" placeholder="e.g. Irfan Manzoor" required>
                        </div>
                        <div class="input-group">
                            <label for="contact-email" class="input-label">Email Address *</label>
                            <input type="email" id="contact-email" class="contact-input" placeholder="e.g. irfan@example.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label for="contact-phone" class="input-label">Phone Number *</label>
                            <input type="tel" id="contact-phone" class="contact-input" placeholder="e.g. 9419012345" required>
                        </div>
                        <div class="input-group">
                            <label for="contact-subject" class="input-label">Subject *</label>
                            <input type="text" id="contact-subject" class="contact-input" placeholder="e.g. Bulk Almond Order" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="contact-message" class="input-label">Message *</label>
                        <textarea id="contact-message" class="contact-textarea" placeholder="How can we help you today?" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn-premium" id="contact-submit-btn">
                        <span>Send Message</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </form>
            </div>

        </div>

        <!-- Mock Map Graphic -->
        <div class="mock-map-wrap">
            <div class="mock-map-bg"></div>
            <div class="mock-map-content">
                <span style="font-size: 2.2rem;">🏔️</span>
                <h3 style="color: var(--color-blue-dark); font-family: var(--font-secondary); margin-bottom: 6px;">Al Barr Srinagar Hub</h3>
                <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin-bottom: var(--spacing-sm);">SMC Complex, Zakura, Srinagar, J&K – 190006</p>
                <span style="font-size: 0.8rem; background: var(--color-blue-light); color: var(--color-blue-dark); font-weight: 700; padding: 4px 10px; border-radius: 20px;">✓ Main Harvest Depot & Distribution Center</span>
            </div>
        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
    function handleContactSubmit(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('contact-submit-btn');
        submitBtn.disabled = true;
        submitBtn.querySelector('span').innerText = 'Sending...';

        const name = document.getElementById('contact-name').value.trim();
        const email = document.getElementById('contact-email').value.trim();
        const phone = document.getElementById('contact-phone').value.trim();
        const subject = document.getElementById('contact-subject').value.trim();
        const message = document.getElementById('contact-message').value.trim();

        fetch('/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone,
                subject: subject,
                message: message
            })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 200) {
                if (typeof AlBarrCart !== 'undefined' && AlBarrCart.showToast) {
                    AlBarrCart.showToast(body.success || "Message sent successfully!");
                } else {
                    alert(body.success || "Message sent successfully!");
                }
                document.getElementById('contact-feedback-form').reset();
            } else {
                let errMsg = '';
                if (body.errors) {
                    errMsg = Object.values(body.errors).flat().join(' ');
                } else {
                    errMsg = body.error || 'Failed to send message.';
                }
                alert(errMsg);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.querySelector('span').innerText = 'Send Message';
        });
    }
</script>
@endsection
