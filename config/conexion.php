<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db   = "control_visitantes";

// Crear conexión
$conexion = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer conjunto de caracteres utf8
mysqli_set_charset($conexion, "utf8");

// Definir URL base dinámica (se adapta al nombre de la carpeta en htdocs)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$folder = basename(dirname(__DIR__));
define('BASE_URL', "/$folder/");
?>
