<?php
require_once "../config/conexion.php";
include_once "../includes/header.php";
include_once "../includes/navbar.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
    $id_despacho = (int)$_POST['id_despacho'];
    $id_funcionario = (int)$_POST['id_funcionario'];

    // 1. Verificar si la persona ya existe
    $check_p = "SELECT id_persona FROM persona WHERE dni = '$dni'";
    $res_p = mysqli_query($conexion, $check_p);

    if (mysqli_num_rows($res_p) > 0) {
        $id_persona = mysqli_fetch_assoc($res_p)['id_persona'];
        mysqli_query($conexion, "UPDATE persona SET nombre = '$nombre' WHERE id_persona = $id_persona");
    } else {
        mysqli_query($conexion, "INSERT INTO persona (nombre, dni) VALUES ('$nombre', '$dni')");
        $id_persona = mysqli_insert_id($conexion);
    }

    // 2. Registrar la visita
    $fecha = date('Y-m-d');
    $hora_entrada = date('H:i:s');

    $sql_v = "INSERT INTO visita (id_persona, id_despacho, id_funcionario, fecha, hora_entrada) 
              VALUES ($id_persona, $id_despacho, $id_funcionario, '$fecha', '$hora_entrada')";
    
    if (mysqli_query($conexion, $sql_v)) {
        $mensaje = "<div class='alert alert-success shadow-sm'><i class='fas fa-check-circle me-2'></i>Visita registrada exitosamente a las $hora_entrada</div>";
    } else {
        $mensaje = "<div class='alert alert-danger shadow-sm'><i class='fas fa-times-circle me-2'></i>Error al registrar: " . mysqli_error($conexion) . "</div>";
    }
}

$despachos = mysqli_query($conexion, "SELECT * FROM despacho ORDER BY nombre ASC");
?>

<!-- Tom-Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<div class="container container-main fade-in">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Nueva Entrada de Visitante</h5>
                </div>
                <div class="card-body p-4">
                    <?php echo $mensaje; ?>
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">DNI / Documento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="dni" id="dni_input" class="form-control" 
                                           placeholder="Ingrese DNI" maxlength="8" 
                                           onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                </div>
                                <small class="text-muted">8 dígitos numéricos.</small>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Nombre Completo del Visitante</label>
                                <input type="text" name="nombre" id="nombre_input" class="form-control" placeholder="Nombre completo" required>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Despacho / Área Destino</label>
                                <select name="id_despacho" id="despacho_select" class="form-select" required>
                                    <option value="">Seleccione el área...</option>
                                    <?php while($d = mysqli_fetch_assoc($despachos)): ?>
                                        <option value="<?php echo $d['id_despacho']; ?>"><?php echo $d['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Funcionario a Visitar</label>
                                <select name="id_funcionario" id="funcionario_select" placeholder="Busque al funcionario..." required>
                                    <option value="">Primero seleccione un área...</option>
                                </select>
                                <small class="text-muted">Debe existir en la base de datos para registrar la visita.</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                            <button type="reset" class="btn btn-light px-4 border">Limpiar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i>Confirmar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tom-Select JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
// Instancia de Tom-Select para el funcionario
let funcionarioControl = new TomSelect("#funcionario_select", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});

// Autocompletar nombre por DNI
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

// Cargar funcionarios según despacho seleccionado
document.getElementById('despacho_select').addEventListener('change', function() {
    const id_despacho = this.value;
    funcionarioControl.clear();
    funcionarioControl.clearOptions();
    
    if (id_despacho) {
        fetch(`get_funcionarios.php?id_despacho=${id_despacho}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(f => {
                    funcionarioControl.addOption({
                        value: f.id_funcionario,
                        text: `${f.nombre} (${f.cargo})`
                    });
                });
                funcionarioControl.refreshOptions();
                funcionarioControl.focus();
            });
    } else {
        funcionarioControl.addOption({value: "", text: "Primero seleccione un área..."});
    }
});
</script>

<?php include_once "../includes/footer.php"; ?>
