<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/TipoServicioCliente.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['detalle']);
$id_cliente = $_POST['id_cliente'];
$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];

$tipo = new TipoServicioCliente();
$registrarC = $tipo->registrar($detalle, $id_tipo_vehiculo, $id_cliente);
header('Location: ../Vista/tipo_servicio_cliente.php');
?>