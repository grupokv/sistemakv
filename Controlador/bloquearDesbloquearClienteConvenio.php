<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente-Convenio.php");

$id_cliente = $_GET['id_cliente'];

if (!isset($id_cliente)) {
	echo "<script>
    window.location.href='../vista/clientes_convenios.php';
    </script>";
    exit();
}else{

   $datos = explode('_', $id_cliente);
   $id_cliente = $datos[0];
   $opcion = $datos[1];


	if($opcion == 2){
		$cliente = new Cliente_Convenio();
		$bloquear = $cliente->bloquear($id_cliente);
	} else {
		$cliente = new Cliente_Convenio();
		$desbloquear = $cliente->desbloquear($id_cliente);
	}
}


?>
