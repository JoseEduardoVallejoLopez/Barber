document.addEventListener('DOMContentLoaded', () => {
    // Funcionalidad para la página de servicios.html
    if (window.location.pathname.endsWith('servicios.html')) {
        fetch('../Backend/servicios.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('servicios-data').innerHTML = data;
            })
            .catch(error => console.error('Error al cargar los servicios:', error));
    }

    // Funcionalidad para la página de reservas.html
    if (window.location.pathname.endsWith('reservas.html')) {
        const fechaInput = document.getElementById('fecha');
        const horaInput = document.getElementById('hora');
        const servicioSelect = document.getElementById('servicio');
        const reservaForm = document.getElementById('reservaForm');
        let reservasExistentes = {};

        function obtenerParametroURL(nombre) {
            const params = new URLSearchParams(window.location.search);
            return params.get(nombre);
        }

        function cargarDatos() {
            fetch('../Backend/reservas.php')
                .then(response => response.json())
                .then(data => {
                    const { servicios, reservas } = data;
                    
                    servicioSelect.innerHTML = '';
                    if (servicios.length > 0) {
                        servicios.forEach(s => {
                            const option = document.createElement('option');
                            option.value = s.nombre;
                            option.textContent = s.nombre;
                            servicioSelect.appendChild(option);
                        });
                    } else {
                        servicioSelect.innerHTML = '<option value="">No hay servicios disponibles</option>';
                    }

                    const servicioURL = obtenerParametroURL('servicio');
                    if (servicioURL) {
                        servicioSelect.value = servicioURL;
                    }

                    reservasExistentes = reservas.reduce((acc, reserva) => {
                        (acc[reserva.fecha] = acc[reserva.fecha] || []).push(reserva.hora);
                        return acc;
                    }, {});

                    const hoy = new Date();
                    hoy.setDate(hoy.getDate() + 1);
                    const manana = hoy.toISOString().split('T')[0];
                    fechaInput.min = manana;

                    actualizarHoras();
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    Swal.fire('Error', 'No se pudieron cargar los datos del sistema de reservas.', 'error');
                });
        }

        function actualizarHoras() {
            const fechaSeleccionada = fechaInput.value;
            const horasOcupadas = reservasExistentes[fechaSeleccionada] || [];
            
            horaInput.min = "09:00";
            horaInput.max = "19:00";
            
            horaInput.addEventListener('input', () => {
                const horaSeleccionada = horaInput.value;
                if (horasOcupadas.includes(horaSeleccionada)) {
                    Swal.fire('¡Atención!', 'Esa hora ya está reservada. Por favor, elige otra.', 'warning');
                    horaInput.value = '';
                }
            });
        }
        
        reservaForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(reservaForm);

            fetch('../Backend/reservas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('¡Éxito!', data.message, 'success');
                    reservaForm.reset();
                    cargarDatos();
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error de comunicación:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar tu reserva. Inténtalo de nuevo.', 'error');
            });
        });

        cargarDatos();
    }
});