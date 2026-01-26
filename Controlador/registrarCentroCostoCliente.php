<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/CentroCostoCliente.php");
require_once("../Modelo/General.php");

$nombre = mb_strtoupper($_POST['nombre']);
$id_cliente = $_POST['id_cliente'];

$cc = new CentroCostoCliente();
$registrarC = $cc->registrar($nombre, $id_cliente);
header('Location: ../Vista/centro_costo_cliente.php');
?>