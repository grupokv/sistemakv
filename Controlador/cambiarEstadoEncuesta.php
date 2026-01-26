<?php
include ("Sesion/autenticar.php");
require_once '../Modelo/Encuesta.php';

$encuesta = new Encuesta();

$datos = $_GET['id'];
$explode = explode('_',$datos);

$id = $explode[0];
$estado = $explode[1];

if($estado == 2){
	$actualizar = $encuesta->cambiarEstadoEncuesta($id,'0');
} else if ($estado == 1){
	$actualizar = $encuesta->cambiarEstadoEncuesta($id,'1');
}

echo ("<script LANGUAGE='JavaScript'>
    window.location.href='../Vista/encuesta.php';
    </script>");

?>