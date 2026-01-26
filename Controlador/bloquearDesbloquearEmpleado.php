<?php
require_once("../Modelo/Empleado.php");

$empleado = new Empleado();
$id = $_GET['id'];

if (!isset($id)) {
	echo "<script>window.location.href='../vista/empleados.php';</script>";
    exit();
}else{
	$datos = explode('_', $id);
    $id = $datos[0];
    $opcion = $datos[1];

    if($opcion == 2){
		$bloquear = $empleado->bloquear($id);
	} else {
		$empleado = new Empleado();
		$desbloquear = $empleado->desbloquear($id);
	}
}


?>
