<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/Viaje.php");
$id = $_POST['id'];
$detalle = mb_strtoupper($_POST['detalle']);
$estado = $_POST['estado'];
$viaje = new Viaje();
$busqueda = $viaje->listarOrigenPorId($id);
$cant = count($busqueda);

if($cant < 1){

    echo "<script>
    alert('Error en la solicitud');
    window.location.href = '../Vista/origen_viaje.php';
    </script>";
    exit;

}

$registrar = $viaje->actualizarOrigen($id,$detalle,$estado);

   echo "<script>
    alert('El origen se actualizo exitosamente');
    window.location.href = '../Vista/origen_viaje.php';
    </script>";
    exit;
?>