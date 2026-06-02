const CACHE_NAME = 'mtla-hub-v1';
const assets = [
  '/',
  'index.php',
  'css/style.css', // သင့် CSS ဖိုင်လမ်းကြောင်း
  'js/script.js'   // သင့် JS ဖိုင်လမ်းကြောင်း
];

// Install Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(assets);
    })
  );
});

// Fetch events
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});