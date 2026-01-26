<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$servicios = $_POST['id_servicios'];
$fechas = explode(", ", $_POST['fechas']);

for ($i=0; $i < count($fechas); $i++) { 

    for ($j=0; $j < count($servicios); $j++) { 
        
        $listarServicioPorID = $operativo->listarServiciosPorID($servicios[$j]);
        $listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($servicios[$j]);
       
        $date1 = new DateTime($listarServicioPorID[0]['fecha_inicio']);
        $date2 = new DateTime($listarServicioPorID[0]['fecha_final']);
        $diferenciaDias = $date1->diff($date2);

        $fecha_inicio = $fechas[$i];
		$fecha_final = date("Y-m-d", strtotime($fechas[$i] . "+ " . $diferenciaDias->days ." days"));
        
        $listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($servicios[$j]);

		$registrarServicio = $operativo->registrarServicio($listarServicioPorID[0]['id_cliente'], $listarServicioPorID[0]['id_contrato'], $listarServicioPorID[0]['id_producto'], $listarServicioPorID[0]['division_cliente'], $listarServicioPorID[0]['tipo_servicio'], $listarServicioPorID[0]['grupo'], $listarServicioPorID[0]['solicitante'], $fecha_inicio, $listarServicioPorID[0]['hora_inicio'], $listarServicioPorID[0]['origen'], $listarServicioPorID[0]['destino'], $fecha_final, $listarServicioPorID[0]['hora_final'], $listarServicioPorID[0]['observaciones'], $listarServicioPorID[0]['requisitos'], $listarServicioPorID[0]['estado_servicio'], $_SESSION['id_usuario'], date('Y-m-d H:i:s'));
        $registrarVehiculosServicio = $operativo->registrarVehiculosServicio($registrarServicio, $listarVehiculosPorServicioID[0]['servicio'], $listarVehiculosPorServicioID[0]['clase_vehiculo'], $listarVehiculosPorServicioID[0]['id_vehiculo'], $listarVehiculosPorServicioID[0]['id_conductor'], $listarVehiculosPorServicioID[0]['id_vehiculo_relevo'], $listarVehiculosPorServicioID[0]['cant_pasajeros'], $listarVehiculosPorServicioID[0]['kms'], $listarVehiculosPorServicioID[0]['valor_cliente'], $listarVehiculosPorServicioID[0]['descuento_cliente'], $listarVehiculosPorServicioID[0]['valor_movil'], $listarVehiculosPorServicioID[0]['descuento_movil'], $listarVehiculosPorServicioID[0]['disp']);
    
    }

}

echo "Servicios replicados correctamente, por favor verifífique la información";



?>
