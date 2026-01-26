<?php 
require_once '../Modelo/Operacion.php';

$operacion = new Operacion();

$nombre_operacion = $_POST['nombre_operacion'];
$descripcion = $_POST['descripcion'];

$registrarOperacion = $operacion->registrarOperacion($nombre_operacion, $descripcion);

header('Location: ../Vista/operaciones.php');

 ?>