<?php
include("Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");

$id_vehiculo = isset($_POST['id_vehiculo']) ? (int)$_POST['id_vehiculo'] : 0;
$servicio = new ServicioOcasional();

$conductores = array();
if ($id_vehiculo > 0) {
    $conductores = $servicio->listarConductoresPorVehiculo($id_vehiculo);
}

header('Content-Type: application/json');
echo json_encode($conductores);