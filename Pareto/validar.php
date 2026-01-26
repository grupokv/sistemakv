<?php
session_start();
date_default_timezone_set('America/Bogota');
include("bd/conexion.php");

$us = $_POST["user"];
$ps = $_POST["pass"];

if (($us != "") and ($ps != ""))
{
	$usuarios = array();
	$cons = new base_datos;
	$cons->connect();
	$sql = "Select * from usuario where cedula = '$us' and password = '$ps'";
	$res = $cons->query($sql);
	while($item = $cons->fetch_row($res))	{
		array_push($usuarios,$item);
	}
	$cant = count($usuarios);
	
	if($cant < 1)	{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		alert('Los datos ingresados no son correctos');
		window.location.href='index.php';
		</SCRIPT>");
	} else {
		
		$hoy = date('Y-m-d H:i:s');
		$sql = "update usuario set ultimo_ingreso = '$hoy' where cedula = '$us' and password = '$ps'";
		$insert = new base_datos;
		$insert->connect();
		$insert->query($sql);
		
		$_SESSION["user"] = $us;
		$_SESSION["pass"] = $ps;
		$_SESSION["nombre"] = $usuarios[0]['nombre'];
		$_SESSION["idus"] = $usuarios[0]['id'];
		$_SESSION["idcargo"] = $usuarios[0]['id_cargo'];
		$_SESSION["perfil"] = $usuarios[0]['id_perfil'];
		$_SESSION["area"] = $usuarios[0]['id_area'];
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.location.href='opciones.php';
		</SCRIPT>");
	}
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
		alert('Los datos son obligatorios');
		window.location.href='index.php';
		</SCRIPT>");	
}
?>