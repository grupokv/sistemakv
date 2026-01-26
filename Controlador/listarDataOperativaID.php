<?php  
require_once '../Modelo/General.php';

$id_data_operativa = $_POST['id_data_operativa'];

$listarDataId = listarDataOperativaID($id_data_operativa);

$html = '';

if (count($listarDataId) > 0) {
	
	$html .= '<div class="alert alert-info text-center" role="alert">';
	  	$html .= '<strong>DETALLE DATA OPERATIVA</strong>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-5">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>DEPARTAMENTO</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['departamento']) .'" readonly>';
		$html .= '</div>';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>CIUDAD</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['ciudad']) .'" readonly>';
		$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-2">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>NOMBRE Y APELLIDO</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['nombres_apellidos']) .'" readonly>';
		$html .= '</div>';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>CORREO ELECTRÓNICO</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['correo_electronico']) .'" readonly>';
		$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-2">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>TELÉFONO CELULAR</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['telefono_celular']) .'" readonly>';
		$html .= '</div>';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>TELÉFONO FIJO</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['telefono_fijo']) .'" readonly>';
		$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-2">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			if ($listarDataId[0]['tipo_vehiculo'] != 'OTRO') {
				$html .= '<p><strong>TIPO VEHÍCULO</strong></p>';
				$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['tipo_vehiculo']) .'" readonly>';
			}else{
				$html .= '<div class="row text-center mt-2">';
					$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
						$html .= '<p><strong>TIPO VEHÍCULO</strong></p>';
						$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['tipo_vehiculo']) .'" readonly>';
					$html .= '</div>';
					$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
						$html .= '<p><strong>¿CÚAL?</strong></p>';
						$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['otro']) .'" readonly>';
					$html .= '</div>';
				$html .= '</div>';
			}
			
		$html .= '</div>';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>MODELO</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['modelo']) .'"readonly>';
		$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-2">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>CAPACIDAD</strong></p>';
			$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="' . strtoupper($listarDataId[0]['capacidad']) .'"readonly>';
		$html .= '</div>';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>OBSERVACIONES</strong></p>';
			$html .= '<textarea  class="form-control" style="border-style:dashed; text-align:center; background: #fff;" readonly>' . strtoupper($listarDataId[0]['observaciones']) .'</textarea>';
		$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="row text-center mt-2">';
		$html .= '<div class="col-xs-12 col*sm-12 col-md-6 col-lg-6">';
			$html .= '<p><strong>PROPIETARIO</strong></p>';
			if($listarDataId[0]['propietario'] == 'S'){ 
				$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="SI" readonly>';
			}else{
				$html .= '<input class="form-control" style="border-style:dashed; text-align:center; background: #fff;" value="NO" readonly>';
			}

		$html .= '</div>';
	$html .= '</div>';


}

echo $html;

?>