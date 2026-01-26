<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");
$cotizadorkv = new CotizadorKV();
$id_cliente = $_GET['id'];

if (!isset($id_cliente)) {
	echo "<script>
    window.location.href='../Vista/CotizacionAdminDestinos.php';
    </script>";
    exit();
}else{

   $datos = explode('_', $id_cliente);
   $id_cliente = base64_decode($datos[0]);
   $opcion = $datos[1];

	if($opcion == 2){
		$bloquear = $cotizadorkv->bloquear_destino($id_cliente);
	} else {
		$desbloquear = $cotizadorkv->desbloquear_destino($id_cliente);
	}
	echo "<script>
    window.location.href='../Vista/CotizacionAdminDestinos.php';
    </script>";
    exit();
}
?>