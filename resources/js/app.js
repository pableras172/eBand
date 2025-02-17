import './bootstrap';

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
   
    const table = document.getElementById('instrumentTable');

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
            console.log('Click3');
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



