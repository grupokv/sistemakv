<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';
date_default_timezone_set('America/Bogota');

$id_referenciador = $_POST['id_referenciador'];

if (isset($_SESSION['id_usuario'])) {
	$id_usuario_registro = $_SESSION['id_usuario'];
}else{
	$id_usuario_registro = 0;
}

$departamento = strtoupper($_POST['departamento']);
$ciudad = strtoupper($_POST['ciudad']);
$nombres_apellidos = strtoupper($_POST['nombresApellidos']);
$telefono_celular = $_POST['celular'];
$telefono_fijo = $_POST['tel_fijo'];
$correo_electronico = strtoupper($_POST['email']);

$prop = $_POST['propietario'];
for ($i=0; $i < count($prop) ; $i++) { 
	if ($prop[$i] == 'S') {
		$propietario = $prop[$i];
	}else{
		$propietario = $prop[$i];
	}
}

$tipo_vehiculo = strtoupper($_POST['tipo_vehiculo']);
$otro = strtoupper($_POST['otro']);
$modelo = $_POST['modelo'];
$capacidad = $_POST['capacidad'];
$disponibilidad_horario_inicial = $_POST['disponibilidad_horario_inicial'];
$disponibilidad_horario_final = $_POST['disponibilidad_horario_final'];
$vinculo = $_POST['vinculo'];
$direccion_ubicacion = strtoupper($_POST['direccion_ubicacion']);
$ubicacion = $_POST['ubicacion'];

for ($i=0; $i < count($ubicacion) ; $i++) { 
	if ($ubicacion[$i] == 'NORTE') {
		$ubicacionVehiculo = $ubicacion[$i];
	}else{
		$ubicacionVehiculo = $ubicacion[$i];
	}
}

$envioPapeles = $_POST['envioPapeles'];

for ($i=0; $i < count($envioPapeles) ; $i++) { 
	if ($envioPapeles[$i] == 'SUR') {
		$envio_papeles = $envioPapeles[$i];
	}else{
		$envio_papeles = $envioPapeles[$i];
	}
}

$empresaAfiliada = strtoupper($_POST['empresaAfiliada']);
$status_propuesta = $_POST['status'];
$observaciones = strtoupper($_POST['observaciones']);
$fecha_registro = date('Y-m-d H:i:s');

if ($_POST['tipo_servicio'] == 'T') {

	$transporte_logistica = 'TRANSPORTE';
	$logistica_producto = "";
	$logistica_servicio = "";
	$logistica_ambas_prod = "";
	$logistica_ambas_serv = "";

}else{
	$transporte_logistica = 'LOGISTICA';

	if ($_POST['servicioProductoOfrecer'] == 'P') {
			
		$logistica_producto = $_POST['cual_tipo'];
		$logistica_servicio = "";
		$logistica_ambas_prod = "";
		$logistica_ambas_serv = "";

	}else if ($_POST['servicioProductoOfrecer'] == 'S') {

		$logistica_producto = "";
		$logistica_servicio = $_POST['cual_tipo'];
		$logistica_ambas_prod = "";
		$logistica_ambas_serv = "";


	}else{
		$logistica_producto = "";
		$logistica_servicio = "";
		$logistica_ambas_prod = $_POST['cual_producto'];
		$logistica_ambas_serv = $_POST['cual_servicio'];

	}

}

	$registrarEncuestaDataOperativa = registrarEncuestaDataOperativa($id_referenciador, $id_usuario_registro, $departamento, $ciudad, $nombres_apellidos, $telefono_celular, $telefono_fijo, $correo_electronico, $transporte_logistica, $logistica_producto, $logistica_servicio, $logistica_ambas_prod, $logistica_ambas_serv, $propietario, $tipo_vehiculo, $otro, $modelo, $capacidad, $disponibilidad_horario_inicial, $disponibilidad_horario_final, $vinculo, $empresaAfiliada, $ubicacionVehiculo, $direccion_ubicacion, $envio_papeles, $status_propuesta, $observaciones, $fecha_registro);


include '../Vista/Template/styles.php';

?>
