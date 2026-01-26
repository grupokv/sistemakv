<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/Viaje.php");
$id = $_POST['id'];
$detalle = mb_strtoupper($_POST['detalle']);
$estado = $_POST['estado'];
$viaje = new Viaje();
$busqueda = $viaje->listarDestinoPorId($id);
$cant = count($busqueda);

if($cant < 1){

    echo "<script>
    alert('Error en la solicitud');
    window.location.href = '../Vista/destino_viaje.php';
    </script>";
    exit;

}

$registrar = $viaje->actualizarDestino($id,$detalle,$estado);

   echo "<script>
    alert('El destino se actualizo exitosamente');
    window.location.href = '../Vista/destino_viaje.php';
    </script>";
    exit;
?>