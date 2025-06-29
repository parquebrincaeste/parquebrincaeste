@extends('layouts.app') <!-- Asegúrate de tener un layout base -->

<style>
/* Estilos generales */
body {
    background-color: #f0f4f8; /* Fondo claro */
    font-family: 'Arial', sans-serif; /* Fuente moderna */
}

/* Títulos */
h1 {
    font-size: 2.5rem; /* Tamaño grande para el título principal */
    font-weight: bold;
}

/* Estilos de tarjetas */
.card {
    border-radius: 10px; /* Bordes redondeados */
    transition: transform 0.3s; /* Transición suave al pasar el ratón */
}

.card:hover {
    transform: scale(1.05); /* Efecto de aumento al pasar el ratón */
}

/* Estilos de fondo degradante */
.bg-gradient-success {
    background: linear-gradient(90deg, #28a745, #85e0a0); /* Degradado verde */
}

.bg-gradient-primary {
    background: linear-gradient(90deg, #007bff, #66b3ff); /* Degradado azul */
}

.bg-gradient-warning {
    background: linear-gradient(90deg, #ffc107, #ffe8a1); /* Degradado amarillo */
}

.bg-gradient-info {
    background: linear-gradient(90deg, #17a2b8, #85e0e6); /* Degradado cian */
}

/* Estilos de texto */
.display-4 {
    font-size: 2rem; /* Tamaño grande para los totales */
}

/* Botones */
.btn {
    padding: 10px 20px; /* Espaciado interno */
    font-size: 1.2rem; /* Tamaño de fuente del botón */
    border-radius: 5px; /* Bordes redondeados */
}
</style>

@section('content')
<div class="container mt-5">
    <div class="row text-center mt-4">
        <div class="col-md-12 text-right">
            <a href="{{ route('ventas.pdf') }}" class="btn btn-danger btn-lg" target="_blank">Ver Ventas en PDF</a>
        </div>
    </div>

    <h1 class="text-center mb-4 text-primary">Ventas</h1> {{-- Título de la página actualizado a "Ventas" --}}

    <div class="row text-center mb-4">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body bg-gradient-success text-white">
                    <h2 class="card-title">Ventas Diarias</h2>
                    <p class="card-text display-4">${{ number_format($ventasDiarias ?? 0, 2) }}</p> {{-- Usando $ventasDiarias del controlador --}}
                </div>
            </div>
        </div>
        <!-- Puedes agregar más tarjetas aquí si es necesario -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Gráficos de Ventas Mensuales</h2> {{-- Título del gráfico actualizado --}}
            <canvas id="ventasChart" class="w-100"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('ventasChart').getContext('2d');

        // Obtener datos dinámicos de las variables Blade
        const labelsMeses = {{ Js::from($labelsMeses ?? []) }};
        const ventasData = {{ Js::from($ventasData ?? []) }};

        var ventasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsMeses, // Datos dinámicos de los meses
                datasets: [{
                    label: 'Ventas por Mes',
                    data: ventasData,      // Datos dinámicos de las ventas
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto ($)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Ventas Mensuales', // Título del gráfico
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
@endsection