<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");
$id_detalle = $_POST['id_detalle'];$estado= $_POST['estado'];if($estado == 'A'){	$hora = date('H:i:s');} else {	$hora = '00:00:00';}
$veh = new Vehiculo();

$actualizar = $veh->CambiarEstadoPasajero($id_detalle,$hora);
?>