<?php

include 'Sesion/autenticar.php';

require_once("../Modelo/Viaje.php");

require_once("../Modelo/General.php");



$detalle = mb_strtoupper($_POST['detalle']);

$estado = $_POST['estado'];



$viaje = new Viaje();



$busqueda = $viaje->buscarDestinoPorNombre($detalle);

$cant = count($busqueda);



if($cant > 0){



    echo "<script>

    alert('El destino ingresado ya se encuentra registrado en el sistema');

    window.location.href = '../Vista/destino_viaje.php';

    </script>";

    exit;



}



$registrar = $viaje->registrarDestino($detalle,$estado);



if($registrar != 0){

	echo "<script>

    alert('El destino se registro exitosamente');

    window.location.href = '../Vista/destino_viaje.php';

    </script>";

    exit;

} else {

	echo "<script>

    alert('Ocurrio un error al momento del registro, intente nuevamente');

    window.history.back();

    </script>";

    exit;

}

?>