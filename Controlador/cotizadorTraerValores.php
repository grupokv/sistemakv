<?php 
require_once("../Modelo/CotizadorKV.php");
$cotizadorkv = new CotizadorKV();
$html = '';

$destino = $_POST['destino'];
$capacidad = $_POST['capacidad'];

$datos_destino = $cotizadorkv->listarDestinoPorId($destino); 
$datos_adicional = $cotizadorkv->listarValoresIndividualPorCapacidad($capacidad);

if(count($datos_destino) > 0){
    $dias_servicios = $datos_destino[0]['dias_viaje'];
    $kilometros = $datos_destino[0]['kms'];
    $peajes = $datos_destino[0]['cant_peajes'];
    if($capacidad == 4){ $valor_viaje = $datos_destino[0]['valor_4_pax']; }
    else if($capacidad == 19){ $valor_viaje = $datos_destino[0]['valor_19_pax']; }
    else if($capacidad == 24){ $valor_viaje = $datos_destino[0]['valor_24_pax']; }
    else if($capacidad == 30){ $valor_viaje = $datos_destino[0]['valor_30_pax']; }
    else if($capacidad == 40){ $valor_viaje = $datos_destino[0]['valor_40_pax']; }
    else if($capacidad == 45){ $valor_viaje = $datos_destino[0]['valor_45_pax']; }
} else {
    $dias_servicios = "0";
    $kilometros = "0";
    $peajes = "0";
    $valor_viaje = "0";
}

if(count($datos_adicional) > 0){
    $espera_adicional = $datos_adicional[0]['espera'];
    $servicio_adicional = $datos_adicional[0]['servicio'];
} else {
    $espera_adicional = "0";
    $servicio_adicional = "0";
}

$html = $dias_servicios."|".$kilometros."|".$peajes."|".$valor_viaje."|".$espera_adicional."|".$servicio_adicional;
echo $html;
?>