<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
include("../Vista/Template/scripts.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Convenio.php");


$id_vehiculo = $_POST["vehiculo"];
$contrato = $_POST["contrato"];
$id_convenio = $_POST['convenio'];
$tipo_extracto = $_POST['tipo_extracto'];

$fuec = new Fuec();
$vehiculo = new Vehiculo();
$Objcontrato = new Contrato();
$convenio = new Convenio();

$fecha = date('Y-m-d H:i:s');
$year = date('Y');
$hoy = date('YmdHis');

$fecha_actual = date('Y-m-d');

$fecha2 = date("Y-m-d",strtotime($fecha_actual."+ 2 month"));

if($_POST['cambiar_fecha'] == 'S'){
    $fecha2 = $_POST['fecha_final'];
}

$contratoid = $Objcontrato->listarId($contrato);
$docsVencidosVehiculo = $vehiculo->listarPorId($id_vehiculo);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($id_vehiculo);

$fecha_final_fuec = $fecha2;

/*LICENCIAS DE CONDUCCIÓN*/
foreach ($listarConductoresPorVehiculo as $lcpv) {
    if ($lcpv['fecha_vencimiento_licencia'] < $fecha_final_fuec) {
        $fecha_final_fuec = $lcpv['fecha_vencimiento_licencia'];
    }
}

/*VENCIMIENTO RP*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_rp'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_rp'];
}

/*VENCIMIENTO TO*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_to'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_to'];
}

/*VENCIMIENTO SOAT*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_soat'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_soat'];    
}

/*VENCIMIENTO RT*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];
}

/*VENCIMIENTO CONTRA*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];
}

/*VENCIMIENTO EXTRA*/
if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
}

/*VENCIMIENTO DISP VELOCIDAD*/
if ($dispositivo_velocidad < $fecha_final_fuec) {
    $fecha_final_fuec = $dispositivo_velocidad;
}

if ($tipo_extracto != '') {
    $listarConvenioId = $convenio->listarId($id_convenio);
    $fecha_final_convenio = $listarConvenioId[0]['fecha_final_convenio'];

    /*VENCIMIENTO CONVENIO*/
    if ($fecha_final_convenio < $fecha_final_fuec) {
        $fecha_final_fuec = $fecha_final_convenio;
    }

}

/*VENCIMIENTO CONTRATO*/
if ($contratoid[0]['fecha_final_contrato'] < $fecha_final_fuec) {
    $fecha_final_fuec = $contratoid[0]['fecha_final_contrato'];
}


echo $fecha_final_fuec;


?>

