<?php
require_once "../config/conexion.php";

if (isset($_GET['id_despacho'])) {
    $id_despacho = (int)$_GET['id_despacho'];
    $query = "SELECT id_funcionario, nombre, cargo FROM funcionario WHERE id_despacho = $id_despacho ORDER BY nombre ASC";
    $result = mysqli_query($conexion, $query);

    $funcionarios = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $funcionarios[] = $row;
    }
    echo json_encode($funcionarios);
}
?>
