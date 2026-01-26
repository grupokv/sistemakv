<?php

$horai = $_POST['hora1'];
$horaf = $_POST['hora2'];

$html = '<option value="">SELECCIONE HORA FINAL</option>';
$fecha = date("Y-m-d"); 
$rangomin = (30 * 60);//cantidad minutos * 60 segundos;
$horai = date("H:i:s",strtotime($fecha.' '.$horai)+$rangomin); 
$timestamp = strtotime($fecha.' '.$horai)-$rangomin; 
$timestamp_limite = strtotime($fecha.' 23:59:59'); 
while ($timestamp < $timestamp_limite){
	$timestamp += $rangomin; 
	$hora1 = strtoupper(date("H:i:s", $timestamp));
	$hora2 = strtoupper(date("h:i a", $timestamp));
	if($hora1 == $horaf){
		$html .= "<option value=".$hora1." selected >".$hora2."</option>";
	} else {
		$html .= "<option value=".$hora1.">".$hora2."</option>"; 
	}
} 
echo $html;
?>