<?php 
require_once '../Modelo/SeguimientoActualizacion.php';

echo $id_seguimiento = $_GET['id_seguimiento'];
$estado = 'E';

$seguimiento = new Seguimiento_Actualizacion();

$eliminarNotificacionSeguimiento = $seguimiento->eliminarNotificacionSeguimiento($id_seguimiento, $estado);

header('Location: ../Vista/SeguimientoActualizaciones.php');

?>