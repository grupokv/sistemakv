<?php 

$cantidad_descuentos = $_POST['cantidad_descuentos'];


$html = '';

$html .= '<thead>';
	$html .= '<tr>';
		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Detalle del Descuento';
		$html .= '</th>';

		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Valor del descuento';
		$html .= '</th>';

		$html .= '<th style="border: hidden;" class="text-center">';
			$html .= 'Fecha';
		$html .= '</th>';
	$html .= '</tr>';
$html .= '</thead>';


$html .= '<tbody>';

	for($i=1; $i<= $cantidad_descuentos;$i++){

		$html .= '<tr>';
			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<div class="row">';
					$html .= '<span class="fa fa-pencil-square-o  mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>';
					$html .= '<input class="form-control col-9" type="text" name="detalle_descuento[]"/>';
				$html .= '</div>';
			$html .= '</td>';

			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<input class="form-control col-12" type="text" name="valor_descuento[]"/>';
			$html .= '</td>';

			$html .= '<td style="border: hidden; padding: 4px;">';
				$html .= '<input class="form-control col-12" type="text" id="datepicker'.$i.'" name="fecha[]"/>';
			$html .= '</td>';	

		$html .= '</tr>';
	}

$html .= '</tbody>';

$html .= ' <script type="text/javascript">';

 	$html .= '  $( function() {';
 		for($i=1; $i<= $cantidad_descuentos;$i++){
           	$html .= '$( "#datepicker'.$i.'" ).datepicker({ dateFormat: "yy-mm-dd", });';
         }
    $html .='} );';
$html .= ' </script>';

echo $html;

 ?>