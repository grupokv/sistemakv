<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/DestinoCliente.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['detalle']);
$id_cliente = $_POST['id_cliente'];
$id_centro_costo = $_POST['id_centro_costo'];

$tipo = new DestinoCliente();
$registrarC = $tipo->registrar($detalle, $id_cliente, $id_centro_costo);
header('Location: ../Vista/destino_cliente.php');
?>