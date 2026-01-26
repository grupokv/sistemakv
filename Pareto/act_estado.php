<?php
session_start();
require('bd/datos.php');
$querys = new consultas;

$date = date('Y-m-d H:i:s');
$id = $_POST['id'];
$estado = $_POST['estado'];

$actividadid = $querys->actividad_id($_SESSION['idus'],$id);

$sql = "update pareto_actividades set estado = '$estado', fecha_modificacion = '$date' where id = '$id'";
$insert = new base_datos;
$insert->connect();
$insert->query($sql);

if($actividadid[0]['id_padre'] != '0'){
	$cantcerradas = 0;
	
	$idpadre = $actividadid[0]['id_padre'];
	$subactividades = $querys->actividadespadre($idpadre);
	$canttotal = count($subactividades);
	if($canttotal > 0){
	
		foreach($subactividades as $sub){
			if($sub['estado'] == 1){
				$cantcerradas = $cantcerradas + 1;
			}
		}
	}
	
	if($cantcerradas == $canttotal){
		$sql = "update pareto_actividades set estado = '1', fecha_modificacion = '$date' where id = '$idpadre'";
		$insert = new base_datos;
		$insert->connect();
		$insert->query($sql);
	} else { 
		$sql = "update pareto_actividades set estado = '0', fecha_modificacion = '$date' where id = '$idpadre'";
		$insert = new base_datos;
		$insert->connect();
		$insert->query($sql);
	}
}
?>