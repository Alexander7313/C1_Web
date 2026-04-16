<?php
require_once "../config/conexion.php";
include_once "../includes/header.php";
include_once "../includes/navbar.php";

// 1. Visitas por día (últimos 7 días)
$sql_dias = "SELECT fecha, COUNT(*) as total FROM visita GROUP BY fecha ORDER BY fecha DESC LIMIT 7";
$res_dias = mysqli_query($conexion, $sql_dias);
$labels_dias = [];
$data_dias = [];
while($row = mysqli_fetch_assoc($res_dias)) {
    $labels_dias[] = $row['fecha'];
    $data_dias[] = $row['total'];
}
$labels_dias = array_reverse($labels_dias);
$data_dias = array_reverse($data_dias);

// 2. Visitas por despacho
$sql_desp = "SELECT d.nombre, COUNT(v.id_visita) as total 
             FROM despacho d 
             LEFT JOIN visita v ON d.id_despacho = v.id_despacho 
             GROUP BY d.id_despacho";
$res_desp = mysqli_query($conexion, $sql_desp);
$labels_desp = [];
$data_desp = [];
while($row = mysqli_fetch_assoc($res_desp)) {
    $labels_desp[] = $row['nombre'];
    $data_desp[] = $row['total'];
}

// 3. Tiempo promedio de permanencia
// Para simplificar, calculamos el promedio en minutos en base a lo que se tenga registrado
$sql_avg = "SELECT AVG(TIME_TO_SEC(TIMEDIFF(hora_salida, hora_entrada))) / 60 as minutos_promedio 
            FROM visita WHERE hora_salida IS NOT NULL";
$res_avg = mysqli_query($conexion, $sql_avg);
$avg_min = mysqli_fetch_assoc($res_avg)['minutos_promedio'];
$avg_formato = round($avg_min) . " minutos";

// 4. Historial de Visitas (últimas 20)
$sql_historial = "SELECT v.*, p.nombre as visitante, p.dni, d.nombre as despacho, f.nombre as funcionario 
                  FROM visita v 
                  JOIN persona p ON v.id_persona = p.id_persona 
                  JOIN despacho d ON v.id_despacho = d.id_despacho 
                  JOIN funcionario f ON v.id_funcionario = f.id_funcionario
                  ORDER BY v.fecha DESC, v.hora_entrada DESC LIMIT 20";
$res_historial = mysqli_query($conexion, $sql_historial);
?>

<div class="container container-main fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h3><i class="fas fa-chart-pie me-2 text-primary"></i>Reportes Estadísticos</h3>
            <hr>
        </div>
    </div>

    <div class="row">
        <!-- Tarjeta Promedio -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-info py-3">
                <div class="card-body text-center">
                    <div class="text-uppercase text-info fw-bold small mb-2">Tiempo Promedio de Estancia</div>
                    <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $avg_formato; ?></div>
                    <i class="fas fa-clock fa-3x text-light mt-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Barras: Visitas por día -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visitas por Día (Últimos 7 días)</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartDias" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Dona: Visitas por despacho -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución por Despacho</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartDespachos" height="200"></canvas>
                </div>
            </div>
        </div>
        <!-- Historial de Visitas -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Historial Reciente de Visitas</h6>
                    <div>
                        <a href="exportar.php?tipo=csv" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-csv"></i></a>
                        <a href="exportar.php?tipo=excel" class="btn btn-sm btn-outline-success"><i class="fas fa-file-excel"></i></a>
                        <a href="consultas.php" class="btn btn-sm btn-primary ms-2 text-white">Ver todos</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover small">
                            <thead class="bg-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Visitante</th>
                                    <th>DNI</th>
                                    <th>Persona Visitada</th>
                                    <th>Despacho</th>
                                    <th>E.</th>
                                    <th>S.</th>
                                    <th>Permanencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($res_historial) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res_historial)): ?>
                                        <tr>
                                            <td><?php echo $row['fecha']; ?></td>
                                            <td class="fw-bold"><?php echo $row['visitante']; ?></td>
                                            <td><?php echo $row['dni']; ?></td>
                                            <td><?php echo $row['funcionario']; ?></td>
                                            <td><?php echo $row['despacho']; ?></td>
                                            <td><span class="text-success"><?php echo $row['hora_entrada']; ?></span></td>
                                            <td><span class="text-danger"><?php echo $row['hora_salida'] ?? '--:--'; ?></span></td>
                                            <td><span class="badge bg-light text-dark border"><?php echo $row['tiempo_permanencia'] ?? 'En curso'; ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center py-3">No hay registros</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Configuración Gráfico de Barras
    const ctxDias = document.getElementById('chartDias').getContext('2d');
    new Chart(ctxDias, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels_dias); ?>,
            datasets: [{
                label: 'Cantidad de Visitas',
                data: <?php echo json_encode($data_dias); ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Configuración Gráfico de Dona
    const ctxDesp = document.getElementById('chartDespachos').getContext('2d');
    new Chart(ctxDesp, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels_desp); ?>,
            datasets: [{
                data: <?php echo json_encode($data_desp); ?>,
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<?php include_once "../includes/footer.php"; ?>
