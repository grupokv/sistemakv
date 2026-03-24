<?php
include("Sesion/autenticar.php");
require_once("../Modelo/NotificacionInternaAdministrativo.php");

$idNotificacion = isset($_GET['id_notificacion']) ? (int)$_GET['id_notificacion'] : 0;
if ($idNotificacion <= 0) {
    header('Location: ../Vista/notificacionesInternasAdministrativos.php');
    exit;
}

$model = new NotificacionInternaAdministrativo();
$model->marcarLeida($idNotificacion, (int)$_SESSION['id_usuario']);

header('Location: ../Vista/serviciosOcasionales.php');
exit;