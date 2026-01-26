<?php 

include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/SeguimientoActualizacion.php';

$seguimiento = new Seguimiento_Actualizacion();

$id_seguimiento = $_GET['id_seguimiento'];
$estado = 'F';

$eliminarNotificacionSeguimiento = $seguimiento->eliminarNotificacionSeguimiento($id_seguimiento, $estado);

header('Location: ../Vista/inicioPropietarios.php');

?>