<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_servicio = $_POST['id_servicio'];
$eliminarBaseServicio = $operativo->eliminarBaseServicio($id_servicio);

?>