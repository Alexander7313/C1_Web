<?php
require_once "../config/conexion.php";
include_once "../includes/header.php";
include_once "../includes/navbar.php";

// Inicializar filtros
$where = "WHERE 1=1";
$f_fecha = $_GET['f_fecha'] ?? '';
$f_nombre = $_GET['f_nombre'] ?? '';
$f_despacho = $_GET['f_despacho'] ?? '';

if ($f_fecha) {
    $where .= " AND v.fecha = '$f_fecha'";
}
if ($f_nombre) {
    $where .= " AND p.nombre LIKE '%$f_nombre%'";
}
if ($f_despacho) {
    $where .= " AND v.id_despacho = $f_despacho";
}

$sql = "SELECT v.*, p.nombre as visitante, p.dni, d.nombre as despacho 
        FROM visita v 
        JOIN persona p ON v.id_persona = p.id_persona 
        JOIN despacho d ON v.id_despacho = d.id_despacho 
        $where 
        ORDER BY v.fecha DESC, v.hora_entrada DESC";
$res = mysqli_query($conexion, $sql);

// Despachos para el select de filtro
$despachos = mysqli_query($conexion, "SELECT * FROM despacho ORDER BY nombre ASC");
?>

<div class="container container-main fade-in">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-search me-2"></i>Búsqueda Avanzada de Visitas</h6>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small">Fecha</label>
                            <input type="date" name="f_fecha" class="form-control form-control-sm" value="<?php echo $f_fecha; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Nombre del Visitante</label>
                            <input type="text" name="f_nombre" class="form-control form-control-sm" placeholder="Buscar..." value="<?php echo $f_nombre; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Despacho</label>
                            <select name="f_despacho" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                <?php while($d = mysqli_fetch_assoc($despachos)): ?>
                                    <option value="<?php echo $d['id_despacho']; ?>" <?php echo ($f_despacho == $d['id_despacho']) ? 'selected' : ''; ?>>
                                        <?php echo $d['nombre']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100 me-2"><i class="fas fa-filter"></i> Filtrar</button>
                            <a href="consultas.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-undo"></i></a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Resultados</h5>
                        <div>
                            <a href="exportar.php?tipo=csv&<?php echo $_SERVER['QUERY_STRING']; ?>" class="btn btn-sm btn-outline-dark">
                                <i class="fas fa-file-csv me-1"></i> Exportar CSV
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover small">
                            <thead class="bg-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Visitante</th>
                                    <th>DNI</th>
                                    <th>A quién visitó</th>
                                    <th>Despacho</th>
                                    <th>E.</th>
                                    <th>S.</th>
                                    <th>Permanencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($res) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res)): ?>
                                        <tr>
                                            <td><?php echo $row['fecha']; ?></td>
                                            <td class="fw-bold"><?php echo $row['visitante']; ?></td>
                                            <td><?php echo $row['dni']; ?></td>
                                            <td><?php echo $row['persona_visitada']; ?></td>
                                            <td><?php echo $row['despacho']; ?></td>
                                            <td><span class="text-success"><?php echo $row['hora_entrada']; ?></span></td>
                                            <td><span class="text-danger"><?php echo $row['hora_salida'] ?? '--:--'; ?></span></td>
                                            <td><span class="badge bg-light text-dark border"><?php echo $row['tiempo_permanencia'] ?? 'En curso'; ?></span></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center text-muted py-3">No se encontraron resultados</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>
