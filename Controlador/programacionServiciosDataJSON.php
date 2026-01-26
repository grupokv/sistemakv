<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();
$listar_programacion_servicios = $programacion->listar_programacion_servicios();

echo $listar_programacion_servicios;


?>