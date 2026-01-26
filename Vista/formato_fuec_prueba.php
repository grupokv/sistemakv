<?php
include("../Controlador/Sesion/autenticar.php");
require('../Modelo/Fuec.php');
require('../Modelo/Contrato.php');
require('../Modelo/Vehiculo.php');

$cod = $_GET['id'];
$cod = base64_decode($cod);

$fuec = new Fuec();

$listar = $fuec->listarFuecPorId($cod);

if(count($listar) < 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Se genero un error");'; 
    echo 'window.location.href = "inicio.php";';
    echo '</script>';
}

$vehiculo = new Vehiculo();
$contrato = new Contrato();

$contratoid = $contrato->listarId($listar[0]['id_contrato']);

//sumo 1 mes
$fecha2 = date("Y-m-d",strtotime($listar[0]['fecha_creacion'] . "+ 3 month"));


$docsVencidosVehiculo = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($listar[0]['id_vehiculo']);

//print_r($docsVencidosVehiculo);

$fechaProxima = $fecha2;

/*RP*/

foreach ($listarConductoresPorVehiculo as $lcpv) {
    if ($lcpv['fecha_vencimiento_licencia'] < $fechaProxima) {
        $fechaProxima = $lcpv['fecha_vencimiento_licencia'];
    }
}

if ($docsVencidosVehiculo[0]['fecha_vencimiento_rp'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_rp'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_to'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_to'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_soat'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_soat'];    
}if ($contratoid[0]['fecha_final_contrato'] < $fechaProxima) {
    $fechaProxima = $contratoid[0]['fecha_final_contrato'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
}if ($dispositivo_velocidad < $fechaProxima) {
    $fechaProxima = $dispositivo_velocidad;
}

$fecha_inicial = explode(" ", $listar[0]['fecha_creacion']);

$actualizarFechasFuec = $fuec->actualizarFechas($fecha_inicial[0], $fechaProxima, $cod);

?>