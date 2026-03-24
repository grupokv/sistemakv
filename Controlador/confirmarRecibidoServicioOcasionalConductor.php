<?php
include("Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");

$id_servicio_ocasional = isset($_POST['id_servicio_ocasional']) ? (int)$_POST['id_servicio_ocasional'] : 0;
$decision = isset($_POST['decision']) ? strtoupper(trim($_POST['decision'])) : '';

if ($id_servicio_ocasional <= 0 || ($decision !== 'CONFIRMAR' && $decision !== 'NO_CONFIRMAR')) {
    echo "<script>alert('Datos incompletos para confirmar el recibido.');window.history.back();</script>";
    exit;
}

$servicio = new ServicioOcasional();
$ok = $servicio->guardarConfirmacionConductorRecibido($id_servicio_ocasional, (int)$_SESSION['id_usuario'], $decision === 'CONFIRMAR' ? 1 : 0);

if (!$ok) {
    echo "<script>alert('No fue posible guardar la confirmación.');window.history.back();</script>";
    exit;
}

header('Location: ../Vista/serviciosOcasionalesAsignadosaConductor.php');
exit;