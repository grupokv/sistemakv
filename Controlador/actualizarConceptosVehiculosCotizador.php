<?php 

//include ("Sesion/autenticar.php");
require_once("../Modelo/Cotizador.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$tipo = $_POST['tipo'];
$rendimiento = $_POST['rendimiento'];
$peaje = $_POST['peaje'];
$parqueadero = $_POST['parqueadero'];
$lavado = $_POST['lavado'];

$cotizacion = new Cotizador();
$actualizar = $cotizacion->actualizarConceptosVehiculo($id, $tipo, $rendimiento, $peaje, $parqueadero, $lavado);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Parametros Actualizados');
    window.location.href='../Vista/adminConceptosVehiculos.php';
    </script>");

?>