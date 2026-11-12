/**
 * Inicializa el gesto pull-to-refresh para recargar la pagina en dispositivos tactiles
 * (especialmente util en WKWebView de iOS donde no viene activado por defecto).
 */
export function initPullToRefresh() {
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    if (!isTouchDevice || document.getElementById('eband-ptr-indicator')) {
        return;
    }

    const THRESHOLD = 75;
    const MAX_PULL = 110;

    let startY = 0;
    let startX = 0;
    let pulling = false;
    let readyToRefresh = false;

    const indicator = document.createElement('div');
    indicator.id = 'eband-ptr-indicator';
    indicator.setAttribute('aria-hidden', 'true');
    indicator.style.cssText = [
        'position: fixed',
        'left: 50%',
        'top: calc(env(safe-area-inset-top, 0px) + 12px)',
        'transform: translate(-50%, -80px)',
        'z-index: 9999',
        'display: flex',
        'align-items: center',
        'gap: 8px',
        'padding: 8px 14px',
        'border-radius: 9999px',
        'background: rgba(15, 23, 42, 0.88)',
        'color: #ffffff',
        'font-size: 12px',
        'font-weight: 600',
        'box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2)',
        'pointer-events: none',
        'opacity: 0',
        'transition: opacity 0.15s ease, transform 0.2s ease',
    ].join(';');

    indicator.innerHTML = `
        <svg id="eband-ptr-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.15s ease;">
            <path d="M21 12a9 9 0 1 1-2.64-6.36" />
            <polyline points="21 3 21 9 15 9" />
        </svg>
        <span id="eband-ptr-label">Desliza para actualizar</span>
    `;

    document.body.appendChild(indicator);

    const icon = document.getElementById('eband-ptr-icon');
    const label = document.getElementById('eband-ptr-label');

    function hasScrolledParent(target) {
        let el = target;
        while (el && el !== document.body && el !== document.documentElement) {
            if (el.nodeType === 1) {
                const style = window.getComputedStyle(el);
                const overflowY = style.overflowY;
                if ((overflowY === 'auto' || overflowY === 'scroll') && el.scrollTop > 0) {
                    return true;
                }
                if (el.matches('[role="dialog"], .fixed.inset-0, input, textarea, select, canvas')) {
                    return true;
                }
            }
            el = el.parentElement;
        }
        return false;
    }

    function resetIndicator() {
        indicator.style.transition = 'opacity 0.18s ease, transform 0.2s ease';
        indicator.style.opacity = '0';
        indicator.style.transform = 'translate(-50%, -80px)';
        pulling = false;
        readyToRefresh = false;
    }

    window.addEventListener('touchstart', (e) => {
        if (e.touches.length !== 1 || window.scrollY > 0 || hasScrolledParent(e.target)) {
            pulling = false;
            return;
        }

        startY = e.touches[0].clientY;
        startX = e.touches[0].clientX;
        pulling = true;
        readyToRefresh = false;
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
        if (!pulling || e.touches.length !== 1) {
            return;
        }

        if (window.scrollY > 0) {
            resetIndicator();
            return;
        }

        const currentY = e.touches[0].clientY;
        const currentX = e.touches[0].clientX;
        const deltaY = currentY - startY;
        const deltaX = currentX - startX;

        if (deltaY <= 0 || Math.abs(deltaX) > Math.abs(deltaY)) {
            if (deltaY <= 0) {
                resetIndicator();
            }
            return;
        }

        if (deltaY < 16) {
            return;
        }

        const offset = Math.min(deltaY * 0.55, MAX_PULL);
        const progress = Math.min(deltaY / THRESHOLD, 1);

        indicator.style.transition = 'none';
        indicator.style.opacity = String(Math.min(progress * 1.1, 1));
        indicator.style.transform = `translate(-50%, ${offset - 24}px)`;

        readyToRefresh = deltaY >= THRESHOLD;
        if (icon) {
            icon.style.transform = readyToRefresh ? 'rotate(180deg)' : `rotate(${Math.round(progress * 140)}deg)`;
        }
        if (label) {
            label.textContent = readyToRefresh ? 'Suelta para recargar' : 'Desliza para actualizar';
        }
    }, { passive: true });

    window.addEventListener('touchend', () => {
        if (!pulling) {
            return;
        }

        if (readyToRefresh) {
            indicator.style.transition = 'opacity 0.15s ease, transform 0.2s ease';
            indicator.style.opacity = '1';
            indicator.style.transform = 'translate(-50%, 16px)';
            if (label) {
                label.textContent = 'Actualizando...';
            }
            window.location.reload();
            return;
        }

        resetIndicator();
    }, { passive: true });

    window.addEventListener('touchcancel', resetIndicator, { passive: true });
}
