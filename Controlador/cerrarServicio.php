<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Programacion.php");
require_once("../Modelo/General.php");

$id_servicio = $_POST['id_servicio'];
$id_asignacion = $_POST['id_asignacion'];

$programacion = new Programacion();

$cerrar = $programacion->finalizarServicio($id_servicio);
$cerrar = $programacion->finalizarAsignacion($id_asignacion);

header('Location: ../Vista/asignaciones.php');

?>