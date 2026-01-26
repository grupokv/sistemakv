<?php 

require_once("../Modelo/Empleado.php");

$empleado = new Empleado();

$id = $_GET['id'];

if(!empty($id)){
    $eliminar = $empleado->eliminarSSporID($id);
    
	echo ("<script LANGUAGE='JavaScript'>window.alert('El registro fue eliminado correctamente');window.location.href='../Vista/seguridadSocialEmpleados.php';</script>");
}else{
	echo ("<script LANGUAGE='JavaScript'>window.alert('Error al eliminar el registro.');window.location.href='../Vista/seguridadSocialEmpleados.php';</script>");
}



?>