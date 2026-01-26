<?php 
include ("Sesion/autenticar.php");
require_once '../Modelo/Programacion.php';

$programacion = new Programacion();

$id_solicitud = $_POST['id_s'];
$detalle = $_POST['novedad_finalizacion'];
$id_servicio = '0';
$usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');

$guardar = $programacion->guardarDetalle($id_solicitud,$id_servicio,$detalle,$usuario,$fecha);
$actualizar = $programacion->cambiarEstado($id_solicitud);

header('Location: ../Vista/programacion_solicitudes.php');
?>