<?php 
require_once '../Modelo/Agendas.php';

$agenda = new Agenda();

$id_acta  = $_POST['id_acta'];
$situacion  = $_POST['descripcion_situacion'];
$soluciones = $_POST['actividades_soluciones'];
$responsable = $_POST['id_responsable'];
$reportado_a = $_POST['id_reportado'];
$limite = $_POST['fecha_limite'];


for ($i=0; $i < count($situacion); $i++) { 

	$descripcion_situacion = $situacion[$i];
	$actividades_soluciones = $soluciones[$i];
	$id_responsable = $responsable[$i];
	$id_reportado_a = $reportado_a[$i];
	$fecha_limite = $limite[$i];

	$registrarSituacion = $agenda->registrarSituacion($id_acta, $descripcion_situacion, $actividades_soluciones, $id_responsable, $id_reportado_a, $fecha_limite);
}

 ?>