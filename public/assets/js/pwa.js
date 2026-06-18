// Register Service Worker (with force-update on new version)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('./sw.js')
            .then((registration) => {
                console.log('ServiceWorker registered, scope:', registration.scope);

                // If a new SW is waiting, activate it immediately
                if (registration.waiting) {
                    registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                }

                // Detect when a new SW is installed and force-activate
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    if (newWorker) {
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'activated') {
                                console.log('[PWA] New service worker activated — refreshing.');
                                window.location.reload();
                            }
                        });
                    }
                });
            })
            .catch((error) => {
                console.error('ServiceWorker registration failed:', error);
            });

        // If controller changes (new SW took over), reload for fresh assets
        let refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
        });
    });
}

// Custom PWA Installation Prompt Logic
let deferredPrompt;
const dismissalDuration = 7 * 24 * 60 * 60 * 1000; // 7 days in milliseconds

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;

    // Check if user dismissed prompt recently
    const dismissedTime = localStorage.getItem('albarr_pwa_dismissed_time');
    const now = Date.now();
    if (dismissedTime && (now - parseInt(dismissedTime, 10) < dismissalDuration)) {
        console.log('PWA installation prompt was dismissed recently. Suppressing.');
        return;
    }

    // Show the custom prompt banner
    showInstallPrompt();
});

function showInstallPrompt() {
    // Check if it already exists
    if (document.getElementById('pwa-install-prompt')) return;

    // Create the banner element
    const promptEl = document.createElement('div');
    promptEl.id = 'pwa-install-prompt';
    promptEl.className = 'pwa-install-prompt';

    promptEl.innerHTML = `
        <div class="pwa-prompt-icon-box">
            <img class="pwa-prompt-icon" src="assets/img/logo.png" alt="Al barr Logo">
        </div>
        <div class="pwa-prompt-info">
            <h4 class="pwa-prompt-title">Al barr (Khalis Wa Shifaf)</h4>
            <p class="pwa-prompt-desc">Add to Home Screen for fast offline ordering and purity updates.</p>
        </div>
        <div class="pwa-prompt-actions">
            <button class="pwa-btn-install" id="pwa-btn-install">Install</button>
            <button class="pwa-btn-close" id="pwa-btn-close" aria-label="Close prompt">×</button>
        </div>
    `;

    document.body.appendChild(promptEl);

    // Fade in/slide in micro-animation
    setTimeout(() => {
        promptEl.classList.add('visible');
    }, 100);

    // Install button click handler
    document.getElementById('pwa-btn-install').addEventListener('click', () => {
        if (!deferredPrompt) return;

        // Hide our custom banner
        hideInstallPrompt();

        // Show the browser install prompt
        deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the Al barr install prompt');
            } else {
                console.log('User dismissed the Al barr install prompt');
                // Store dismissal if they rejected it to respect their preference
                localStorage.setItem('albarr_pwa_dismissed_time', Date.now().toString());
            }
            deferredPrompt = null;
        });
    });

    // Close button click handler
    document.getElementById('pwa-btn-close').addEventListener('click', () => {
        hideInstallPrompt();
        // Dismiss for 7 days
        localStorage.setItem('albarr_pwa_dismissed_time', Date.now().toString());
    });
}

function hideInstallPrompt() {
    const promptEl = document.getElementById('pwa-install-prompt');
    if (promptEl) {
        promptEl.classList.remove('visible');
        // Wait for animation to finish before removing from DOM
        setTimeout(() => {
            promptEl.remove();
        }, 300);
    }
}

// Listen for successful app installation
window.addEventListener('appinstalled', (evt) => {
    console.log('Al barr E-Commerce App installed successfully!');
    hideInstallPrompt();
    deferredPrompt = null;
});
