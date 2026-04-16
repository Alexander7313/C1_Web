<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
require_once "config/conexion.php";
include_once "includes/header.php";
include_once "includes/navbar.php";

// Consultas para el Dashboard
$fecha_hoy = date('Y-m-d');

// Total visitas hoy
$sql_hoy = "SELECT COUNT(*) as total FROM visita WHERE fecha = '$fecha_hoy'";
$res_hoy = mysqli_query($conexion, $sql_hoy);
$total_hoy = mysqli_fetch_assoc($res_hoy)['total'];

// Personas dentro actualmente (sin hora de salida)
$sql_dentro = "SELECT COUNT(*) as total FROM visita WHERE hora_salida IS NULL";
$res_dentro = mysqli_query($conexion, $sql_dentro);
$total_dentro = mysqli_fetch_assoc($res_dentro)['total'];

// Total registros históricos
$sql_total = "SELECT COUNT(*) as total FROM visita";
$res_total = mysqli_query($conexion, $sql_total);
$total_historico = mysqli_fetch_assoc($res_total)['total'];

// Últimas 5 visitas
$sql_ultimas = "SELECT v.*, p.nombre as visitante, d.nombre as despacho, f.nombre as funcionario 
                FROM visita v 
                JOIN persona p ON v.id_persona = p.id_persona 
                JOIN despacho d ON v.id_despacho = d.id_despacho 
                JOIN funcionario f ON v.id_funcionario = f.id_funcionario
                ORDER BY v.id_visita DESC LIMIT 5";
$res_ultimas = mysqli_query($conexion, $sql_ultimas);
?>

<div class="container container-main fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">Panel de Control</h1>
            <p class="text-muted">Gestión administrativa de visitas e ingresos</p>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2 shadow-sm">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Visitas hoy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_hoy; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2 shadow-sm">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">En Planta (Actual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_dentro; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-viewfinder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2 shadow-sm">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Archivo Histórico</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_historico; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Últimas Actividades -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">Actividad Reciente</h6>
                    <a href="modulos/consultas.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">Ver Historial</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Visitante</th>
                                    <th>Destino</th>
                                    <th>Persona Visitada</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($res_ultimas) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res_ultimas)): ?>
                                        <tr>
                                            <td class="fw-bold text-dark"><?php echo $row['visitante']; ?></td>
                                            <td><span class="badge bg-light text-dark border"><?php echo $row['despacho']; ?></span></td>
                                            <td><?php echo $row['funcionario']; ?></td>
                                            <td><?php echo $row['hora_entrada']; ?></td>
                                            <td>
                                                <?php if($row['hora_salida']): ?>
                                                    <span class="badge bg-success-subtle text-success px-3">Salida: <?php echo $row['hora_salida']; ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3">En el recinto</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-4">No hay registros recientes.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <a href="modulos/registro_entrada.php" class="btn btn-primary d-flex align-items-center justify-content-center py-4 rounded-4 shadow-sm border-0">
                <i class="fas fa-user-plus me-3 fa-2x"></i>
                <div class="text-start">
                    <div class="fw-bold h5 mb-0 text-white">Nueva Entrada</div>
                    <small class="opacity-75">Registrar nuevo ingreso</small>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="modulos/registro_salida.php" class="btn btn-success d-flex align-items-center justify-content-center py-4 rounded-4 shadow-sm border-0">
                <i class="fas fa-door-open me-3 fa-2x"></i>
                <div class="text-start">
                    <div class="fw-bold h5 mb-0 text-white">Registrar Salida</div>
                    <small class="opacity-75">Marcar retiro del recinto</small>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
