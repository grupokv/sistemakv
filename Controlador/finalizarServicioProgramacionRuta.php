<?php  
require_once ("../Modelo/Programacion.php");


$id_programacion = $_POST['id_programacion'];


$programacion = new Programacion();
$finalizarServicio = $programacion->finalizarServicioProgramacion($id_programacion);

echo $finalizarServicio;

?>