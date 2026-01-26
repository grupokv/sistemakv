<?php 

require_once '../Modelo/Pre-operacionales.php';

date_default_timezone_set('America/Bogota');

$preoperacionales = new PreOperacionales();

if ($_GET['opcion'] != '') {
	$valores = explode('_',  $_GET['opcion']);

	$opcion = $valores[0];

	if ($opcion = 1) {
		$id_vehiculo = $valores[1];
		$id_conductor = $valores[2];
		$id_usuario = $valores[3];
	}

} else{
	$id_vehiculo = $_POST['id_vehiculo'];
	$id_conductor = $_POST['id_conductor'];
	$id_usuario = $_POST['id_usuario'];
}

$fecha_creacion = date('Y-m-d H:i:s');

$listarPorIdVehiculoConductorYDia = $preoperacionales->listarPorIdVehiculoConductorYDia($id_vehiculo, $id_conductor, date('Y-m-d'));


if (count($listarPorIdVehiculoConductorYDia) > 0) {
	echo "<script>alert('Ya se registro un preoperacional para este vehiculo.'); window.location.href = '../Vista/preoperacionalInfo.php';</script>";
}else{

$registrar = $preoperacionales->registrar($id_vehiculo, $id_conductor, $id_usuario, $fecha_creacion);
	header('Location: ../Vista/preoperacional_exterior.php?id=' . $registrar);

}


?>