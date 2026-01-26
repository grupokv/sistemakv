<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Programacion.php");
require_once("../Modelo/General.php");

$id_servicio = $_POST['id_servicio'];
$id_asignacion = $_POST['id_asignacion'];
$detalle = $_POST['detalle'];
$num = $_POST['num'];
$hoy = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['id_usuario'];

$programacion = new Programacion();
if($num == 1){
	$resultado1 = $programacion->registrarSeguimientoPre($id_servicio,$id_asignacion,$detalle,$hoy,$id_usuario);
} else {
	$resultado1 = $programacion->registrarSeguimientoPost($id_servicio,$id_asignacion,$detalle,$hoy,$id_usuario);
}

header('Location: ../Vista/asignaciones.php');

?>