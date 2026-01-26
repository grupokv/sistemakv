<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/CargoCliente.php");
require_once("../Modelo/General.php");

$nombre_cargo = mb_strtoupper($_POST['nombre_cargo']);
$id_cliente = $_POST['id_cliente'];

$cargo = new CargoCliente();
$registrarC = $cargo->registrarCargos($nombre_cargo, $id_cliente);
header('Location: ../Vista/cargo_cliente.php');
 ?>