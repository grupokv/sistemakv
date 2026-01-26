<?php 

require_once("../Modelo/ProveedorMantenimiento.php");

$id = $_GET['id'];

if (!isset($id)) {
	echo "<script>
    window.location.href='../vista/proveedores_mantenimiento.php';
    </script>";
    exit();
} else {
	$datos = explode('_',$id);
	$id = $datos[0];
	$opcion = $datos[1];

	if($opcion == 1){
	    $empresa = new ProveedorMantenimiento();
	    $bloquear = $empresa->bloquear($id);
	} else {
	    $empresa = new ProveedorMantenimiento();
	    $bloquear = $empresa->desbloquear($id);
	}
}

 ?>