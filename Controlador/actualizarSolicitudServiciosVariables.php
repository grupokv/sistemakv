<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

$id_servicio = $_POST['id_servicio'];
$id_solicitante = $_POST['id_solicitante'];
$unidad_operativa = $_POST['unidad_operativa'];
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$direccion = $_POST['direccion'];
$lugar_destino = $_POST['lugar_destino'];
$hora_encuentro = $_POST['hora_encuentro'];
$hora_regreso = $_POST['hora_regreso'];
$capacidad = $_POST['capacidad'];
$cant_pax = $_POST['cant_pax'];
$observaciones = $_POST['observaciones'];
$tipo_servicio = $_POST['tipo_servicio'];
$num_buses = $_POST['num_buses'];

$actualizarSolicitudVariables = $programacion->actualizarSolicitudesVariables($id_servicio, $id_solicitante, $unidad_operativa, $fecha_inicial, $fecha_final, $direccion, $lugar_destino, $hora_encuentro, $hora_regreso, $capacidad, $cant_pax, $observaciones, $tipo_servicio, $num_buses);

header("Location: ../Vista/solicitud_servicios_variables.php");

?>