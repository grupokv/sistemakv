<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");
require_once("../Modelo/General.php");

$nombre = mb_strtoupper($_POST['nombre']);
$descripcion = mb_strtoupper($_POST['descripcion']);
$tipo = $_POST['tipo'];
$estado = $_POST['estado'];
$fecha = date('Y-m-d H:i:s');

$encuesta = new Encuesta();
$registrar = $encuesta->registrar($nombre, $descripcion, $tipo, $estado, $fecha);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Encuesta creada correctamente');
    window.location.href='../Vista/encuesta.php';
    </script>");

?>