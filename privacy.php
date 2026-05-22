<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Read Al Barr's privacy policy. Learn how we safeguard your shipping addresses and transaction details.">
    <title>Privacy Policy - Al Barr | Secure Organic Ordering</title>
    
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0B192C">
    
    <link rel="stylesheet" href="assets/css/variables.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?php echo time(); ?>">

    <style>
        .terms-page-wrap {
            padding: var(--spacing-xxl) 0;
            background-color: var(--color-cream);
        }

        .terms-content-card {
            background: var(--color-cream-card);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-md);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-sm);
            max-width: 900px;
            margin: 0 auto;
        }

        .terms-title {
            font-family: var(--font-secondary);
            font-size: 2.5rem;
            color: var(--color-blue-dark);
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }

        .terms-update-lbl {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            margin-bottom: var(--spacing-lg);
            border-bottom: 1px solid var(--color-border);
            padding-bottom: var(--spacing-md);
        }

        .terms-section {
            margin-bottom: var(--spacing-xl);
        }

        .terms-section-title {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            color: var(--color-blue-dark);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .terms-text {
            color: var(--color-text-secondary);
            font-size: 1rem;
            margin-bottom: var(--spacing-sm);
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <main class="terms-page-wrap">
        <div class="container">
            
            <div class="terms-content-card">
                <h1 class="terms-title">Privacy Policy</h1>
                <div class="terms-update-lbl">Last updated: May 22, 2026</div>

                <div class="terms-section">
                    <p class="terms-text">
                        At Al Barr (albarr.com), we highly value your trust and are fully committed to protecting your personal information. This Privacy Policy details how we collect, store, safeguard, and use your data when you browse our site, place orders, or contact our customer support team.
                    </p>
                </div>

                <!-- Sec 1 -->
                <div class="terms-section">
                    <h2 class="terms-section-title">1. Information We Collect</h2>
                    <p class="terms-text">
                        We collect individual data only to fulfill your orders and improve your shopping experience. This includes:
                    </p>
                    <p class="terms-text">
                        <strong>Order Information:</strong> Full name, telephone number, secondary contact number, detailed delivery address, Landmark, city, and pincode.
                    </p>
                    <p class="terms-text">
                        <strong>Transaction Records:</strong> Mock transaction flags or references for Direct Bank Transfer receipts when you submit them for validation.
                    </p>
                    <p class="terms-text">
                        <strong>Browser Storage:</strong> LocalStorage is used to maintain your shopping cart items across sessions. We do not store sensitive payment credentials or debit/credit card pin numbers on our databases.
                    </p>
                </div>

                <!-- Sec 2 -->
                <div class="terms-section">
                    <h2 class="terms-section-title">2. How We Use Your Data</h2>
                    <p class="terms-text">
                        Your information is utilized solely for:
                    </p>
                    <p class="terms-text">
                        - Processing and dispatching orders from our Srinagar hub.<br>
                        - Sending SMS/WhatsApp delivery updates and coordinating drop-offs.<br>
                        - Resolving customer support inquiries.<br>
                        - Fulfilling statutory FSSAI and tax logging parameters.
                    </p>
                </div>

                <!-- Sec 3 -->
                <div class="terms-section">
                    <h2 class="terms-section-title">3. Data Sharing Policies</h2>
                    <p class="terms-text">
                        Al Barr operates under a strict zero-spam guarantee. We do not sell, rent, or trade your personal information with third-party advertising companies. 
                    </p>
                    <p class="terms-text">
                        We only share delivery details (shipping name, address, phone number) with verified local express couriers (e.g. J&K Post, Delhivery, BlueDart) to execute order logistics.
                    </p>
                </div>

                <!-- Sec 4 -->
                <div class="terms-section">
                    <h2 class="terms-section-title">4. Data Security Protocols</h2>
                    <p class="terms-text">
                        All transaction checkpoints and page queries operate under secure Secure Sockets Layer (SSL) certificates, encrypting client-server data exchanges. For payment security, Direct Bank Transfers are processed securely outside our platform via your bank's official portal.
                    </p>
                </div>

                <!-- Sec 5 -->
                <div class="terms-section">
                    <h2 class="terms-section-title">5. Your Consent</h2>
                    <p class="terms-text">
                        By placing orders or registering queries, you consent to our privacy terms. For data deletion inquiries, contact us at <strong>privacy@albarr.com</strong>.
                    </p>
                </div>

            </div>

        </div>
    </main>

    <!-- Side Cart, Quick View, and Toasters -->
    <?php include 'includes/sidebar-cart.php'; ?>
    <?php include 'includes/quick-view.php'; ?>
    <div class="toast-container" id="toast-container"></div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
