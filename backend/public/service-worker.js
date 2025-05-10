self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open("my-kirei-cache").then((cache) => {
            return cache.addAll([
                "/",
                "/manifest.json",
                "/icons/favicon.ico",
                "/icons/android-chrome-192x192.png",
                "/icons/android-chrome-512x512.png",
            ]);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

self.addEventListener("activate", (event) => {
    console.log("Service Worker activated.");
});
