<?php 

require_once "../Modelo/ConceptosCobro.php";
$conceptoCobro = new ConceptoCobro();

echo $id_notificacion_comprobante = $_GET['id_notificacion_comprobante'];

$eliminarNotificacionComprobante = $conceptoCobro->eliminarNotificacionComprobante($id_notificacion_comprobante);

header("Location: ../Vista/inicioPropietarios.php");

?>