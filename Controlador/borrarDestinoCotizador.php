<?php 
//include ("Sesion/autenticar.php");
require_once("../Modelo/Cotizador.php");

$id = $_GET['id'];

$cotizacion = new Cotizador();
$actualizar = $cotizacion->borrarDestino($id);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Destino Borrado Correctamente');
    window.location.href='../Vista/adminDestinosCotizacion.php';
    </script>");

?>