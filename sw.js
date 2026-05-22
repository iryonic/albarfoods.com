/* Service Worker — Network-First for dev, Cache fallback for offline */

const CACHE_NAME = 'albarr-cache-v6';
const OFFLINE_URL = './offline.php';

// Minimal shell to pre-cache for offline fallback only
const PRECACHE = [
    OFFLINE_URL,
    './manifest.json',
    './assets/img/logo.png'
];

// ── Install: cache offline shell ──
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(PRECACHE))
            .then(() => self.skipWaiting())
    );
});

// ── Activate: wipe ALL old caches ──
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((names) => {
            return Promise.all(
                names
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => {
                        console.log('[SW] Deleting old cache:', name);
                        return caches.delete(name);
                    })
            );
        }).then(() => self.clients.claim())
    );
});

// ── Fetch: Network-First for pages/CSS/JS, Cache-First for images ──
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Only handle same-origin requests
    if (url.origin !== self.location.origin) return;

    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    const isImage = /\.(png|jpe?g|gif|webp|svg|ico)(\?|$)/i.test(url.pathname);
    const isPage  = event.request.mode === 'navigate';

    if (isImage) {
        // ── Images: Cache-First (fast loads, rarely change) ──
        event.respondWith(
            caches.match(event.request).then((cached) => {
                if (cached) return cached;
                return fetch(event.request).then((response) => {
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then((c) => c.put(event.request, clone));
                    }
                    return response;
                }).catch(() => new Response('', { status: 404 }));
            })
        );
    } else {
        // ── Everything else (HTML, CSS, JS): Network-First ──
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    // Cache a fresh copy for offline use
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then((c) => c.put(event.request, clone));
                    }
                    return response;
                })
                .catch(() => {
                    // Offline — try cache, or show offline page for navigation
                    return caches.match(event.request).then((cached) => {
                        if (cached) return cached;
                        if (isPage) return caches.match(OFFLINE_URL);
                        return new Response('', { status: 503 });
                    });
                })
        );
    }
});
