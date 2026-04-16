<?php
session_start();
require_once "config/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Institucional - Control de Visitantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --dark-blue: #1e3a8a;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .landing-content {
            padding-right: 50px;
        }
        .institution-logo {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .institution-logo i {
            margin-right: 15px;
            color: #60a5fa;
        }
        .action-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            border: none;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #1f2937;
            text-align: center;
        }
        .btn-action {
            padding: 1rem;
            font-weight: 600;
            border-radius: 1rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            text-decoration: none;
        }
        .btn-primary-custom {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: var(--dark-blue);
            transform: translateY(-3px);
            color: white;
        }
        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        .btn-outline-custom:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        .footer-landing {
            position: absolute;
            bottom: 20px;
            left: 50px;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
        }
        @media (max-width: 992px) {
            body { overflow: auto; }
            .hero-section { height: auto; padding: 100px 0; }
            .landing-content { padding-right: 0; text-align: center; margin-bottom: 50px; }
            .institution-logo { justify-content: center; }
        }
    </style>
</head>
<body>

<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Texto Institucional -->
            <div class="col-lg-7 landing-content">
                <div class="institution-logo">
                    <i class="fas fa-building-columns"></i>
                    <span>Gobierno Regional</span>
                </div>
                <h1 class="display-3 fw-bold mb-4">Sistema de Control <br> de Visitantes</h1>
                <p class="lead mb-5 text-light opacity-75" style="max-width: 600px;">
                    Portal oficial para la gestión y registro de ingresos. Nuestra plataforma garantiza la transparencia y el seguimiento eficiente de todos los accesos institucionales.
                </p>
                <div class="d-flex gap-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users-viewfinder fa-2x text-primary me-3"></i>
                        <span>Control<br>Eficiente</span>
                    </div>
                    <div class="vr mx-2"></div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-invoice fa-2x text-primary me-3"></i>
                        <span>Reportes<br>detallados</span>
                    </div>
                </div>
            </div>

            <!-- Card de Acciones -->
            <div class="col-lg-5 col-xl-4 offset-xl-1">
                <div class="card action-card">
                    <div class="text-center mb-4">
                        <i class="fas fa-id-badge fa-4x text-primary mb-3"></i>
                        <h3 class="fw-bold">Acceso al Sistema</h3>
                        <p class="text-muted small">Seleccione la acción que desea realizar</p>
                    </div>

                    <a href="dashboard.php" class="btn-action btn-primary-custom shadow">
                        <i class="fas fa-gauge-high me-3"></i> Panel de Control
                    </a>

                    <a href="modulos/registro_entrada.php" class="btn-action btn-outline-custom">
                        <i class="fas fa-user-plus me-3"></i> Nueva Entrada
                    </a>

                    <a href="modulos/registro_salida.php" class="btn-action btn-outline-custom">
                        <i class="fas fa-door-open me-3"></i> Registrar Salida
                    </a>

                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-0">Unidad de Tecnologías de la Información</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-landing">
    &copy; <?php echo date("Y"); ?> Gobierno Regional. Todos los derechos reservados.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
