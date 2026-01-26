<?php
$fecha_inicial = '2020-02-13';
$fecha_final = '2020-03-17';

$lunes = 0;
$martes = 1;
$miercoles = 1;
$jueves = 0;
$viernes = 0;
$sabado = 0;
$domingo = 0;

$dias_array = array();
if($lunes == 1){
	array_push($dias_array,1); 
}
if($martes == 1){
	array_push($dias_array,2); 
}
if($miercoles == 1){
	array_push($dias_array,3); 
}
if($jueves == 1){
	array_push($dias_array,4); 
}
if($viernes == 1){
	array_push($dias_array,5); 
}
if($sabado == 1){
	array_push($dias_array,6); 
}
if($domingo == 1){
	array_push($dias_array,0);
}
$fecha_servicio = $fecha_inicial;
while($fecha_servicio <= $fecha_final){
	$hoy = date("N",strtotime($fecha_servicio));
	if(in_array($hoy,$dias_array)){
		echo $fecha_servicio.'<br/>';
	}
	$fecha_servicio = date("Y-m-d",strtotime($fecha_servicio."+ 1 days"));
}
?>