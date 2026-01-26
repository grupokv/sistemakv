<?php 

	require_once '../Modelo/Contrato.php';

	$id_contrato = $_POST['id_contrato'];

	$contrato = new Contrato();
	$listarContratPorId = $contrato->listarId($id_contrato);

	$fecha = strtotime('+1 day', strtotime($listarContratPorId[0]['fecha_final_contrato']));
	echo $nuevaFecha = date('Y-m-d', $fecha);

 ?>