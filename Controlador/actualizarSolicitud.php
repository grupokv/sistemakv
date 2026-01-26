<?php 

require_once '../Modelo/Programacion.php';

$programacion = new Programacion();

$idas = $_POST['idas'];
$retornos = $_POST['retornos'];
$id_solicitud = $_POST['id_solicitud'];

$actualizar = $programacion->actualizar($idas, $retornos, $id_solicitud);

header('Location: ../Vista/programacion_solicitudes.php');
?>