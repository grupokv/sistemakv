<?php 

require_once("../Modelo/EmpresaEnt.php");

$id_empresa = $_GET['id_empresa'];

if (!isset($id_empresa)) {
	echo "<script>
    window.location.href='../vista/empresas.php';
    </script>";
    exit();
} else {
	$datos = explode('_',$id_empresa);
	$id_empresa = $datos[0];
	$opcion = $datos[1];

	if($opcion == 2){
	    $empresa = new Empresa();
	    $bloquear = $empresa->bloquear($id_empresa);
	} else {
	    $empresa = new Empresa();
	    $bloquear = $empresa->desbloquear($id_empresa);
	}
}

 ?>