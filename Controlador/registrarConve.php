<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Convenio.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');

$id_empresa = $_POST['id_empresa'];
$fecha_inicio_convenio = $_POST['fecha_inicio_convenio'];
$fecha_final_convenio = $_POST['fecha_final_convenio'];
$id_ciudad = $_POST['id_ciudad'];
$id_vehiculo = $_POST['id_vehiculo'];

for ($i=0; $i < count($_POST['id_conductor']); $i++) { 
	if ($i == (count($_POST['id_conductor']) - 1)) {
		$id_conductor .= $_POST['id_conductor'][$i];
	}else{
		$id_conductor .= $_POST['id_conductor'][$i] . ',';
	}
}

for ($i=0; $i < count($_POST['id_contrato']); $i++) { 
	if ($i == (count($_POST['id_contrato']) - 1)){
		$id_contrato .= $_POST['id_contrato'][$i];
	}else{
		$id_contrato .= $_POST['id_contrato'][$i] . ',';
	}
}

$objeto_contrato_conv = $_POST['objeto_contrato_conv'];
$id_cliente = $_POST['id_cliente'];
$fecha_creacion_convenio = date('Y-m-d');
$hora_creacion_convenio = date('H:i:s');
$id_responsable = $_SESSION['id_usuario'];

$convenio = new Convenio();
$registrarC = $convenio->registrar($id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad,$id_vehiculo, $id_conductor, $id_contrato, $objeto_contrato_conv, $id_cliente, $fecha_creacion_convenio,$hora_creacion_convenio, $id_responsable);

$id_modulo = 21;
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_convenio | id_empresa | fecha_inicio_convenio |fecha_final_convenio | id_ciudad | id_vehiculo | id_conductor | id_contrato | objeto | id_cliente | fecha_creacion_convenio | hora_creacion_convenio | id_responsable';
$valores_antiguos =  '';
$valores_nuevos = $registrarC . ' | '. $id_empresa . ' | '  . $fecha_inicio_convenio . ' | '  . $fecha_final_convenio . ' | '. $id_ciudad . ' | ' .  $id_vehiculo . ' | ' . $id_conductor . ' | ' . $id_contrato . ' | ' . $objeto_contrato_conv . ' | ' . $id_cliente . ' | ' . $fecha_creacion_convenio . ' | '. $hora_creacion_convenio . ' | ' . $id_responsable;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroConvenios = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
header("Location: ../Vista/convenios.php");

?>