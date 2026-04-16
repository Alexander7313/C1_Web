<?php
require_once "../config/conexion.php";

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
$tipo = $_GET['tipo'] ?? 'csv';

if ($tipo == 'excel') {
    // Exportar a Excel (Formato HTML Table que Excel reconoce)
    $filename = "reporte_visitas_" . date('Ymd_His') . ".xls";
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$filename");
    
    echo "<table border='1'>";
    echo "<tr>
            <th style='background-color: #4e73df; color: white;'>Fecha</th>
            <th style='background-color: #4e73df; color: white;'>Visitante</th>
            <th style='background-color: #4e73df; color: white;'>DNI</th>
            <th style='background-color: #4e73df; color: white;'>Persona Visitada</th>
            <th style='background-color: #4e73df; color: white;'>Despacho</th>
            <th style='background-color: #4e73df; color: white;'>Hora Entrada</th>
            <th style='background-color: #4e73df; color: white;'>Hora Salida</th>
            <th style='background-color: #4e73df; color: white;'>Permanencia</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $row['fecha'] . "</td>";
        echo "<td>" . $row['visitante'] . "</td>";
        echo "<td>" . $row['dni'] . "</td>";
        echo "<td>" . $row['persona_visitada'] . "</td>";
        echo "<td>" . $row['despacho'] . "</td>";
        echo "<td>" . $row['hora_entrada'] . "</td>";
        echo "<td>" . ($row['hora_salida'] ?? 'N/A') . "</td>";
        echo "<td>" . ($row['tiempo_permanencia'] ?? 'En planta') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // Exportar a CSV (Predeterminado)
    $filename = "reporte_visitas_" . date('Ymd_His') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para UTF-8
    fputcsv($output, ['Fecha', 'Visitante', 'DNI', 'Persona Visitada', 'Despacho', 'Hora Entrada', 'Hora Salida', 'Permanencia'], ";");
    
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
}
exit();
?>
