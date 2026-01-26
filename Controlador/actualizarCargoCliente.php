<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/CargoCliente.php");
require_once("../Modelo/General.php");


$id_cargo = $_POST['id_cargo'];
$nombre_cargo = mb_strtoupper($_POST['nombre_cargo']);
$id_cliente = $_POST['id_cliente'];
$cargo = new CargoCliente();
$actualizar = $cargo->actualizarCargos($id_cargo, $nombre_cargo, $id_cliente);
header('Location: ../Vista/cargo_cliente.php');
 ?>