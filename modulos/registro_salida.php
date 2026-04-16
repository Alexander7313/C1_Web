<?php
require_once "../config/conexion.php";
include_once "../includes/header.php";
include_once "../includes/navbar.php";

$mensaje = "";

// Registrar salida
if (isset($_GET['finalizar'])) {
    $id_visita = $_GET['finalizar'];
    $hora_salida = date('H:i:s');
    
    // Obtener la hora de entrada para calcular permanencia
    $sql_v = "SELECT hora_entrada FROM visita WHERE id_visita = $id_visita";
    $res_v = mysqli_query($conexion, $sql_v);
    $visita = mysqli_fetch_assoc($res_v);
    
    if ($visita) {
        $hora_entrada = $visita['hora_entrada'];
        
        // Calcular tiempo de permanencia usando SQL para exactitud
        $sql_calc = "SELECT TIMEDIFF('$hora_salida', '$hora_entrada') as diff";
        $res_calc = mysqli_query($conexion, $sql_calc);
        $diff_raw = mysqli_fetch_assoc($res_calc)['diff'];
        
        // Formatear el tiempo de permanencia (HH:MM:SS -> "X horas Y minutos")
        $partes = explode(':', $diff_raw);
        $horas = (int)$partes[0];
        $minutos = (int)$partes[1];
        $tiempo_legible = "$horas horas $minutos minutos";

        $sql_update = "UPDATE visita SET 
                       hora_salida = '$hora_salida', 
                       tiempo_permanencia = '$tiempo_legible' 
                       WHERE id_visita = $id_visita";
        
        if (mysqli_query($conexion, $sql_update)) {
            $mensaje = "<div class='alert alert-success'>Salida registrada a las $hora_salida. Permanencia: $tiempo_legible</div>";
        }
    }
}

// Obtener personas actualmente dentro
$sql_dentro = "SELECT v.*, p.nombre, p.dni, d.nombre as despacho, f.nombre as funcionario 
               FROM visita v 
               JOIN persona p ON v.id_persona = p.id_persona 
               JOIN despacho d ON v.id_despacho = d.id_despacho 
               JOIN funcionario f ON v.id_funcionario = f.id_funcionario
               WHERE v.hora_salida IS NULL 
               ORDER BY v.hora_entrada DESC";
$res_dentro = mysqli_query($conexion, $sql_dentro);
?>

<div class="container container-main fade-in">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-sign-out-alt me-2"></i>Control de Salida de Visitantes</h5>
                </div>
                <div class="card-body">
                    <?php echo $mensaje; ?>
                    
                    <div class="alert alert-info py-2">
                        <i class="fas fa-info-circle me-2"></i>Lista de personas que se encuentran actualmente en las instalaciones.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre del Visitante</th>
                                    <th>Visitó a / Despacho</th>
                                    <th>Hora Entrada</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($res_dentro) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res_dentro)): ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?php echo $row['dni']; ?></span></td>
                                            <td class="fw-bold"><?php echo $row['nombre']; ?></td>
                                            <td>
                                                <div class="small fw-bold"><?php echo $row['funcionario']; ?></div>
                                                <div class="small text-muted"><?php echo $row['despacho']; ?></div>
                                            </td>
                                            <td><?php echo $row['hora_entrada']; ?></td>
                                            <td class="text-center">
                                                <a href="?finalizar=<?php echo $row['id_visita']; ?>" 
                                                   class="btn btn-danger btn-sm px-3"
                                                   onclick="return confirm('¿Registrar la salida de este visitante?')">
                                                   <i class="fas fa-clock me-1"></i> Finalizar Visita
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No hay personas registradas "En Planta".</td>
                                    </tr>
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
