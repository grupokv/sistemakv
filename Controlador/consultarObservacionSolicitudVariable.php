<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

$id_servicio = $_POST['id_servicio'];
$listarServiciosVariablesID = $programacion->listarServiciosVariablesID($id_servicio);

$html = '';

if (count($listarServiciosVariablesID) > 0) {
    $html .= '<label><strong>OBSERVACIÓN</strong></label>';
	$html .= '<textarea class="form-control" name="obsEstado" id="obsEstado" style="border-style:dashed; color:#878787; background: #fff;" readonly="true">' . mb_strtoupper($listarServiciosVariablesID[0]['obsEstado'],'utf-8') .'</textarea>';
}

echo $html;


?>