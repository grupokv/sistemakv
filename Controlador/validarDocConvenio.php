<?php  

include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Convenio.php");

$convenio = new Convenio();

$id_convenio = $_POST['id_convenio'];

if ($id_convenio != "") {

	$listarConvenioId = $convenio->listarId($id_convenio);

	if ($listarConvenioId[0]['doc_convenio'] == '') {
		echo 1;
	}else{
		echo 0;
	}
}else{
	echo 0;
}

?>