<?php
include("Sesion/autenticar.php");
require_once("../Modelo/NotificacionInternaConductor.php");

$destino = '../Vista/serviciosOcasionalesAsignadosaConductor.php';
$model = new NotificacionInternaConductor();
$conductorSesion = isset($_SESSION['sesion']) ? $model->obtenerConductorPorDocumentoSesion($_SESSION['sesion']) : array();
$idConductor = isset($conductorSesion['id_conductor']) ? (int)$conductorSesion['id_conductor'] : 0;

$idNotificacion = isset($_GET['id_notificacion']) ? (int)$_GET['id_notificacion'] : 0;
if ($idConductor > 0 && $idNotificacion > 0) {
    $model->marcarLeidaConductor($idNotificacion, $idConductor);
}

if (!headers_sent()) {
    header('Location: ' . $destino);
    exit;
}

echo "<script>window.location.href='" . $destino . "';</script>";