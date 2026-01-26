<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

$id_programacion = $_POST['id_programacion'];

if ($_POST) {
	$codigo_identificativo = $_POST['codigo_identificativo'];
	$fecha = $_POST['fecha'];
	$localidad = $_POST['localidad'];
	$proyecto = $_POST['proyecto'];
	$unidad_operativa = $_POST['unidad_operativa'];
	$horario = $_POST['horario'];
	$entrada_salida = $_POST['entrada_salida'];
	$punto_inicio = strtoupper($_POST['punto_inicio']);
	$punto_final = strtoupper($_POST['punto_final']);

	$frec = $_POST['frecuencia'];

	$frecuencia = '';

	for ($i=0; $i < count($frec); $i++) { 

		if ($i == (count($frec) - 1)){
			$frecuencia .= $frec[$i];
		
		}else{
			$frecuencia .= $frec[$i] . ',';
		}
	}
	
	$observaciones = $_POST['observaciones'];
	$capacidad_servicio = $_POST['capacidad_servicio'];
	$nombre_monitora = strtoupper($_POST['nombre_monitora']);
	$telefono_monitora = $_POST['telefono_monitora'];
	$novedades = $_POST['novedades'];
	$id_vehiculo_facturacion = $_POST['id_vehiculo_facturacion'];
	$id_vehiculo_liquidacion = $_POST['id_vehiculo_liquidacion'];
	$id_conductor = $_POST['id_conductor'];
	$valor_pagar = $_POST['valor_pagar'];
	$valor_pagar_monitora = $_POST['valor_pagar_monitora'];
	$valor_facturar = $_POST['valor_facturar'];	
	$estado = $_POST['estado'];	

	$actualizarServiciosProgramacion = $programacion->actualizarServiciosProgramacion($id_programacion, $fecha, $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $novedades, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar, $estado);

	header("Location: ../Vista/administrarServiciosProgramacion.php");
	
}

?>