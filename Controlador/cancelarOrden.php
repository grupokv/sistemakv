<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/OrdenServicio.php");

$id_orden_s = $_POST['id_orden_s'];
$motivo = $_POST['motivo'];

$orden = new OrdenServicio();

$actualizar = $orden->cancelar($id_orden_s,$motivo);

header('Location: ../Vista/ordenes_servicio.php');
?>