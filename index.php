<?php
session_start();
require_once "config/conexion.php";

// Si ya está logueado, mostrar el dashboard (o redirigir)
if (isset($_SESSION['user_id'])) {
    // Aquí podrías incluir el contenido del dashboard actual o redirigir
    // Por simplicidad, mantendremos el dashboard en un archivo separado o lo incluimos
    header("Location: dashboard.php");
    exit();
}

$error = "";

// Procesar login si se envía desde aquí
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
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
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('institutional_background_1776300677690.png');
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
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            border: none;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #1f2937;
        }
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--dark-blue);
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
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
            <div class="col-lg-7 landing-content animate__animated animate__fadeInLeft">
                <div class="institution-logo">
                    <i class="fas fa-building-columns"></i>
                    <span>Gobierno Regional</span>
                </div>
                <h1 class="display-3 fw-bold mb-4">Sistema de Control <br> de Visitantes</h1>
                <p class="lead mb-5 text-light opacity-75" style="max-width: 600px;">
                    Bienvenido al portal oficial de registro de ingresos. Nuestra plataforma garantiza la seguridad y transparencia en el acceso a todas nuestras dependencias institucionales.
                </p>
                <div class="d-flex gap-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-halved fa-2x text-primary me-3"></i>
                        <span>Seguridad<br>Garantizada</span>
                    </div>
                    <div class="vr mx-3"></div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock-rotate-left fa-2x text-primary me-3"></i>
                        <span>Registro<br>en Tiempo Real</span>
                    </div>
                </div>
            </div>

            <!-- Card de Login -->
            <div class="col-lg-5 col-xl-4 offset-xl-1 animate__animated animate__fadeInRight">
                <div class="card login-card">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Iniciar Sesión</h3>
                        <p class="text-muted small">Acceso exclusivo para personal autorizado</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 text-center" style="font-size: 0.85rem;">
                            <i class="fas fa-exclamation-circle me-1"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control bg-light border-start-0" placeholder="Ej: admin" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-lg">
                            Acceder al Sistema <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-0">¿Extravió sus credenciales?</p>
                        <a href="#" class="text-decoration-none small fw-bold">Contactar a Soporte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-landing">
    &copy; <?php echo date("Y"); ?> Gobierno Regional - Unidad de Tecnologías de la Información. Todos los derechos reservados.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
