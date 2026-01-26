<?php 
$cant_personas_contacto = $_POST['cant_personas_contacto'];



$html = '';

if($cant_personas_contacto != 0){

$html .= '<thead>';
	$html .= '<tr style="color:#6c757d;">';
		$html .= '<th style="border: hidden;" class="text-center">Nombres y Apellidos</th>';

		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Lugar de Encuentro';
		$html .= '</th>';

		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Fecha';
		$html .= '</th>';

		$html .= '<th style="border: hidden;" class="text-center"></th>';

	$html .= '</tr>';
$html .= '</thead>';

$html .= '<tbody>';

	for($i=1; $i<= $cant_personas_contacto;$i++){

		$html .= '<tr>';
			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<div class="row">';
					$html .= '<span class="fa fa-user-circle-o mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>';
					$html .= '<input class="form-control col-9" type="text" name="nombre_usuario[]" required placeholder="NOMBRES Y APELLIDOS"/>';
				$html .= '</div>';
			$html .= '</td>';

			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<input class="form-control lugar_encuentro col-12" type="text" name="lugar_encuentro[]" required placeholder="LUGAR" />';
			$html .= '</td>';

			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<input class="fecha_encuentro form-control col-12" type="text" name="fecha_encuentro[]" id="datepicker" required placeholder="fecha" />';
			$html .= '</td>';

		$html .= '</tr>';
	}

$html .= '</tbody>';

	echo $html;
}else{

	echo $html;
}

?>

<script type="text/javascript">
	$('.numero_documento').keypress(function (tecla) {
	  if (tecla.charCode < 48 || tecla.charCode > 57) return false;
	});

	$( function() {
	    $(".fecha_encuentro").datepicker({ dateFormat:'yy-mm-dd'});
	});

</script>
