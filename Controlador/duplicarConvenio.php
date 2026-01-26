<?php 
include 'Sesion/autenticar.php';
require_once("../Modelo/Convenio.php");
require_once("../Modelo/General.php");
date_default_timezone_set('America/Bogota');

$id_convenio = $_POST['id_convenio'];

$convenio = new Convenio();
$listarConvenioID = $convenio->listarId($id_convenio);

$id_empresa = $listarConvenioID[0]['id_empresa'];
$fecha_inicio_convenio = $listarConvenioID[0]['fecha_inicio_convenio'];
$fecha_final_convenio = $listarConvenioID[0]['fecha_final_convenio'];
$id_ciudad = $listarConvenioID[0]['id_ciudad_convenio'];
$id_vehiculo = $_POST['id_vehiculo'];

for ($i=0; $i < count($_POST['id_conductor']); $i++) { 
	if ($i == (count($_POST['id_conductor']) - 1)) {
		$id_conductor .= $_POST['id_conductor'][$i];
	}else{
		$id_conductor .= $_POST['id_conductor'][$i] . ',';
	}
}

$id_contrato = $_POST['id_contrato'];
$objeto_contrato_conv = $_POST['objeto_contrato_conv'];
$id_cliente = $listarConvenioID[0]['id_cliente'];
$fecha_creacion_convenio = date('Y-m-d');
$hora_creacion_convenio = date('H:i:s');
$id_responsable = $_SESSION['id_usuario'];

$registrarC = $convenio->registrar($id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad,$id_vehiculo, $id_conductor, $id_contrato, $objeto_contrato_conv, $id_cliente, $fecha_creacion_convenio,$hora_creacion_convenio, $id_responsable);

header('Location: ../Vista/convenios.php');


?>