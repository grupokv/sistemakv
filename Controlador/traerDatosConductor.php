<?php 
require_once("../Modelo/Conductor.php");

$id = $_POST['id_conductor'];

$conductor = new Conductor();
$datos = $conductor->listarPorId($id);

$cant = count($datos);

$html = '';
if ($cant > 0) {
    $html .= $datos[0]['nombre_conductor'].'|'.$datos[0]['numero_documento_conductor'].'|'.$datos[0]['num_licencia'].'|'.$datos[0]['telefono1'].'|'.$datos[0]['fecha_vencimiento_licencia'];
}

echo $html;
?>