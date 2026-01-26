<?php
require_once("../Modelo/Vinculacion.php");

$vinculacion = new Vinculacion();

$nombres_apellidos = $_POST['nombres_apellidos'];
$num_documento = $_POST['num_documento'];
$telefono = $_POST['telefono'];
$correo_electronico = $_POST['correo_electronico'];
$ciudad_residencia = $_POST['ciudad_residencia'];
$placa = $_POST['placa'];
$tipo_vehiculo = $_POST['tipo_vehiculo'];
$marca = $_POST['marca_linea'];
$modelo = $_POST['modelo'];
$motivo = $_POST['motivo'];
$fecha = date('Y-m-d H:i:s');

$registrarSolicitudVinculacion = $vinculacion->registrarSolicitudVinculacion($nombres_apellidos, $num_documento, $telefono, $correo_electronico, $ciudad_residencia, $placa, $tipo_vehiculo, $marca, $modelo, $motivo, $fecha);

//header('Location: ../Vista/inicio.php');
?>