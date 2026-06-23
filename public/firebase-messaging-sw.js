importScripts('https://www.gstatic.com/firebasejs/12.12.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/12.12.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: 'AIzaSyAhYidkUMumBt89hXLGSYyWyjN-Lf1qOx4',
    authDomain: 'testingappcodie.firebaseapp.com',
    projectId: 'testingappcodie',
    storageBucket: 'testingappcodie.firebasestorage.app',
    messagingSenderId: '957303316946',
    appId: '1:957303316946:web:d1a2f11a915a22a6f8a80b',
    measurementId: 'G-1B1C35DQC2',
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const notificationTitle = payload?.notification?.title || 'HomeEase';
    const notificationOptions = {
        body: payload?.notification?.body || 'You have a new notification.',
        icon: '/icons/icon-192.png',
        badge: '/icons/icon-192.png',
        data: payload?.data || {},
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const targetUrl = event.notification?.data?.click_action || event.notification?.data?.url || '/home';

    event.waitUntil(clients.openWindow(targetUrl));
});
