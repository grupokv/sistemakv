<?php 

require_once("../Modelo/Pasajero.php");

$id_pasajero = $_GET['id_pasajero'];

if (!isset($id_pasajero)) {
	echo "<script>
    window.location.href='../vista/pasajeros.php';
    </script>";
    exit();
}else{

   $datos = explode('_', $id_pasajero);
   $id_pasajero = $datos[0];
   $opcion = $datos[1];


	if($opcion == 2){
		$pasajero = new Pasajero();
		$bloquear = $pasajero->bloquear($id_pasajero);
	} else {
		$pasajero = new Pasajero();
		$desbloquear = $pasajero->desbloquear($id_pasajero);
	}
}


?>
