console.log('Hello from sw.js');

importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.1.0/workbox-sw.js');

if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}