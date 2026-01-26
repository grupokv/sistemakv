<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
require_once("../Modelo/ClienteProspecto.php");
require_once("../Modelo/General.php");

$razon_social = mb_strtoupper($_POST['razon_social']);
$nit = $_POST['nit_cliente'];
$direccion = mb_strtoupper($_POST['direccion']);
$telefono = $_POST['telefono'];
$status = $_POST['status'];
$volumen = $_POST['volumen'];
$frecuencia = $_POST['frecuencia'];

$creador = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');

$cliente = new ClienteProspecto();
$registrarC = $cliente->registrar($razon_social, $nit, $direccion, $telefono, $status, $volumen, $frecuencia, $creador, $fecha);

echo "<script>
alert('Cliente creado correctamente');
window.location = '../Vista/clientes_prospecto.php';
</script>";
?>