<?php
require_once "../config/conexion.php";
include_once "../includes/header.php";
include_once "../includes/navbar.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
    $id_despacho = $_POST['id_despacho'];
    $persona_visitada = mysqli_real_escape_string($conexion, $_POST['persona_visitada']);

    // 1. Verificar si la persona ya existe
    $check_p = "SELECT id_persona FROM persona WHERE dni = '$dni'";
    $res_p = mysqli_query($conexion, $check_p);

    if (mysqli_num_rows($res_p) > 0) {
        $id_persona = mysqli_fetch_assoc($res_p)['id_persona'];
        // Actualizar nombre por si cambió
        mysqli_query($conexion, "UPDATE persona SET nombre = '$nombre' WHERE id_persona = $id_persona");
    } else {
        // Crear persona
        mysqli_query($conexion, "INSERT INTO persona (nombre, dni) VALUES ('$nombre', '$dni')");
        $id_persona = mysqli_insert_id($conexion);
    }

    // 2. Registrar la visita
    $fecha = date('Y-m-d');
    $hora_entrada = date('H:i:s');

    $sql_v = "INSERT INTO visita (id_persona, id_despacho, persona_visitada, fecha, hora_entrada) 
              VALUES ($id_persona, $id_despacho, '$persona_visitada', '$fecha', '$hora_entrada')";
    
    if (mysqli_query($conexion, $sql_v)) {
        $mensaje = "<div class='alert alert-success'>Visita registrada exitosamente a las $hora_entrada</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar: " . mysqli_error($conexion) . "</div>";
    }
}

// Obtener despachos para el select
$despachos = mysqli_query($conexion, "SELECT * FROM despacho ORDER BY nombre ASC");
?>

<div class="container container-main fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Registrar Entrada de Visitante</h5>
                </div>
                <div class="card-body">
                    <?php echo $mensaje; ?>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">DNI / Documento</label>
                                <input type="text" name="dni" id="dni_input" class="form-control" 
                                       placeholder="Ingrese DNI" maxlength="8" 
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                <small class="text-muted">Debe tener 8 dígitos numéricos.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="nombre" id="nombre_input" class="form-control" placeholder="Nombre completo" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Despacho / Oficina</label>
                                <select name="id_despacho" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <?php while($d = mysqli_fetch_assoc($despachos)): ?>
                                        <option value="<?php echo $d['id_despacho']; ?>"><?php echo $d['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Persona a Visitar (Funcionario)</label>
                                <input type="text" name="persona_visitada" class="form-control" placeholder="Nombre del funcionario" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-secondary">Limpiar</button>
                            <button type="submit" class="btn btn-primary">Registrar Entrada</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Pequeño script para autocompletar nombre si el DNI ya existe (vía fetch)
// Nota: Para este ejemplo solo dejaré el esqueleto, pero es una buena práctica
document.getElementById('dni_input')?.addEventListener('input', function() {
    const dni = this.value;
    if (dni.length === 8) {
        fetch(`get_persona.php?dni=${dni}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const nombreInput = document.getElementById('nombre_input');
                    nombreInput.value = data.nombre;
                    nombreInput.classList.add('is-valid');
                    setTimeout(() => nombreInput.classList.remove('is-valid'), 2000);
                }
            });
    }
});
</script>

<?php include_once "../includes/footer.php"; ?>
