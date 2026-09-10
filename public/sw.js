const CACHE_PREFIX = 'bacadulu-offline-';
const CACHE_VERSION = 'v4-20260909';
const CACHE_NAME = `${CACHE_PREFIX}${CACHE_VERSION}`;

const OFFLINE_URL = '/offline.html';
const OFFLINE_CACHE_KEY = `${OFFLINE_URL}?v=${CACHE_VERSION}`;

/*
|--------------------------------------------------------------------------
| INSTALL
|--------------------------------------------------------------------------
|
| Cache hanya halaman fallback offline. Query version pada cache key
| sengaja diubah setiap kali desain offline berubah supaya perangkat lama
| tidak terus memakai offline.html dari cache versi sebelumnya.
|
*/
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(
                new Request(OFFLINE_CACHE_KEY, {
                    cache: 'reload',
                })
            );
        })
    );

    self.skipWaiting();
});

/*
|--------------------------------------------------------------------------
| ACTIVATE
|--------------------------------------------------------------------------
|
| Hapus seluruh cache offline Baca Dulu versi lama lalu langsung ambil
| alih halaman yang masih dikontrol service worker lama.
|
*/
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (
                            cacheName.startsWith(CACHE_PREFIX) &&
                            cacheName !== CACHE_NAME
                        ) {
                            return caches.delete(cacheName);
                        }

                        return Promise.resolve(false);
                    })
                );
            })
            .then(() => self.clients.claim())
    );
});

/*
|--------------------------------------------------------------------------
| FETCH
|--------------------------------------------------------------------------
|
| Service worker tidak menyimpan halaman website, API, gambar, CSS, JS,
| admin, OTP, recovery, maupun OAuth. Hanya navigasi GET yang gagal karena
| jaringan/server tidak dapat dijangkau yang mendapat fallback offline.
|
*/
self.addEventListener('fetch', (event) => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    if (request.mode !== 'navigate') {
        return;
    }

    event.respondWith(
        fetch(request).catch(async () => {
            const cache = await caches.open(CACHE_NAME);
            const offlineResponse = await cache.match(OFFLINE_CACHE_KEY);

            if (offlineResponse) {
                return offlineResponse;
            }

            return new Response('Koneksi internet terputus.', {
                status: 503,
                statusText: 'Service Unavailable',
                headers: {
                    'Content-Type': 'text/plain; charset=utf-8',
                    'Cache-Control': 'no-store',
                },
            });
        })
    );
});
