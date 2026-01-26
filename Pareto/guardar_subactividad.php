<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');
$querys = new consultas;
$padre = $_POST['padre'];	
	
$descripc = $_POST['descripcion'];
$tipo = $_POST['tipo'];
$fechap = $_POST['fechap'];
$horai = $_POST['horai'];
$horaf = $_POST['horaf'];
$idusuario = $_SESSION['idus'];

$pareto_act = array();
$cons = new base_datos;
$cons->connect();
$sql = "Select * from pareto_actividades where id = '$padre'";
$res = $cons->query($sql);
while($item = $cons->fetch_row($res))	{
	array_push($pareto_act,$item);
}

$pareto = $pareto_act[0]['id_pareto'];
$hoy = date('Y-m-d H:i:s');
$sql = "insert into pareto_actividades(id_usuario,id_pareto,id_padre,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,fecha_modificacion,activo) values ('$idusuario','$pareto','$padre','$descripc','$tipo','0','$fechap','$horai','$fechap','$horaf','$hoy','$hoy','A')";
$insert = new base_datos;
$insert->connect();
$insert->query($sql);
echo ("<SCRIPT LANGUAGE='JavaScript'>
alert('Actividad Agregada Correctamente');
window.location.href='pareto_activo.php';
</SCRIPT>");

?>