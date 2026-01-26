<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Pasajero.php");

/*USUARIO*/
$nombre = mb_strtoupper($_POST['nombre']);
$direccion = mb_strtoupper($_POST['direccion']);

$hora_subida = $_POST['hora_subida'];
$cadena = strtotime($hora_subida);
$hora_subida = date("H:i:s", $cadena);

$hora_bajada = $_POST['hora_bajada'];
$cadena = strtotime($hora_bajada);
$hora_bajada = date("H:i:s", $cadena);

$id_tipopasajero = $_POST['id_tipopasajero'];
$id_colegio = $_POST['id_colegio'];
$id_curso = $_POST['id_curso'];

$pasajero = new Pasajero();
$registrar = $pasajero->registrar($nombre, $direccion, $hora_subida, $hora_bajada, $id_tipopasajero, $id_curso, $id_colegio);

?>