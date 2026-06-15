import Driver from 'driver.js';
import 'driver.js/dist/driver.min.css';

window.startDriverTour = function (steps = []) {
    const driver = new Driver({
        doneBtnText: 'Listo',
        closeBtnText: 'Cerrar',
        nextBtnText: 'Siguiente',
        prevBtnText: 'Anterior',
        animate: true,
        opacity: 0.5,
    });

    if (!Array.isArray(steps)) {
        try {
            steps = JSON.parse(steps);
        } catch (e) {
            steps = [];
        }
    }

    driver.defineSteps(steps);
    driver.start();
};

// Escuchar botón global con data-driver-steps para lanzar guías desde el DOM
document.addEventListener('click', function (e) {
    const el = e.target.closest('[data-driver-start]');
    if (!el) return;

    const stepsSelector = el.getAttribute('data-driver-steps-selector');
    let steps = [];

    if (stepsSelector) {
        const node = document.querySelector(stepsSelector);
        if (node) {
            try { steps = JSON.parse(node.textContent); } catch (err) { steps = []; }
        }
    } else if (el.hasAttribute('data-driver-steps')) {
        try { steps = JSON.parse(el.getAttribute('data-driver-steps')); } catch (err) { steps = []; }
    }

    window.startDriverTour(steps);
});
