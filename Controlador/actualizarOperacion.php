<?php 
require_once '../Modelo/Operacion.php';

$operacion = new Operacion();

$id_operacion = $_POST['id_operacion'];
$nombre_operacion = $_POST['nombre_operacion'];
$descripcion = $_POST['descripcion'];

$actualizarOperaciones = $operacion->actualizarOperacion($id_operacion, $nombre_operacion, $descripcion);

header('Location: ../Vista/operaciones.php');

 ?>