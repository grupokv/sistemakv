<?php

$hora = $_POST['hora'];

$html = '<option value="">SELECCIONE HORA FINAL</option>';
$fecha = date("Y-m-d"); 
$rangomin = (30 * 60);//cantidad minutos * 60 segundos;
$hora = date("H:i:s",strtotime($fecha.' '.$hora)+$rangomin); 
$timestamp = strtotime($fecha.' '.$hora)-$rangomin; 
$timestamp_limite = strtotime($fecha.' 23:59:59'); 
while ($timestamp < $timestamp_limite){
	$timestamp += $rangomin; 
	$hora1 = strtoupper(date("H:i:s", $timestamp));
	$hora2 = strtoupper(date("h:i a", $timestamp));
	
	$html .= "<option value=".$hora1.">".$hora2."</option>"; 
} 
echo $html;
?>