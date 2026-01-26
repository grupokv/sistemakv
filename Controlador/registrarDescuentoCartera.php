<?php
session_start();
include 'Sesion/autenticar.php';
require_once("../Modelo/Cartera.php");

date_default_timezone_set('America/Bogota');
$cartera = new Cartera();

$id_vehiculo = $_POST['id_vehiculo'];
$id_concepto = $_POST['id_concepto'];
$tipo_descuento = $_POST['tipo_descuento'];
$descuento = $_POST['descuento'];
$fecha_inicial_valido = $_POST['fecha_inicial'];
$fecha_final_valido = $_POST['fecha_final'];
$id_usuario_creador = $_SESSION['id_usuario'];
$fecha_creacion_descuento = date('Y-m-d H:i:s');
$descuento_nomina = $_POST['nomina'];

if($_POST['id_cliente'] == ""){
    $id_cliente = 0;
}else{
    $id_cliente = $_POST['id_cliente'];
}

$registrarDescuentos = $cartera->registrarDescuentos($id_vehiculo, $id_concepto, $tipo_descuento, $descuento, $fecha_inicial_valido, $fecha_final_valido, $id_usuario_creador, $fecha_creacion_descuento, $descuento_nomina, $id_cliente);

header("Location: ../Vista/descuentosCartera.php");


?>