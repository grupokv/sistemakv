<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Programacion.php");
require_once("../Modelo/General.php");

$id_servicio = $_POST['id_servicio'];
$id_asignacion = $_POST['id_asignacion'];
$tipo_relevo = $_POST['tipo_relevo'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];
$costo = $_POST['costo'];
$hoy = date('Y-m-d H:i:s');

$programacion = new Programacion();
$resultado1 = $programacion->registrarAsignacion($id_servicio,$id_vehiculo,$id_conductor,'A',$hoy,$tipo_relevo,$costo);
$resultado2 = $programacion->cambiarEstadoAsignacionRelevo($id_asignacion);

header('Location: ../Vista/asignaciones.php');

?>