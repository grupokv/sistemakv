<?php 
session_start();
date_default_timezone_set('America/Bogota');

if ($_SESSION['id_user'] == '') {
	header("Location: ../Controlador/Sesion/CotizadorSalir.php");
}
?>