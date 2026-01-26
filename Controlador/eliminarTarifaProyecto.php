<?php 
require_once '../Modelo/Contrato.php';

$contrato = new Contrato();

echo $id_tarifa_proyecto = $_GET['id_tarifa_proyecto'];

$eliminarTarifa = $contrato->eliminarTarifa($id_tarifa_proyecto);


echo "<script>alert('Se elimino correctamente la tarifa de este proyecto.'); window.location.href='../Vista/contratos.php';</script>";
?>