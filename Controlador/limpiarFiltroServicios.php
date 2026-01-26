<?php 
include ("../Controlador/Sesion/autenticar.php");

unset($_SESSION['filtro_cliente']);
unset($_SESSION['filtro_tipoServicio']);
$fecha = date('Y-m-d', strtotime('Monday this week'));
$_SESSION['filtro_fechaInicial'] = $fecha;
$fecha2 = date('Y-m-d', strtotime('Sunday this week'));
$_SESSION['filtro_fechaFinal'] = $fecha2;
unset($_SESSION['filtro_emisor']);
unset($_SESSION['filtro_vehiculo']);
unset($_SESSION['filtro_conductor']);
unset($_SESSION['filtro_pendienteAsig']);
unset($_SESSION['filtro_producto']);

?>