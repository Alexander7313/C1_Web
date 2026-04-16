<?php
require_once "../config/conexion.php";

// Solo permitir exportar si hay sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Acceso denegado");
}

// Filtros (mismos que consultas.php)
$where = "WHERE 1=1";
$f_fecha = $_GET['f_fecha'] ?? '';
$f_nombre = $_GET['f_nombre'] ?? '';
$f_despacho = $_GET['f_despacho'] ?? '';

if ($f_fecha) $where .= " AND v.fecha = '$f_fecha'";
if ($f_nombre) $where .= " AND p.nombre LIKE '%$f_nombre%'";
if ($f_despacho) $where .= " AND v.id_despacho = $f_despacho";

$sql = "SELECT v.fecha, p.nombre as visitante, p.dni, v.persona_visitada, d.nombre as despacho, 
               v.hora_entrada, v.hora_salida, v.tiempo_permanencia
        FROM visita v 
        JOIN persona p ON v.id_persona = p.id_persona 
        JOIN despacho d ON v.id_despacho = d.id_despacho 
        $where 
        ORDER BY v.fecha DESC";

$res = mysqli_query($conexion, $sql);

// Nombre del archivo
$filename = "reporte_visitas_" . date('Ymd_His') . ".csv";

// Headers para descarga de CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Abrir el puntero de salida
$output = fopen('php://output', 'w');

// Insertar cabeceras de columnas (BOM para Excel en Windows)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
fputcsv($output, ['Fecha', 'Visitante', 'DNI', 'Persona Visitada', 'Despacho', 'Hora Entrada', 'Hora Salida', 'Permanencia'], ";");

// Insertar datos
while ($row = mysqli_fetch_assoc($res)) {
    fputcsv($output, [
        $row['fecha'],
        $row['visitante'],
        $row['dni'],
        $row['persona_visitada'],
        $row['despacho'],
        $row['hora_entrada'],
        $row['hora_salida'] ?? 'N/A',
        $row['tiempo_permanencia'] ?? 'En planta'
    ], ";");
}

fclose($output);
exit();
?>
