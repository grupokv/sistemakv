<?php 

require_once("../Modelo/Conductor.php");

$id_conductor = $_GET['id_conductor'];

if (!isset($id_conductor)) {
	echo "<script>
    window.location.href='../vista/conductores.php';
    </script>";
    exit();
}else{

   $datos = explode('_', $id_conductor);
   $id_conductor = $datos[0];
   $opcion = $datos[1];


	if($opcion == 2){
		$conductor = new Conductor();
		$bloquear = $conductor->bloquear($id_conductor);
	} else {
		$conductor = new Conductor();
		$desbloquear = $conductor->desbloquear($id_conductor);
	}
}


?>
