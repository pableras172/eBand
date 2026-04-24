const SAFARI_PROMPT_STORAGE_KEY = 'eband_safari_install_prompt_hidden';

/**
 * Safari does not expose the same install prompt flow as Chromium.
 * This helper identifies Safari while excluding Chromium-based browsers.
 */
function isSafariBrowser() {
    const userAgent = navigator.userAgent;
    const isSafariEngine = /Safari/i.test(userAgent);
    const isChromiumBased = /Chrome|CriOS|Edg|OPR|Brave|SamsungBrowser/i.test(userAgent);

    return isSafariEngine && !isChromiumBased;
}

/**
 * Detects if the app is already running in standalone mode.
 * - iOS uses navigator.standalone
 * - Modern browsers expose display-mode media query
 */
function isStandalonePwa() {
    const hasStandaloneMedia = window.matchMedia('(display-mode: standalone)').matches;
    const hasIosStandaloneFlag = window.navigator.standalone === true;

    return hasStandaloneMedia || hasIosStandaloneFlag;
}

/**
 * Safari on iOS and macOS has different install actions.
 * We tailor the instruction text so users can follow the right path.
 */
function getSafariInstallInstruction() {
    const userAgent = navigator.userAgent;
    const isIos = /iPhone|iPad|iPod/i.test(userAgent);

    if (isIos) {
        return 'En Safari: Compartir -> Anadir a pantalla de inicio.';
    }

    return 'En Safari (Mac): Archivo -> Anadir al Dock.';
}

/**
 * Renders a dismissible guide banner for Safari users.
 * This is only shown when install is relevant and not yet dismissed.
 */
function showSafariInstallBanner() {
    if (document.getElementById('pwa-safari-install-banner')) {
        return;
    }

    const hiddenByUser = localStorage.getItem(SAFARI_PROMPT_STORAGE_KEY) === '1';
    if (hiddenByUser) {
        return;
    }

    const wrapper = document.createElement('div');
    wrapper.id = 'pwa-safari-install-banner';
    wrapper.className = 'fixed bottom-5 left-5 z-[120]';
    wrapper.innerHTML = `
        <div class="max-w-xs rounded-2xl border border-amber-200 bg-amber-50/95 p-3 shadow-lg backdrop-blur-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-700">eBand PWA</p>
            <p class="mt-1 text-sm text-gray-700">${getSafariInstallInstruction()}</p>
            <div class="mt-3 flex gap-2">
                <button id="pwa-safari-install-ok" class="rounded-xl bg-amber-300 px-3 py-2 text-xs font-semibold text-gray-900 transition hover:bg-amber-200">Entendido</button>
                <button id="pwa-safari-install-hide" class="rounded-xl border border-amber-300 px-3 py-2 text-xs font-semibold text-amber-800 transition hover:bg-amber-100">No mostrar</button>
            </div>
        </div>
    `;

    document.body.appendChild(wrapper);

    const okButton = document.getElementById('pwa-safari-install-ok');
    const hideButton = document.getElementById('pwa-safari-install-hide');

    if (okButton) {
        okButton.addEventListener('click', () => {
            wrapper.remove();
        });
    }

    if (hideButton) {
        hideButton.addEventListener('click', () => {
            localStorage.setItem(SAFARI_PROMPT_STORAGE_KEY, '1');
            wrapper.remove();
        });
    }
}

/**
 * Public init function invoked from app.js.
 * We only show Safari-specific guidance when all conditions apply:
 * - Browser is Safari
 * - App is not already installed/standalone
 * - Connection is secure (or localhost)
 */
export function initSafariPwaSupport() {
    const isSecure = window.isSecureContext || location.hostname === 'localhost';

    if (!isSecure || !isSafariBrowser() || isStandalonePwa()) {
        return;
    }

    window.addEventListener('load', () => {
        showSafariInstallBanner();
    });
}
