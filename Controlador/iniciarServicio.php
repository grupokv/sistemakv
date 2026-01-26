<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
$id = $_POST['servicio_i'];$kms = $_POST['kms_inicial'];$fecha = date('Y-m-d H:i:s');
$programacion = new Programacion();$detalle_servicio = $programacion->listarAsignacionPorId($id);

if (count($detalle_servicio) > 0){
    $actualizar = $programacion->iniciarServicio($id);    $actualizar1 = $programacion->iniciarAsignacion($detalle_servicio[0]['id_asignacion'], $fecha, $kms);
    echo "<script>
    alert('Servicio iniciado correctamente');
    window.location.href = '../Vista/serviciosAsignadosConductor.php';
    </script>";
} else {    echo "<script>    alert('Error al procesar la solicitud');    window.location.href = '../Vista/serviciosAsignadosConductor.php';    </script>";}
?>