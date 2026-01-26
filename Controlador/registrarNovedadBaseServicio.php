<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_servicio = $_POST['id_servicio'];
$tipo_novedad = $_POST['tipo_novedad'];

$listarTipoNovedadesPorId = $operativo->listarTipoNovedadesPorId($tipo_novedad);
$tipo_novedad = substr($listarTipoNovedadesPorId[0]['tipo_novedad'], 0, 1);

if ($tipo_novedad == 'A') {
    $tipo_novedad = 'I';
}

$novedad = strtr(strtoupper($_POST['novedad']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");

$cambiarNovedadServicio = $operativo->cambiarNovedadServicio($id_servicio, $tipo_novedad, $novedad);

echo "<script>alert('Se ha actualizado y registrado correctamente el servicio con la novedad respectiva.'); window.location.href = '../Vista/servicios_activos.php';</script>";

?>