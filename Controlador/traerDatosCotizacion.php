<?php 
require("../Modelo/Cotizador.php");

$id_destino = $_POST['id_destino'];
$id_tipo = $_POST['id_tipo'];
$dias_adicionales = $_POST['dias'];
$hospedaje = $_POST['hospedaje'];
$alimentacion = $_POST['alimentacion'];
$lavadas = $_POST['lavadas'];
$parqueadero = $_POST['parqueadero'];

$desc_porc = $_POST['desc_porc'];
$desc_valor = $_POST['desc_valor'];

$costo_conductor = $_POST['costo_conductor'];
if(($costo_conductor == '')or($costo_conductor < 1)){
	$costo_conductor = 1;
}

$cotizacion = new Cotizador();

$datos_generales = $cotizacion->listarDatosGenerales();
$datos_destino = $cotizacion->listarDestinoPorId($id_destino);
$datos_vehiculo = $cotizacion->listarTipoPorId($id_tipo);
$datos_costo = $cotizacion->listarCostoConductorPorId($costo_conductor);

if($id_tipo == 1){
 $valor_fijo = $datos_destino[0]['valor_campero'];
 $valor_peaje = $datos_destino[0]['peaje_campero'];
} else if($id_tipo == 2){
 $valor_fijo = $datos_destino[0]['valor_doblecabina'];
 $valor_peaje = $datos_destino[0]['peaje_doblecabina'];
} else if($id_tipo == 3){
 $valor_fijo = $datos_destino[0]['valor_van'];
 $valor_peaje = $datos_destino[0]['peaje_van'];
} else if($id_tipo == 4){
 $valor_fijo = $datos_destino[0]['valor_microbus'];
 $valor_peaje = $datos_destino[0]['peaje_microbus'];
} else if($id_tipo == 5){
 $valor_fijo = $datos_destino[0]['valor_buseta'];
 $valor_peaje = $datos_destino[0]['peaje_buseta'];
} else if($id_tipo == 6){
 $valor_fijo = $datos_destino[0]['valor_buseton'];
 $valor_peaje = $datos_destino[0]['peaje_buseton'];
} else {
 $valor_fijo = $datos_destino[0]['valor_bus'];
 $valor_peaje = $datos_destino[0]['peaje_bus'];
}


$dias = $datos_destino[0]['dias'] + $dias_adicionales;
$valor_peajes = (($datos_destino[0]['total_peaje_viaje']*2)*$valor_peaje);
$total_combustible = round(($datos_destino[0]['kms_ida_retorno']/$datos_vehiculo[0]['rendimiento_kms'])*$datos_generales[0]['galon_combustible']);
$kms = $datos_destino[0]['kms_ida_retorno'];

$peajes = ($datos_destino[0]['total_peaje_viaje']*2);

if($dias > 1){

  $cant = ($dias - 1);

  if($hospedaje == 'S'){
  	$total_hospedaje = ($cant * $datos_generales[0]['hospedaje_dia']);
  } else {
	$total_hospedaje = 0;
  }
  if($alimentacion == 'S'){
  	$total_alimentacion = ($cant * $datos_generales[0]['alimentacion_dia']);
  } else {
	$total_alimentacion = 0;
  }
  if($parqueadero == 'S'){
    	$total_parqueadero = ($cant * $datos_vehiculo[0]['valor_parqueadero']);
  } else {
	$total_parqueadero = 0;
  }
  $lavado = ($datos_vehiculo[0]['valor_lavado']*$lavadas);

} else {

  $total_hospedaje = 0;
  $total_alimentacion = 0;
  $total_parqueadero = 0;
  $lavado = ($datos_vehiculo[0]['valor_lavado']*$lavadas);

}

$total_gastos = ($valor_peajes + $total_combustible + $lavado + $total_hospedaje + $total_alimentacion + $total_parqueadero);

$total = round(($total_gastos * $datos_generales[0]['porc_pernotado'])/100);

$valor_normal = $valor_fijo + $total_hospedaje + $total_alimentacion + $total_parqueadero + $lavado + $valor_peajes;
if($desc_porc > 0){
	$desc = (($valor_normal * $desc_porc)/100);
	$valor_normal = round($valor_normal- $desc);
} else {
	$valor_normal = round($valor_normal - $desc_valor);
}

$base_costos = round(($valor_normal * $datos_costo[0]['porcentaje_total'])/100);
$total_costo = round(($valor_normal * $datos_costo[0]['porcentaje_pago'])/100);

$html = $datos_destino[0]['dias'].'|'.$total.'|'.$total_costo.'|'.$total_gastos.'|'.$valor_normal.'|'.$kms.'|'.$peajes.'|'.$valor_peaje;

echo $html;

?>