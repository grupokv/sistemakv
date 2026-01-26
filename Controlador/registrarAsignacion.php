<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/Programacion.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Contrato.php");

date_default_timezone_set('America/Bogota');

$id_servicio = $_POST['id_servicio'];
$id_contrato = $_POST['id_contrato'];
$id_proyecto = $_POST['id_proyecto'];
$id_tarifa_proyecto = $_POST['id_tarifa_proyecto'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];
$costo = str_replace(',','',$_POST['costo_servicio']);
$fecha_asignacion = date('Y-m-d H:i:s');
$tipo = 'D';

$programacion = new Programacion();
$contrato = new Contrato();

$resultado1 = $programacion->registrarAsignacion($id_servicio, $id_contrato, $id_proyecto, $id_tarifa_proyecto, $id_vehiculo, $id_conductor, 'A', $fecha_asignacion, $tipo, $costo);
$cambiarEstadoAsignadoServicio = $programacion->cambiarEstadoServicioAsignado($id_servicio);


$listarIdTarifas = $contrato->listarIdTarifas($id_tarifa_proyecto);

    
    if($listarIdTarifas[0]['tiempo_cobro'] == 'M'){
        $valorServicio = round($listarIdTarifas[0]['costo_servicio'] / 30);
    }else{
        $valorServicio = $listarIdTarifas[0]['costo_servicio'];
    }
    
    $cambiarValorServicio = $programacion->cambiarValorServicio($id_servicio, $valorServicio);
    

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Asignacion de Vehiculo Realizada');
    window.location.href='../Vista/asignaciones.php';
    </script>");


?>