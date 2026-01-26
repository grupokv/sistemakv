<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/Viaje.php");

$id_opcion = $_POST['id_opcion'];
$pasajero = $_SESSION['id_usuario'];
$estado = 'A';
$fecha = date('Y-m-d H:i:s');

$viaje = new Viaje();

$busqueda = $viaje->listarOpcionSillaPorId($id_opcion);

$cant = count($busqueda);

if($cant < 1){

    echo "<script>

    alert('Ocurrio un error en el momento de la solicitud');

    window.location.href = '../Vista/consultar_viajes.php';

    </script>";

    exit;

}

$registrar = $viaje->reservarSilla($id_opcion,$pasajero,$estado,$fecha);

	echo "<script>

    alert('Reserva registrada exitosamente');

    window.location.href = '../Vista/inicioPasajeros.php';

    </script>";

    exit;

?>