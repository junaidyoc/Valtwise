/**
 * Service Worker for DealVault - Offline Caching
 * Version: 1.0.0
 */

const CACHE_NAME = 'dealvault-v1';
const STATIC_CACHE = 'dealvault-static-v1';
const DYNAMIC_CACHE = 'dealvault-dynamic-v1';

// Assets to cache immediately on install
const STATIC_ASSETS = [
    '/',
    '/css/app.css',
    '/offline.html',
    'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@600;700&display=swap'
];

// Cache strategies
const CACHE_STRATEGIES = {
    // Cache first for static assets
    cacheFirst: async (request) => {
        const cached = await caches.match(request);
        if (cached) return cached;

        try {
            const response = await fetch(request);
            if (response.ok) {
                const cache = await caches.open(STATIC_CACHE);
                cache.put(request, response.clone());
            }
            return response;
        } catch (error) {
            return caches.match('/offline.html');
        }
    },

    // Network first for dynamic content
    networkFirst: async (request) => {
        try {
            const response = await fetch(request);
            if (response.ok) {
                const cache = await caches.open(DYNAMIC_CACHE);
                cache.put(request, response.clone());
            }
            return response;
        } catch (error) {
            const cached = await caches.match(request);
            return cached || caches.match('/offline.html');
        }
    },

    // Stale while revalidate for images
    staleWhileRevalidate: async (request) => {
        const cache = await caches.open(DYNAMIC_CACHE);
        const cached = await cache.match(request);

        const fetchPromise = fetch(request).then(response => {
            if (response.ok) {
                cache.put(request, response.clone());
            }
            return response;
        }).catch(() => cached);

        return cached || fetchPromise;
    }
};

// Install event - cache static assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== STATIC_CACHE && key !== DYNAMIC_CACHE)
                    .map(key => caches.delete(key))
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - apply caching strategies
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') return;

    // Skip admin routes
    if (url.pathname.startsWith('/admin')) return;

    // Skip API requests
    if (url.pathname.startsWith('/api')) return;

    // CSS and JS files - cache first
    if (request.destination === 'style' || request.destination === 'script') {
        event.respondWith(CACHE_STRATEGIES.cacheFirst(request));
        return;
    }

    // Images - stale while revalidate
    if (request.destination === 'image') {
        event.respondWith(CACHE_STRATEGIES.staleWhileRevalidate(request));
        return;
    }

    // Fonts - cache first (long-lived)
    if (request.destination === 'font' || url.hostname === 'fonts.googleapis.com' || url.hostname === 'fonts.gstatic.com') {
        event.respondWith(CACHE_STRATEGIES.cacheFirst(request));
        return;
    }

    // HTML pages - network first
    if (request.destination === 'document' || request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(CACHE_STRATEGIES.networkFirst(request));
        return;
    }

    // Default - network first
    event.respondWith(CACHE_STRATEGIES.networkFirst(request));
});

// Background sync for analytics (optional)
self.addEventListener('sync', (event) => {
    if (event.tag === 'analytics-sync') {
        event.waitUntil(syncAnalytics());
    }
});

async function syncAnalytics() {
    // Placeholder for future analytics sync
    console.log('Syncing analytics...');
}
