const CACHE_PREFIX = 'bacadulu-offline-';
const CACHE_NAME = `${CACHE_PREFIX}v3`;

const OFFLINE_URL = '/offline.html';

/*
|--------------------------------------------------------------------------
| INSTALL
|--------------------------------------------------------------------------
|
| Kita hanya cache halaman offline.
| Tidak cache halaman website, admin, OTP, recovery, OAuth, dll.
|
*/

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                return cache.add(
                    new Request(OFFLINE_URL, {
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
| Bersihkan versi cache offline Baca Dulu yang lama.
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

                        return Promise.resolve();
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
| Service worker TIDAK menyimpan response website.
|
| Normal:
| Browser -> Laravel -> response normal
|
| Internet/server tidak dapat dijangkau:
| Browser -> offline.html
|
*/

self.addEventListener('fetch', (event) => {
    const request = event.request;

    /*
     * Jangan sentuh POST / PUT / PATCH / DELETE.
     */
    if (request.method !== 'GET') {
        return;
    }

    /*
     * Kita hanya menyediakan fallback untuk navigasi halaman.
     *
     * Jadi request gambar, CSS, JS, API, AJAX, dll
     * tidak diubah oleh service worker.
     */
    if (request.mode !== 'navigate') {
        return;
    }

    event.respondWith(
        fetch(request).catch(async () => {
            const cache = await caches.open(CACHE_NAME);

            const offlineResponse =
                await cache.match(OFFLINE_URL);

            if (offlineResponse) {
                return offlineResponse;
            }

            return new Response(
                'Koneksi internet terputus.',
                {
                    status: 503,
                    statusText: 'Service Unavailable',
                    headers: {
                        'Content-Type':
                            'text/plain; charset=utf-8',
                    },
                }
            );
        })
    );
});