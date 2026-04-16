<?php
require_once "../config/conexion.php";

if (isset($_GET['dni'])) {
    $dni = mysqli_real_escape_string($conexion, $_GET['dni']);
    $query = "SELECT nombre FROM persona WHERE dni = '$dni'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $persona = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'nombre' => $persona['nombre']]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
