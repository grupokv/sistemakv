<?php 

//include ("Sesion/autenticar.php");
require_once("../Modelo/Cotizador.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$galon = $_POST['galon'];
$alimentacion = $_POST['alimentacion'];
$hospedaje = $_POST['hospedaje'];
$utilidad = ($_POST['utilidad'] + 100);

$cotizacion = new Cotizador();
$actualizar = $cotizacion->actualizarConceptosGenerales($id, $galon, $alimentacion, $hospedaje, $utilidad);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Parametros Actualizados');
    window.location.href='../Vista/adminConceptosCotizacion.php';
    </script>");

?>