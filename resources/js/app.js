import './bootstrap';

let mobileUtilityStartY = 0;
let mobileUtilityCurrentY = 0;
let mobileUtilityDragging = false;
let deferredInstallPrompt = null;
let firebaseMessagingInitPromise = null;
let tokenPersistencePromise = null;

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function syncRegisterTokenField(token) {
    const hiddenInput = document.getElementById('mobile-token');

    if (hiddenInput && token) {
        hiddenInput.value = token;
    }
}

async function persistDeviceToken(token) {
    if (!token) {
        return false;
    }

    const csrfToken = getCsrfToken();

    if (!csrfToken) {
        return false;
    }

    if (tokenPersistencePromise) {
        return tokenPersistencePromise;
    }

    tokenPersistencePromise = fetch('/device-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            mobile_token: token,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                return false;
            }

            return true;
        })
        .catch(() => false)
        .finally(() => {
            tokenPersistencePromise = null;
        });

    return tokenPersistencePromise;
}

function storeDetectedDeviceToken(token) {
    if (!token || typeof token !== 'string') {
        return '';
    }

    const normalizedToken = token.trim();

    if (!normalizedToken) {
        return '';
    }

    window.HomeEaseMobileToken = normalizedToken;
    localStorage.setItem('homeease_mobile_token', normalizedToken);
    sessionStorage.setItem('homeease_mobile_token', normalizedToken);
    syncRegisterTokenField(normalizedToken);

    if (typeof window.setHomeEaseMobileToken === 'function') {
        window.setHomeEaseMobileToken(normalizedToken);
    }

    persistDeviceToken(normalizedToken);

    return normalizedToken;
}

async function initializeFirebaseMessaging({ forcePermissionPrompt = false } = {}) {
    if (firebaseMessagingInitPromise) {
        return firebaseMessagingInitPromise;
    }

    firebaseMessagingInitPromise = (async () => {
        const firebaseConfig = window.HomeEaseFirebaseConfig;
        const vapidKey = window.HomeEaseFirebaseVapidKey;

        if (!firebaseConfig || !vapidKey || !('Notification' in window) || !('serviceWorker' in navigator)) {
            return '';
        }

        const [{ initializeApp }, { getMessaging, getToken, isSupported, onMessage }] = await Promise.all([
            import(/* @vite-ignore */ 'https://www.gstatic.com/firebasejs/12.12.1/firebase-app.js'),
            import(/* @vite-ignore */ 'https://www.gstatic.com/firebasejs/12.12.1/firebase-messaging.js'),
        ]);

        if (!(await isSupported())) {
            return '';
        }

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        const serviceWorkerRegistration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

        if (forcePermissionPrompt && Notification.permission === 'default') {
            await Notification.requestPermission();
        }

        if (Notification.permission !== 'granted') {
            return '';
        }

        onMessage(messaging, (payload) => {
            const title = payload?.notification?.title || 'HomeEase';
            const body = payload?.notification?.body || 'You have a new notification.';

            if (document.visibilityState === 'visible' && Notification.permission === 'granted') {
                new Notification(title, {
                    body,
                    icon: '/icons/icon-192.png',
                    badge: '/icons/icon-192.png',
                });
            }
        });

        const token = await getToken(messaging, {
            vapidKey,
            serviceWorkerRegistration,
        });

        return storeDetectedDeviceToken(token);
    })().catch(() => '');

    return firebaseMessagingInitPromise;
}

window.HomeEaseRequestDeviceToken = async function(options = {}) {
    const token = await initializeFirebaseMessaging(options);

    if (!token) {
        firebaseMessagingInitPromise = null;
    }

    return token;
};

function setInstallButtonContent(label, meta) {
    const installButton = document.getElementById('mobileHeaderInstallButton');
    const labelElement = document.querySelector('.mobile-header-install-action-label');
    const textElement = labelElement?.querySelector('span:last-child');

    if (!installButton || !labelElement || !textElement) {
        return;
    }

    installButton.setAttribute('aria-label', label);
    textElement.textContent = label;
}

function getMobileUtilityElements() {
    return {
        overlay: document.getElementById('mobileUtilityOverlay'),
        sheet: document.getElementById('mobileUtilitySheet'),
    };
}

function openMobileUtilitySheet() {
    const { overlay, sheet } = getMobileUtilityElements();

    if (!overlay || !sheet) {
        return;
    }

    overlay.classList.add('show');
    sheet.classList.add('show');
    sheet.setAttribute('aria-hidden', 'false');
    sheet.style.transform = 'translateY(0)';
    document.body.style.overflow = 'hidden';
}

function closeMobileUtilitySheet() {
    const { overlay, sheet } = getMobileUtilityElements();

    if (!overlay || !sheet) {
        return;
    }

    overlay.classList.remove('show');
    sheet.classList.remove('show');
    sheet.setAttribute('aria-hidden', 'true');
    sheet.style.transform = '';
    document.body.style.overflow = '';
}

function handleMobileUtilityTouchStart(event) {
    const { sheet } = getMobileUtilityElements();

    if (!sheet || !sheet.classList.contains('show')) {
        return;
    }

    mobileUtilityStartY = event.touches[0].clientY;
    mobileUtilityCurrentY = mobileUtilityStartY;
    mobileUtilityDragging = true;
}

function handleMobileUtilityTouchMove(event) {
    const { sheet } = getMobileUtilityElements();

    if (!sheet || !mobileUtilityDragging) {
        return;
    }

    mobileUtilityCurrentY = event.touches[0].clientY;
    const deltaY = Math.max(0, mobileUtilityCurrentY - mobileUtilityStartY);

    if (deltaY > 0) {
        sheet.style.transform = `translateY(${deltaY}px)`;
    }
}

function handleMobileUtilityTouchEnd() {
    const { sheet } = getMobileUtilityElements();

    if (!sheet) {
        return;
    }

    const deltaY = Math.max(0, mobileUtilityCurrentY - mobileUtilityStartY);
    mobileUtilityDragging = false;

    if (deltaY > 90) {
        closeMobileUtilitySheet();
        return;
    }

    sheet.style.transform = 'translateY(0)';
}

function isStandaloneMode() {
    return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
}

function isIosDevice() {
    return /iphone|ipad|ipod/i.test(window.navigator.userAgent);
}

function updateInstallUi() {
    const installButton = document.getElementById('mobileHeaderInstallButton');
    const installHint = document.getElementById('mobileHeaderInstallHint');

    if (!installButton || !installHint) {
        return;
    }

    if (isStandaloneMode()) {
        installButton.disabled = true;
        installButton.classList.add('is-installed');
        setInstallButtonContent('Installed', 'Ready in your app list');
        installHint.textContent = 'HomeEase is already installed and should appear in your app list on this phone.';
        return;
    }

    installButton.classList.remove('is-installed');
    installButton.disabled = false;

    if (deferredInstallPrompt) {
        setInstallButtonContent('Download App', 'Tap to add on mobile');
        installHint.textContent = 'Tap this button to add HomeEase to your mobile app list.';
        return;
    }

    if (isIosDevice()) {
        setInstallButtonContent('Download App', 'Use Safari share menu');
        installHint.textContent = 'On iPhone, tap Safari Share and choose Add to Home Screen after opening the site.';
        return;
    }

    setInstallButtonContent('Download App', 'Use Chrome on Android');
    installHint.textContent = 'If install does not open, use Chrome on Android and make sure the site is running on HTTPS.';
}

async function handleInstallClick() {
    if (!deferredInstallPrompt) {
        updateInstallUi();
        return;
    }

    deferredInstallPrompt.prompt();
    await deferredInstallPrompt.userChoice;
    deferredInstallPrompt = null;
    updateInstallUi();
}

function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        return;
    }

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // Install prompt still falls back to browser behavior when registration fails.
        });
    });
}

window.openMobileUtilitySheet = openMobileUtilitySheet;
window.closeMobileUtilitySheet = closeMobileUtilitySheet;

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredInstallPrompt = event;
    updateInstallUi();
});

window.addEventListener('appinstalled', () => {
    deferredInstallPrompt = null;
    updateInstallUi();
});

document.addEventListener('DOMContentLoaded', () => {
    const { sheet } = getMobileUtilityElements();
    const installButton = document.getElementById('mobileHeaderInstallButton');

    if (sheet) {
        sheet.addEventListener('touchstart', handleMobileUtilityTouchStart, { passive: true });
        sheet.addEventListener('touchmove', handleMobileUtilityTouchMove, { passive: true });
        sheet.addEventListener('touchend', handleMobileUtilityTouchEnd);
    }

    if (installButton) {
        installButton.addEventListener('click', handleInstallClick);
    }

    registerServiceWorker();
    updateInstallUi();
    initializeFirebaseMessaging({ forcePermissionPrompt: false });
});
