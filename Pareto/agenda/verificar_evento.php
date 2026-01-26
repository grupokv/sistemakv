<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='../index.php';
	</SCRIPT>");
}
$fechahoy = date('Y-m-d H:i:s');
require('../bd/datos.php');
$querys = new consultas;

$idactividad = $_POST['id'];
$eventos = array();
$sqlU = "SELECT * FROM pareto_actividades WHERE id = '$idactividad'";
$consU = new base_datos;
$consU->connect();
$resU = $consU->query($sqlU);
while($itemU = $consU->fetch_row($resU))	{
	array_push($eventos,$itemU);
}
$fechaactividad = $eventos[0]['fecha'];

if ($fechahoy < $fechaactividad) {
	echo '1';
} else {
	echo '0';
}
?>