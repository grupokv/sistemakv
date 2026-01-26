<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_servicio = $_POST['id_servicio'];
$id_cliente = $_POST['id_cliente'];
$id_contrato = $_POST['id_contrato'];
$id_producto = $_POST['id_producto'];
$division_cliente = strtoupper($_POST['division_cliente']);
$tipo_servicio = $_POST['tipo_servicio'];
$grupo = strtoupper($_POST['grupo']);
$solicitante = strtoupper($_POST['solicitante']);
$fecha_inicio = $_POST['fecha_inicial'];
$hora_inicio = $_POST['hora_inicial'];
$origen = strtoupper($_POST['origen']);
$destino = strtoupper($_POST['destino']);
$fecha_final = $_POST['fecha_final'];
$hora_final = $_POST['hora_final'];
$observaciones = strtoupper($_POST['observaciones']);
$requisitos = strtoupper($_POST['requisitos']);

$listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($id_servicio);

$entradaVeh = 0;
$salidaVeh = 0;

for ($i=0; $i < count($_POST['id_vehiculo_entrada']); $i++) { 
	//echo $_POST['id_vehiculo_entrada'][$i];
	if($_POST['id_vehiculo_entrada'][$i] != ""){
		$entradaVeh++;
	}
}

for ($i=0; $i < count($_POST['id_vehiculo_salida']); $i++) { 
	//echo $_POST['id_vehiculo_salida'][$i];
	if($_POST['id_vehiculo_salida'][$i] != ""){
		$salidaVeh++;
	}
}

$registroAsignacionVeh = $_POST['registroAsignacionVeh'];

if((count($registroAsignacionVeh) > 0) && ($entradaVeh != 0 || $salidaVeh != 0)){
	$estado = 'A';
}else{
	$estado = 'PA';

}

/* ----------------------------------------------------------*/
/* --------------- ACTUALIZAR SERVICIO ----------------------*/
/* ----------------------------------------------------------*/

$actualizarServicio = $operativo->actualizarServicio($id_servicio, $id_cliente, $id_contrato, $id_producto, $division_cliente, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado);

/* ----------------------------------------------------------*/
/* --------------- ELIMINAR VEHICULOS SERVICIO ---------------*/
/* ----------------------------------------------------------*/

if (count($listarVehiculosPorServicioID) > 0) {
	$eliminarVehiculosServicio = $operativo->eliminarVehiculosServicio($id_servicio);
}

/* ----------------------------------------------------------*/
/* --------------- REGISTRO VEHICULO SERVICIO ---------------*/
/* ----------------------------------------------------------*/

if(count($registroAsignacionVeh) > 0){
	for ($i=0; $i < count($_POST['registroAsignacionVeh']); $i++) { 

		if (($_POST['id_tv_cliente_entrada'][$i] != '') || ($_POST['id_tv_movil_entrada'][$i] != '')) {
			$entrada = 1;
		}else{
			$entrada = 0;
		}

		if (($_POST['id_tv_cliente_salida'][$i] != '') || ($_POST['id_tv_movil_salida'][$i] != '')) {
			$salida = 1;
		}else{
			$salida = 0;
		}


		$servicio = [
						'entrada' => $entrada,
						'salida' => $salida,
					];

		$clase_veh = [
						'entrada' => [
							'cliente' => $_POST['id_tv_cliente_entrada'][$i],
							'movil' => $_POST['id_tv_movil_entrada'][$i],
						],
						'salida' => [
							'cliente' => $_POST['id_tv_cliente_salida'][$i],
							'movil' => $_POST['id_tv_movil_salida'][$i],
						]
					];

		$id_veh = [
					'entrada' => $_POST['id_vehiculo_entrada'][$i],
					'salida' => $_POST['id_vehiculo_salida'][$i],
				];


		$id_cond = [
					'entrada' => $_POST['id_conductor_entrada'][$i],
					'salida' => $_POST['id_conductor_salida'][$i],
				];

		$id_veh_relevo = [
					'entrada' => $_POST['id_veh_relevo_entrada'][$i],
					'salida' => $_POST['id_veh_relevo_salida'][$i],
				];

		$cant_pax = [
					'entrada' => $_POST['cant_pax_entrada'][$i],
					'salida' => $_POST['cant_pax_salida'][$i],
				];

		$kms = [
					'entrada' => $_POST['kms_entrada'][$i],
					'salida' => $_POST['kms_salida'][$i],
				];

		$descuentoClienteEntrada = (($_POST['valor_cliente_entrada'][$i] * $_POST['descuento_cliente_entrada'][$i]) / 100);
		$descuentoClienteSalida = (($_POST['valor_cliente_salida'][$i] * $_POST['descuento_cliente_salida'][$i]) / 100);

		$val_cliente = [
					'entrada' => ($_POST['valor_cliente_entrada'][$i] - $descuentoClienteEntrada),
					'salida' => ($_POST['valor_cliente_salida'][$i] - $descuentoClienteSalida),
				];

		$descuento_cliente = [
					'entrada' => $_POST['descuento_cliente_entrada'][$i],
					'salida' => $_POST['descuento_cliente_salida'][$i],
				];


		$descuentoMovilEntrada = (($_POST['valor_movil_entrada'][$i] * $_POST['descuento_movil_entrada'][$i]) / 100);
		$descuentoMovilSalida = (($_POST['valor_movil_salida'][$i] * $_POST['descuento_movil_salida'][$i]) / 100);
		
		$val_movil = [
					'entrada' => ($_POST['valor_movil_entrada'][$i] - $descuentoMovilEntrada),
					'salida' => ($_POST['valor_movil_salida'][$i] - $descuentoMovilSalida),
				];

		$descuento_movil = [
					'entrada' => $_POST['descuento_movil_entrada'][$i],
					'salida' => $_POST['descuento_movil_salida'][$i],
				];

		$disp = [
					'entrada' => $_POST['identificador_entrada'][$i],
					'salida' => $_POST['identificador_salida'][$i],
				];

		$servicioJSON = json_encode($servicio);
		$clase_vehJSON = json_encode($clase_veh);
		$id_vehJSON = json_encode($id_veh);
		$id_condJSON = json_encode($id_cond);
		$id_veh_relevoJSON = json_encode($id_veh_relevo);
		$cant_paxJSON = json_encode($cant_pax);
		$kmsJSON = json_encode($kms);
		$val_clienteJSON = json_encode($val_cliente);
		$descuentoClienteJSON = json_encode($descuento_cliente);
		$val_movilJSON = json_encode($val_movil);
		$descuentoMovilJSON = json_encode($descuento_movil);
		$dispJSON = json_encode($disp);

		$registrarVehiculosServicio = $operativo->registrarVehiculosServicio($id_servicio, $servicioJSON, $clase_vehJSON, $id_vehJSON, $id_condJSON, $id_veh_relevoJSON, $cant_paxJSON, $kmsJSON, $val_clienteJSON, $descuentoClienteJSON, $val_movilJSON, $descuentoMovilJSON, $dispJSON);
		
	}	
}else{
	
	$entrada = 0;
	$salida = 0;
	$servicio = [
					'entrada' => $entrada,
					'salida' => $salida,
				];

	$clase_veh = [
					'entrada' => [
						'cliente' => null,
						'movil' => null,
					],
					'salida' => [
						'cliente' => null,
						'movil' => null,
					]
				];

	$id_veh = [
				'entrada' => null,
				'salida' => null,
			];


	$id_cond = [
				'entrada' => null,
				'salida' => null,
			];

	$id_veh_relevo = [
				'entrada' => null,
				'salida' => null,
			];

	$cant_pax = [
				'entrada' => null,
				'salida' => null,
			];

	$kms = [
				'entrada' => null,
				'salida' => null,
			];

	$val_cliente = [
				'entrada' => null,
				'salida' => null,
			];

	$descuento_cliente = [
				'entrada' => null,
				'salida' => null,
			];

	$val_movil = [
				'entrada' => null,
				'salida' => null,
			];

			
	$descuento_movil = [
					'entrada' => null,
					'salida' => null,
				];
				
	$disp = [
				'entrada' => null,
				'salida' => null,
			];

	$servicioJSON = json_encode($servicio);
	$clase_vehJSON = json_encode($clase_veh);
	$id_vehJSON = json_encode($id_veh);
	$id_condJSON = json_encode($id_cond);
	$id_veh_relevoJSON = json_encode($id_veh_relevo);
	$cant_paxJSON = json_encode($cant_pax);
	$kmsJSON = json_encode($kms);
	$val_clienteJSON = json_encode($val_cliente);
	$descuentoClienteJSON = json_encode($descuento_cliente);
	$val_movilJSON = json_encode($val_movil);
	$descuentoMovilJSON = json_encode($descuento_movil);
	$dispJSON = json_encode($disp);

	$registrarVehiculosServicio = $operativo->registrarVehiculosServicio($id_servicio, $servicioJSON, $clase_vehJSON, $id_vehJSON, $id_condJSON, $id_veh_relevoJSON, $cant_paxJSON, $kmsJSON, $val_clienteJSON, $descuentoClienteJSON, $val_movilJSON, $descuentoMovilJSON, $dispJSON);
	
}


/*--------------- --------------- --------------- */
/*--------------- REPLICAR SERVICIOS ---------------*/
/*--------------- --------------- --------------- */

if ($_POST['fechas_duplicar'] != '') {

	$date1 = new DateTime($_POST['fecha_inicial']);
	$date2 = new DateTime($_POST['fecha_final']);
	
	$diferenciaDias = $date1->diff($date2);
	$fechas_duplicar = $_POST['fechas_duplicar'];

	$fechas_d = explode(", ", $fechas_duplicar);
	$fechas_d = array_unique($fechas_d);

	for ($i=0; $i < count($fechas_d); $i++) { 

		$fecha_inicio = $fechas_d[$i];
		$fecha_final = date("Y-m-d",strtotime($fechas_d[$i] . "+ " . $diferenciaDias->days ." days"));

		$id_usuario_creador = $_SESSION['id_usuario'];
		$fecha_creacion = date("Y-m-d H:i:s");

		/* ----------------------------------------------------------*/
		/* ------------------ REGISTRO SERVICIO -------------------- */
		/* ----------------------------------------------------------*/

		$registrarServicio = $operativo->registrarServicio($id_cliente, $id_contrato, $id_producto, $division_cliente, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado, $id_usuario_creador, $fecha_creacion);

		for ($a=0; $a < $_POST['cant']; $a++) { 

            if (($_POST['id_tv_cliente_entrada'][$a] != '') || ($_POST['id_tv_movil_entrada'][$a] != '')) {
                $entrada = 1;
            }else{
                $entrada = 0;
            }
    
            if (($_POST['id_tv_cliente_salida'][$a] != '') || ($_POST['id_tv_movil_salida'][$a] != '')) {
                $salida = 1;
            }else{
                $salida = 0;
            }
    
    
			$servicio = [
							'entrada' => $entrada,
							'salida' => $salida,
						];

			$clase_veh = [
							'entrada' => [
								'cliente' => $_POST['id_tv_cliente_entrada'][$a],
								'movil' => $_POST['id_tv_movil_entrada'][$a],
							],
							'salida' => [
								'cliente' => $_POST['id_tv_cliente_salida'][$a],
								'movil' => $_POST['id_tv_movil_salida'][$a],
							]
						];

			$id_veh = [
						'entrada' => $_POST['id_vehiculo_entrada'][$a],
						'salida' => $_POST['id_vehiculo_salida'][$a],
					];


			$id_cond = [
						'entrada' => $_POST['id_conductor_entrada'][$a],
						'salida' => $_POST['id_conductor_salida'][$a],
					];

			$id_veh_relevo = [
						'entrada' => $_POST['id_veh_relevo_entrada'][$a],
						'salida' => $_POST['id_veh_relevo_salida'][$a],
					];

			$cant_pax = [
						'entrada' => $_POST['cant_pax_entrada'][$a],
						'salida' => $_POST['cant_pax_salida'][$a],
					];

			$kms = [
						'entrada' => $_POST['kms_entrada'][$a],
						'salida' => $_POST['kms_salida'][$a],
					];

			$descuentoClienteEntrada = (($_POST['valor_cliente_entrada'][$i] * $_POST['descuento_cliente_entrada'][$i]) / 100);
			$descuentoClienteSalida = (($_POST['valor_cliente_salida'][$i] * $_POST['descuento_cliente_salida'][$i]) / 100);
	
			$val_cliente = [
						'entrada' => ($_POST['valor_cliente_entrada'][$i] - $descuentoClienteEntrada),
						'salida' => ($_POST['valor_cliente_salida'][$i] - $descuentoClienteSalida),
					];
	
			$descuento_cliente = [
						'entrada' => $_POST['descuento_cliente_entrada'][$i],
						'salida' => $_POST['descuento_cliente_salida'][$i],
					];
	
	
			$descuentoMovilEntrada = (($_POST['valor_movil_entrada'][$i] * $_POST['descuento_movil_entrada'][$i]) / 100);
			$descuentoMovilSalida = (($_POST['valor_movil_salida'][$i] * $_POST['descuento_movil_salida'][$i]) / 100);
			
			$val_movil = [
						'entrada' => ($_POST['valor_movil_entrada'][$i] - $descuentoMovilEntrada),
						'salida' => ($_POST['valor_movil_salida'][$i] - $descuentoMovilSalida),
					];
	
			$descuento_movil = [
						'entrada' => $_POST['descuento_movil_entrada'][$i],
						'salida' => $_POST['descuento_movil_salida'][$i],
					];
	
			$disp = [
					'entrada' => $_POST['identificador_entrada'][$i],
					'salida' => $_POST['identificador_salida'][$i],
				];
	
			$servicioJSON = json_encode($servicio);
			$clase_vehJSON = json_encode($clase_veh);
			$id_vehJSON = json_encode($id_veh);
			$id_condJSON = json_encode($id_cond);
			$id_veh_relevoJSON = json_encode($id_veh_relevo);
			$cant_paxJSON = json_encode($cant_pax);
			$kmsJSON = json_encode($kms);
			$val_clienteJSON = json_encode($val_cliente);
			$descuentoClienteJSON = json_encode($descuento_cliente);
			$val_movilJSON = json_encode($val_movil);
			$descuentoMovilJSON = json_encode($descuento_movil);
			$dispJSON = json_encode($disp);
	
			$registrarVehiculosServicio = $operativo->registrarVehiculosServicio($registrarServicio, $servicioJSON, $clase_vehJSON, $id_vehJSON, $id_condJSON, $id_veh_relevoJSON, $cant_paxJSON, $kmsJSON, $val_clienteJSON, $descuentoClienteJSON, $val_movilJSON, $descuentoMovilJSON, $dispJSON);
					
        }
	}

}

echo "<script>alert('Se ha actualizado correctamente el servicio.'); window.location.href = '../Vista/actualizarBaseServicio.php?id_servicio=" . $id_servicio ."';</script>";

?>