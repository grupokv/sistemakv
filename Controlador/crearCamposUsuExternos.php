<?php 
$cantidad_usuarios = $_POST['cantidad_usuarios'];


$html = '';

$html .= '<thead>';
	$html .= '<tr>';
		$html .= '<th style="border: hidden;" class="text-center">Nombres y Apellidos</th>';

		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Numero de Identificación';
		$html .= '</th>';
	$html .= '</tr>';
$html .= '</thead>';

$html .= '<tbody>';

	for($i=1; $i<= $cantidad_usuarios;$i++){

		$html .= '<tr>';
			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<div class="row">';
					$html .= '<span class="fa fa-user-circle-o mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>';
					$html .= '<input class="form-control col-9" type="text" name="nombre_usuario[]"/>';
				$html .= '</div>';
			$html .= '</td>';

			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<input class="form-control col-12" type="text" name="numero_documento[]"/>';
			$html .= '</td>';	
		$html .= '</tr>';
	}

$html .= '</tbody>';
echo $html;

 ?>