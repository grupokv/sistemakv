<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Area.php");

$id_area = $_GET['id_area'];

if (!isset($id_area)) {
	echo "<script>
    window.location.href='../vista/areas.php';
    </script>";
    exit();
} else {
	$datos = explode('_',$id_area);
	$id_area = $datos[0];
	$opcion = $datos[1];

	if($opcion == 2){
	    $area = new Area();
	    $bloquear = $area->bloquear($id_area);
	} else {
		
	    $area = new Area();
	    $desbloquear = $area->desbloquear($id_area);
	}
}

 ?>