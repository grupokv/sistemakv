<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");

$id = $_POST['servicio_f'];
$kms = $_POST['kms_final'];
$fecha = date('Y-m-d H:i:s');

$programacion = new Programacion();
$detalle_servicio = $programacion->listarAsignacionPorId($id);

if (count($detalle_servicio) > 0){

    $actualizar = $programacion->finalizarServicio($id);
    $actualizar1 = $programacion->finalizarAsignacion($detalle_servicio[0]['id_asignacion'], $fecha, $kms);

    echo '<script>alert("Servicio finalizado correctamente");</script>';

    header('Location: ../Vista/desinfeccion_ind.php?id=' . $id);

} else {

    echo "<script>
    alert('Error al procesar la solicitud');
    window.location.href = '../Vista/serviciosAsignadosConductor.php';
    </script>";

}

?>