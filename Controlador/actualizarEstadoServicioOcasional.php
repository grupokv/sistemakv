<?php
include ('Sesion/CerrarSesion.php');
require_once("../Modelo/ServicioOcasional.php");

if (!isset($_POST['id_servicio_ocasional']) || !isset($_POST['estadoReserva'])) {
    echo "<script>alert('Datos incompletos para actualizar el estado'); window.history.back();</script>";
    exit;
}

$id_servicio_ocasional = $_POST['id_servicio_ocasional'];
$estado = $_POST['estadoReserva'];

if (($estado != 'F') && ($estado != 'C')) {
    echo "<script>alert('Estado no permitido'); window.history.back();</script>";
    exit;
}

$servicioOcasional = new ServicioOcasional();
$servicioOcasional->actualizarEstadoServicioOcasional($id_servicio_ocasional, $estado);

echo "<script>alert('Estado de la reserva actualizado correctamente'); window.location.href='../Vista/serviciosOcasionales.php';</script>";