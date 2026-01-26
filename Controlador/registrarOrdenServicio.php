<?php
date_default_timezone_set('America/Bogota');

include ("Sesion/autenticar.php");
include("../Vista/Template/scripts.php");
require_once("../Modelo/OrdenServicio.php");

$orden = new OrdenServicio();

$id_vehiculo = $_POST["vehiculo"];
$empresa = $_POST["id_empresa"];
$tipo_combustible = mb_strtoupper($_POST["tipo_combustible"]);
$proveedor = $_POST["proveedor"];
$tipo_servicio = $_POST["tipo_servicio"];
$cronograma = $_POST["cronograma"];

if ($cronograma == 'S') {
	$solicitado = 'CRONOGRAMA MTO';
}else{
	$solicitado = $_POST['conductor'];
}

$fecha_inicial = $_POST["fecha_inicial"];
$fecha_final = $_POST["fecha_final"];
$observaciones = $_POST["observaciones"];

$usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');

$id = $orden->registrar($empresa,$id_vehiculo,$tipo_combustible,$proveedor,$tipo_servicio,$solicitado,$fecha_inicial,$fecha_final,$observaciones,$fecha, $usuario);
//echo $id;

if(($id != '')&&($id != '0')){
	echo ("<script>
    window.location.href='../Vista/registrarDetalleServicio.php?id=".$id."';
    </script>");
} else {
	echo ("<script>
    window.alert('Ocurrio un error durante el registro por favor intente nuevamente');
    window.location.href='../Vista/ordenes_servicio.php';
    </script>");
}

?>

