import './bootstrap';
import { initSafariPwaSupport } from './pwa-safari';
import './driver-init';

// Clave persistente para recordar si el usuario oculto el aviso de instalacion PWA.
const INSTALL_PROMPT_STORAGE_KEY = 'eband_install_prompt_hidden';

// Evento nativo capturado (beforeinstallprompt) para lanzarlo desde nuestro boton personalizado.
let deferredInstallPrompt = null;

// Crea un banner flotante para instalar la app cuando el navegador lo permita.
function createInstallPromptButton() {
    if (document.getElementById('pwa-install-button')) {
        return;
    }

    const hiddenByUser = localStorage.getItem(INSTALL_PROMPT_STORAGE_KEY) === '1';
    if (hiddenByUser) {
        return;
    }

    const wrapper = document.createElement('div');
    wrapper.id = 'pwa-install-button';
    wrapper.className = 'fixed bottom-5 right-5 z-[120]';
    wrapper.innerHTML = `
        <div class="rounded-2xl border border-cyan-200 bg-white/95 p-3 shadow-lg backdrop-blur-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">eBand App</p>
            <p class="mt-1 text-sm text-gray-700">Instala la app para acceso rapido.</p>
            <div class="mt-3 flex gap-2">
                <button id="pwa-install-action" class="rounded-xl bg-cyan-500 px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-cyan-400">Instalar</button>
                <button id="pwa-install-dismiss" class="rounded-xl border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-600 transition hover:bg-gray-100">Ahora no</button>
            </div>
        </div>
    `;

    document.body.appendChild(wrapper);

    const installAction = document.getElementById('pwa-install-action');
    const dismissAction = document.getElementById('pwa-install-dismiss');

    if (installAction) {
        installAction.addEventListener('click', async () => {
            if (!deferredInstallPrompt) {
                return;
            }

            deferredInstallPrompt.prompt();
            await deferredInstallPrompt.userChoice;
            deferredInstallPrompt = null;
            wrapper.remove();
        });
    }

    if (dismissAction) {
        dismissAction.addEventListener('click', () => {
            localStorage.setItem(INSTALL_PROMPT_STORAGE_KEY, '1');
            wrapper.remove();
        });
    }
}

function registerServiceWorker() {
    // Si el navegador no soporta service workers, omitimos el registro sin romper la app.
    if (!('serviceWorker' in navigator)) {
        return;
    }

    // Registramos el SW al terminar de cargar para no penalizar el arranque inicial.
    window.addEventListener('load', async () => {
        try {
            await navigator.serviceWorker.register('/sw.js', { scope: '/' });
        } catch (error) {
            console.error('Service worker registration failed:', error);
        }
    });
}

window.addEventListener('beforeinstallprompt', (event) => {
    const hiddenByUser = localStorage.getItem(INSTALL_PROMPT_STORAGE_KEY) === '1';

    // Si el usuario oculto nuestro banner, dejamos que el navegador gestione su prompt nativo.
    if (hiddenByUser) {
        return;
    }

    // Bloqueamos el prompt automatico para poder mostrar primero nuestro CTA personalizado.
    event.preventDefault();
    deferredInstallPrompt = event;
    createInstallPromptButton();
});

// Cuando la instalacion finaliza, limpiamos estado y evitamos volver a mostrar el banner.
window.addEventListener('appinstalled', () => {
    deferredInstallPrompt = null;
    localStorage.setItem(INSTALL_PROMPT_STORAGE_KEY, '1');
    const installPrompt = document.getElementById('pwa-install-button');
    if (installPrompt) {
        installPrompt.remove();
    }
});

registerServiceWorker();
// Safari no soporta beforeinstallprompt como Chromium, por eso iniciamos una guia especifica.
initSafariPwaSupport();

// Helper global para Alpine: gestiona tema oscuro y lo persiste en localStorage.
window.themeSwitcher = function () {
    return {
        switchOn: JSON.parse(localStorage.getItem('isDark')) || false,
        switchTheme() {
            if (this.switchOn) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
            localStorage.setItem('isDark', this.switchOn)
        }
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // Este bloque solo aplica en pantallas que incluyan la tabla de instrumentos.
    const table = document.getElementById('instrumentTable');

    if (!table) return; // Si no existe el elemento, salir

    // Mover fila hacia arriba
    table.addEventListener('click', function (e) {
       
        if (e.target.closest('.move-up')) {
           
           const row = e.target.closest('tr');
            const prevRow = row.previousElementSibling;
            if (prevRow) {
                row.parentNode.insertBefore(row, prevRow);
                actualizarOrdenes();
            }
        }

        // Mover fila hacia abajo
        if (e.target.closest('.move-down')) {
            const row = e.target.closest('tr');
            const nextRow = row.nextElementSibling;
            if (nextRow) {
                row.parentNode.insertBefore(nextRow, row);
                actualizarOrdenes();
            }
        }
    });

    // Actualizar la numeración después de cada movimiento
    function actualizarOrdenes() {
        const rows = document.querySelectorAll('#instrumentTable .instrument-row');
        let ordenActualizado = [];

        // Recalculamos el orden visible y construimos el payload para guardar en backend.
        rows.forEach((row, index) => {
            const ordenSpan = row.querySelector('.orden');
            ordenSpan.textContent = index + 1; // Reordenar visualmente
            ordenActualizado.push({
                id: row.dataset.id,
                orden: index + 1
            });
        });

        // Enviar la nueva secuencia al servidor
        enviarOrdenAlServidor(ordenActualizado);
    }

    // Enviar datos actualizados al servidor
    function enviarOrdenAlServidor(ordenes) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/update-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ ordenes })
        })
            .then(response => response.json())
            .then(data => {
                showToast(data); 
            })
            .catch(error => {
                console.error('Error al actualizar el orden:', error);
            });
    }
});



