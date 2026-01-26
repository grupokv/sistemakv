<?php 
session_start();
date_default_timezone_set('America/Bogota');

if (($_SESSION['sesion'] == '') OR ($_SESSION['nombre'] == '')) {
	header("Location: ../Controlador/Sesion/logout.php");
	echo "Tienes que iniciar sesion primero.";
}
?>