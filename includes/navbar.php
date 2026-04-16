<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container container-navbar">
        <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>dashboard.php">
            <i class="fas fa-id-card-clip me-2 text-primary"></i>VisitorControl
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard.php">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>modulos/registro_entrada.php">
                        <i class="fas fa-sign-in-alt me-1"></i> Registrar Entrada
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>modulos/registro_salida.php">
                        <i class="fas fa-sign-out-alt me-1"></i> Registrar Salida
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>modulos/consultas.php">
                        <i class="fas fa-search me-1"></i> Consultas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>modulos/reportes.php">
                        <i class="fas fa-chart-bar me-1"></i> Reportes
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-3">
                    <span class="text-light opacity-75 small">
                        <i class="fas fa-user-circle me-1"></i> 
                        <?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Admin'; ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger btn-sm rounded-pill px-3" href="<?php echo BASE_URL; ?>logout.php">
                        <i class="fas fa-power-off me-2"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
