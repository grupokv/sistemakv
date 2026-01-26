<?php  
include ('../Controlador/Sesion/autenticar.php');
require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/TipoVehiculo.php');
require_once ('../Modelo/BitacoraTransaccion.php');

$vehiculo = new Vehiculo();
$tipoVehiculo = new TipoVehiculo();
$transacciones = new Transacciones();

$id_usuario = $_POST['id_usuario'];
//$id_usuario = 1938;
$num_paquete = $_POST['num_paq'];
//$num_paquete = 3;

$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($id_usuario);


$html = '';

if (count($buscarVehiculoPorPropietario) > 0) {

	$html .= '<form action="formularioPagos.php" method="POST" onsubmit="return validarForm()">';
	    $html .= '<div class="d-flex justify-content-center">';
	        $html .= '<img width="130px" height="80px;" src="../Resources/img/kingvision_transparente.png">';
	    $html .= '</div>';
	    $html .= '<div class="d-flex justify-content-center">';
	        $html .= '<p id="titleAlertConfirm" style="margin-bottom: 20px; margin-top: 20px;">';
	           $html .= '<strong><i class="fa fa-shopping-cart"></i> CONFIRMAR VEHÍCULO DEL PAQUETE PLUS <i class="fa fa-plus-circle"></i></strong>';
	        $html .= '</p>';
	    $html .= '</div>';

	    $html .= '<section class="row d-flex justify-content-center">';
	        $html .= '<div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-5 col-lg-5" style="background: #f9b434; width: 100%; height: 3px;"></div>';
	        $html .= '<div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-5 col-lg-5" style="background: #4c81a8; width: 100%; height: 3px;"></div>';
	    $html .= '</section>';


	    $html .= '<section id="seleccionVehiculoCompra" class="col-12" style="margin-top: 50px; margin-bottom: 65px;">';
	        $html .= '<label><strong>Vehículo</strong></label>';
	        $html .= '<select class="form-control" id="id_vehiculo" name="id_vehiculo"  data-live-search="true" required>';
	            $html .= '<option value="0">SELECCIONAR</option>'; 
	            foreach ($buscarVehiculoPorPropietario as $bvip){ 
	            	/*echo $bvip['id_vehiculo'];*/
					$validarPaquetesPlusPorVehiculo = $transacciones->validarPaquetesPlusPorVehiculo($bvip['id_vehiculo']);

					$ppVigente = count($validarPaquetesPlusPorVehiculo);

	                $listarPorId = $tipoVehiculo->listarPorId($bvip['id_tipo_vehiculo']);

	                if($num_paquete == 1){
		            	/* VAN - MICRO - CAMPERO -CAMIONETA*/
		                if(($bvip['id_tipo_vehiculo'] == 2) || ($bvip['id_tipo_vehiculo'] == 3) || ($bvip['id_tipo_vehiculo'] == 6) || ($bvip['id_tipo_vehiculo'] == 7) && ($ppVigente == 0)){
							$html .= '<option value="' . $bvip['id_vehiculo'] . '">'. $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] . '</option>';
		                }else if(($bvip['id_tipo_vehiculo'] == 2) || ($bvip['id_tipo_vehiculo'] == 3) || ($bvip['id_tipo_vehiculo'] == 6) || ($bvip['id_tipo_vehiculo'] == 7) && ($ppVigente > 0)){
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '">' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .' - ' . 'Este vehiculo ya cuenta con un paquete vigente.' . '</option>';
		                }else{
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '">' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .' - ' . 'El vehiculo no corresponde al paquete' . '</option>';
		                }
		            }else if($num_paquete == 2){
		            	/* BUSETA*/
		                if(($bvip['id_tipo_vehiculo'] == 5) && ($ppVigente == 0)){
							$html .= '<option value="' . $bvip['id_vehiculo'] . '">'. $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] . '</option>';
		                }else if(($bvip['id_tipo_vehiculo'] == 5) && ($ppVigente > 0)){
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '">' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .' - ' . 'Este vehiculo ya cuenta con un paquete vigente.' . '</option>';
		                }else{
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '">' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .' - ' . 'El vehiculo no corresponde al paquete' . '</option>';
		                }
		            }else if($num_paquete == 3){
		            	/* BUS*/
		            	
		                if(($bvip['id_tipo_vehiculo'] == 4) && ($ppVigente == 0)){
		            	
							$html .= '<option value="' . $bvip['id_vehiculo'] . '">'. $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] . '</option>';
		                }else if(($bvip['id_tipo_vehiculo'] == 4) && ($ppVigente > 0)){
		            	
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '"><strong>' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .'</strong> - ' . 'Este vehiculo ya cuenta con un paquete vigente.' . '</option>';
		                }else{
		            	
		                	$html .= '<option disabled style="color: red;" value="' . $bvip['id_vehiculo'] . '">' . $bvip['placa'] . ' | ' . $listarPorId[0]['nombre_tipo_vehiculo'] .' - ' . 'El vehiculo no corresponde al paquete' . '</option>';
		                }
		            }
	                
	            }
	        $html .= '</select>';

	        $html .= '<div id="descripcionPaquetePlus"></div>';
	        $html .= '<div id="costoPaquetePlus"></div>';
	        $html .= '<div id="referenciaPagoPaquetePlus"></div>';
	        $html .= '<div id="moduloPagoPaquetePlus"><input type="hidden" name="modulo" id="modulo" value="4"></div>';

	    $html .= '</section>';

	    $html .= '<section class="col-12 mt-3 mb-4 d-flex justify-content-center">';
	        $html .= '<button class="btn btn-info">Confirmar <i class="fa fa-check-circle-o"></i></button>';
	    $html .= '</section>';
	$html .= '</form>';

}

echo $html;

?>