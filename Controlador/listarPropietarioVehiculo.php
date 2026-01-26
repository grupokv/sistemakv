<?php 
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new Vehiculo();
$usuario = new Usuario();

$listarPorId = $vehiculo->listarPorId($_POST['id_vehiculo']);
$listarUsuarioPorId = $usuario->listarUsuarioPorId($listarPorId[0]['id_propietario']);

echo $listarUsuarioPorId[0]['nombre'];

?>