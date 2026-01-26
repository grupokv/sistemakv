<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Operativo.php';
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");

$tipoVehiculo = new TipoVehiculo();
$operativo = new Operativo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();

/* ---------------------------- */
/* VALIDAR PERMISOS ESPECIFICOS */
/* ---------------------------- */

$id_usuario = $_SESSION['id_usuario'];
$listarPermisosUsuariosOperativo = $operativo->listarPermisosUsuariosOperativo($id_usuario);

$reportes = $listarPermisosUsuariosOperativo[0]['lectura_reportes'];
$lectura_reportes = explode(",", $reportes);

$consulta = $listarPermisosUsuariosOperativo[0]['consulta'];
$visualizar_valor_cliente = $listarPermisosUsuariosOperativo[0]['valor_cliente'];

/* ---------------------------- */
/* ---------------------------- */

$id_servicio = $_POST['id_servicio'];
$listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($id_servicio);

$valor_cliente = 0;
$valor_movil = 0;

for($i=0; $i < count($listarVehiculosPorServicioID); $i++){
	$val_clienteJSON = json_decode($listarVehiculosPorServicioID[$i]['valor_cliente']);
	$val_movilJSON = json_decode($listarVehiculosPorServicioID[$i]['valor_movil']);

	$valor_cliente += ($val_clienteJSON->{'entrada'} + $val_clienteJSON->{'salida'});
	$valor_movil += ($val_movilJSON->{'entrada'} + $val_movilJSON->{'salida'});
}

/* SERVICIO ID*/
$listarServiciosPorID = $operativo->listarServiciosPorID($id_servicio);

$usuarios = array(1, 2613);

$html = '';

if ($listarServiciosPorID[0]['estado_servicio'] == 'PA') {
	$html .= '<div class="m-0 p-2 text-center">';
		$html .= '<p><i class="fa fa-exclamation-circle mr-2" style="color:red; font-size: 1.5rem;"></i><b>ESTE SERVICIO NO TIENE ASIGNADO UN VEHÍCULO.</b></p>';
	$html .= '</div>';
}else{


	if (count($listarVehiculosPorServicioID) > 0) {

		$html .= '<div class="m-0">';

			if($consulta == 'SACV'){
				$html .= '<section class="row mt-1 d-flex justify-content-center text-center">';
					if($visualizar_valor_cliente == 1){
						$html .= '<div class="col-5">';
							$html .= '<p><b>Total Valor Cliente: $</b> ' . number_format($valor_cliente) . ' <b>COP</b></p>';
						$html .= '</div>';
					}
					$html .= '<div class="col-5">';
						$html .= '<p><b>Total Valor Movil: $</b> ' . number_format($valor_movil) . ' <b>COP</b></p>';
					$html .= '</div>';
				$html .= '</section>';
				
				$html .= '<hr class="m-0">';
			}
			


			$html .= '<section class="row p-2">';
				$html .= '<div class="ml-5" style="width: 18px; height: 18px; background-color: #00fdd9; border:2px solid #00e3c1;"></div><p class="ml-1">Entrada</p>';
				$html .= '<div class="ml-3" style="width: 18px; height: 18px; background-color: #ffff00; border:2px solid #eded00;"></div><p class="ml-1">Salida</p>';
			$html .= '</section>';

			$html .= '<section class="col-12" style="overflow-x: auto;">';
				$html .= '<table class="text-center" style="text-align: center; width:100%;">';
					$html .= '<thead>';
						$html .= '<tr style="color: #fff;">';
							$html .= '<th width="40px;" style="background-color: #274054; border: 3px solid #fff;">#</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">CLASE</th>';
							//$html .= '<th style="background-color: #274054; border: 3px solid #fff;">$</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">PAX</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">KMS</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">VEHÍCULO</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">CONDUCTOR</th>';
							$html .= '<th style="background-color: #274054; border: 3px solid #fff;">RELEVO</th>';
						$html .= '</tr>';
					$html .= '</thead>';

					$html .= '<tbody>';

						for ($i=0; $i < count($listarVehiculosPorServicioID); $i++) { 

							$servicioJSON = json_decode($listarVehiculosPorServicioID[$i]['servicio']);
							$clase_vehJSON = json_decode($listarVehiculosPorServicioID[$i]['clase_vehiculo']);
							$cant_paxJSON = json_decode($listarVehiculosPorServicioID[$i]['cant_pasajeros']);
							$kmsJSON = json_decode($listarVehiculosPorServicioID[$i]['kms']);
							$id_vehJSON = json_decode($listarVehiculosPorServicioID[$i]['id_vehiculo']);
							$id_condJSON = json_decode($listarVehiculosPorServicioID[$i]['id_conductor']);
							$id_vehRelevoJSON = json_decode($listarVehiculosPorServicioID[$i]['id_vehiculo_relevo']);

							$listarClasesMovilEntrada = $operativo->listarClasesMovilClientesID($clase_vehJSON->{'entrada'}->{'cliente'});
							$listarClasesMovilSalida = $operativo->listarClasesMovilClientesID($clase_vehJSON->{'salida'}->{'cliente'});
							$listarTvEntrada = $tipoVehiculo->listarPorId($listarClasesMovilEntrada[0]['id_tipo_vehiculo']);
							$listarTvSalida = $tipoVehiculo->listarPorId($listarClasesMovilSalida[0]['id_tipo_vehiculo']);

							$listarVehiculoEntrada = $vehiculo->listarPorId($id_vehJSON->{'entrada'});
							$listarVehiculoSalida = $vehiculo->listarPorId($id_vehJSON->{'salida'});
							$listarVehiculoRelevoEntrada = $vehiculo->listarPorId($id_vehRelevoJSON->{'entrada'});
							$listarVehiculoRelevoSalida = $vehiculo->listarPorId($id_vehRelevoJSON->{'salida'});
							$listarConductorEntrada = $conductor->listarPorId($id_condJSON->{'entrada'});
							$listarConductorSalida = $conductor->listarPorId($id_condJSON->{'salida'});



							/* ------------------------------- */
							/* ----------- ENTRADA ----------- */
							/* ------------------------------- */

							if ($servicioJSON->{'entrada'} == 1) {
								$html .= '<tr  style="background-color: #00fdd9; color: #4f4f4f;">';
									$html .= '<td rowspan="2" style="background-color: #274054; color: #fff; border: 3px solid #fff;">' . ($i+1) .'</th>';
									$html .= '<td style="border: 3px solid #fff;">' . strtoupper($listarClasesMovilEntrada[0]['clase_movil_producto']) . ' ( ' . $listarTvEntrada[0]['nombre_tipo_vehiculo'] .' )</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $cant_paxJSON->{'entrada'} .'</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $kmsJSON->{'entrada'}  .'</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $listarVehiculoEntrada[0]['placa'] . ' - '. $listarVehiculoEntrada[0]['numero_movil'] . '</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $listarConductorEntrada[0]['nombre_conductor'] . '</th>';
									
									if ($id_vehRelevoJSON->{'entrada'} != 0) {
										$html .= '<td style="border: 3px solid #fff;">' . $listarVehiculoRelevoEntrada[0]['placa'] . ' - '. $listarVehiculoRelevoEntrada[0]['numero_movil'] . '</th>';
									}else{
										$html .= '<td style="border: 3px solid #fff;"> - </th>';
									}
								$html .= '</tr>';
							}else{
								$html .= '<tr  style="background-color: #00fdd9; color: #4f4f4f;">';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
								$html .= '</tr>';
							}

							/* ------------------------------ */
							/* ----------- SALIDA ----------- */
							/* ------------------------------ */

							if ($servicioJSON->{'salida'} == 1) {
								$html .= '<tr style="background-color: #ffff00; color: #4f4f4f;">';
									$html .= '<td style="border: 3px solid #fff;">' . strtoupper($listarClasesMovilSalida[0]['clase_movil_producto']) . ' ( ' . $listarTvSalida[0]['nombre_tipo_vehiculo'] .' )</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $cant_paxJSON->{'salida'} .'</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $kmsJSON->{'salida'}  .'</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $listarVehiculoSalida[0]['placa'] . ' - '. $listarVehiculoSalida[0]['numero_movil'] . '</th>';
									$html .= '<td style="border: 3px solid #fff;">' . $listarConductorSalida[0]['nombre_conductor'] . '</th>';
									
									if ($id_vehRelevoJSON->{'salida'} != 0) {
										$html .= '<td style="border: 3px solid #fff;">' . $listarVehiculoRelevoSalida[0]['placa'] . ' - '. $listarVehiculoRelevoSalida[0]['numero_movil'] . '</th>';
									}else{
										$html .= '<td style="border: 3px solid #fff;"> - </th>';
									}
								$html .= '</tr>';
							}else{
								$html .= '<tr style="background-color: #ffff00; color: #4f4f4f;">';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
									$html .= '<td style="border: 3px solid #fff;"> - </th>';
								$html .= '</tr>';
							}


						}


						$html .= '</tbody>';
								
					$html .= '</table>';
				$html .= '</section>';

				$html .= '<hr class="mt-3">';

				$html .= '<section class="row mt-2">';
					if ($listarServiciosPorID[0]['estado_servicio'] == 'A') {
						$html .= '<div class="ml-5"></div><p class="ml-1">Servicio Activo</p>';
					}else{
						$html .= '<div class="ml-5"></div><p class="ml-1">Servicio Anulado: - Se anula por ' . $listarServiciosPorID[0]['motivo'] . '</p>';
					}
					
				$html .= '</section>';

		 $html .= '</div>';
		
	}

}
 

echo $html;


?>