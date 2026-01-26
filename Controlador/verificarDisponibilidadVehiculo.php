<?php 
require_once "../Modelo/Programacion.php";

$id_vehiculo = $_POST['id_vehiculo'];
$id_servicio = $_POST['id_servicio'];

//$id_vehiculo = '275';
//$id_servicio = '2';

$programacion = new Programacion();

$respuesta = 1;

$datos_servicio = $programacion->serviciosPorIdDetalle($id_servicio);
$fecha = $datos_servicio[0]['fecha_servicio'];

$disponibilidad = $programacion->buscarServiciosPorVehiculo($id_vehiculo);
if(count($disponibilidad)>0){
    $servicios = "";
    $a = 1;
    foreach($disponibilidad as $dp){
        if($a == count($disponibilidad)){
            $servicios .= $dp['id_servicio'];
        } else {
            $servicios .= $dp['id_servicio'].',';
        }
        $a++;
    }
} else {
    $respuesta = 2;
}

$busqueda = $programacion->buscarServiciosFecha($servicios,$fecha);
if(count($busqueda)<1){
    $respuesta = 2;
}
echo $respuesta;

?>