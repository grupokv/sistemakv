<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");

$idv = $_POST['idv'];
$colegio = $_POST['colegio'];
$conductor = $_POST['conductor'];
$monitor = $_POST['monitor'];

$vehiculo = new Vehiculo();

$datosActuales = $vehiculo->rutaAsignada($idv);
$cant = count($datosActuales);

if($cant == 0){
    
    $registro = $vehiculo->asignarRuta($idv,$colegio,$conductor,$monitor);
    header("Location: ../Vista/asignar_ruta.php");

} else {
    
    $registro = $vehiculo->actualizarRuta($idv,$colegio,$conductor,$monitor);
    header("Location: ../Vista/asignar_ruta.php");

}

 ?>