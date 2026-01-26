<?php
require_once("../Modelo/Conductor.php");
$vehiculo = new Conductor();
$listarV = $vehiculo->listar();
$ip = 'http://186.155.38.170:91/Conductores/';
$i = 1;
foreach($listarV as $lv){

	$placa = $lv['numero_documento_conductor'];
	$doc = $lv['fotocopia_documento'];
	if($doc != ''){
	$nombre_fichero = $ip.$placa.'/'.$doc;


if ($doc == '')
{

}
else
{
echo $i." - <a href='".$nombre_fichero."' target='_blank'>".$nombre_fichero."</a><br/>";
}


	}	$i++;
	
}
?>