<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

$id_programacion = $_POST['id_programacion'];

if ($_POST) {
	$localidad = $_POST['localidad'];
	$proyecto = $_POST['proyecto'];
	$codigo_identificativo = $_POST['codigo_identificativo'];
	$unidad_operativa = $_POST['unidad_operativa'];
	$punto_inicio = strtoupper($_POST['punto_inicio']);
	$punto_final = strtoupper($_POST['punto_final']);
	$entrada_salida = $_POST['entrada_salida'];
	$horario = $_POST['horario'];

	$frec = $_POST['frecuencia'];
	//print_r($frec);

	//print_r($frecuencia);
	$frecuencia = '';

	for ($i=0; $i < count($frec); $i++) { 

		if ($i == (count($frec) - 1)){
			$frecuencia .= $frec[$i];
		
		}else{
			$frecuencia .= $frec[$i] . ',';
		}
	}

	if ($_POST['confirmarObservaciones'] == 'S') {
		$observaciones = $_POST['observaciones'];
	}else{
		$observaciones = 'NO HAY OBSERVACIONES';
	}

	$capacidad_servicio = $_POST['capacidad_servicio'];
	$nombre_monitora = strtoupper($_POST['nombre_monitora']);
	$telefono_monitora = $_POST['telefono_monitora'];
	$id_vehiculo_facturacion = $_POST['id_vehiculo_facturacion'];
	$id_vehiculo_liquidacion = $_POST['id_vehiculo_liquidacion'];
	$id_conductor = $_POST['id_conductor'];
	$valor_pagar = $_POST['valor_pagar'];
	$valor_pagar_monitora = $_POST['valor_pagar_monitora'];
	$valor_facturar = $_POST['valor_facturar'];

	$listar_programacion_serviciosID = $programacion->listar_programacion_serviciosID($id_programacion);
	//print_r($listar_programacion_serviciosID);

	$date = date('Y-m-d');
	$buscarProgramacionServiciosFecha = $programacion->buscarProgramacionServiciosFecha($date, $id_programacion);
	//print_r($buscarProgramacionServiciosFecha);
		
		if($listar_programacion_serviciosID[0]['frecuencia'] == $frecuencia){
			
			$actualizarProgramacion = $programacion->actualizarProgramacion($id_programacion, $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar);

			if (count($buscarProgramacionServiciosFecha) > 0) {
				foreach ($buscarProgramacionServiciosFecha as $bpsf) {

					$actualizarServiciosProgramacion = $programacion->actualizarProgramacion($bpsf['id_programacion'], $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar);
				}
			}

		}else{

			$actualizarProgramacion = $programacion->actualizarProgramacion($id_programacion, $localidad, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar);
				//print_r($buscarProgramacionServiciosFecha);


			if (count($buscarProgramacionServiciosFecha) > 0) {

				foreach ($buscarProgramacionServiciosFecha as $bpsf) {
					$eliminarServicioProgramacion = $programacion->eliminarServicioProgramacion($bpsf['id_programacion']);
				}

				for ($i=0; $i < count($frec); $i++) { 

				    if ($frec[$i] == 'LUNES') {
				        $day = 'monday';
				    }else if ($frec[$i] == 'MARTES') {
				        $day = 'tuesday';
				    }else if ($frec[$i] == 'MIERCOLES') {
				        $day = 'wednesday';
				    }else if ($frec[$i] == 'JUEVES') {
				        $day = 'thursday';
				    }else if ($frec[$i] == 'VIERNES') {
				        $day = 'friday';
				    }else if ($frec[$i] == 'SABADO') {
				        $day = 'saturday';
				    }else if ($frec[$i] == 'DOMINGO') {
				        $day = 'sunday';
				    }

				    //echo $day;

				    $diaMes = array();   

				    $primerDía = strtotime("first " . $day ." of " . $mes);
				    $temp = $primerDía;
				    
				    array_push($diaMes, date("Y-m-d", $temp));
				    $ultimoDia = strtotime("last " . $day . " of " . $mes);
				    
				    while($temp != $ultimoDia){
				        
				        $temp = strtotime(date("Y-m-d", $temp) . "+1 week");
				        array_push($diaMes, date("Y-m-d", $temp));

				    }

				    $fechaAnt = array();

					for ($a=0; $a < count($diaMes); $a++) { 
						if (date('Y-m-d') > $diaMes[$a]) {
							array_push($fechaAnt, $diaMes[$a]);
						}
					}

					$diasRestMes = array_diff($diaMes, $fechaAnt);
					$diasRestMes = array_values($diasRestMes);

					//print_r($diasRestMes);

					
					for ($e=0; $e < count($diasRestMes); $e++) { 
						$registrarServiciosProgramacion = $programacion->registrarServiciosProgramacion($diasRestMes[$e], $localidad, $codigo_identificativo, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar, $id_programacion);
					}

					
				}

			}

		}

		

	header("Location: ../Vista/programaciones.php");
	
}

?>