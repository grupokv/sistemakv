<?php 
require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_agenda = $_POST['id_tema'];

$listarAgendas = $acta->listarTemaId($id_agenda);


if (count($listarAgendas) > 0) {
	$html = '';
	foreach ($listarAgendas as $la) {
		
		$html .= '<div class="row mt-3" id="update">';
			$html .= '<div class="label">';
				$html .= '<label>Tema a tratar</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
				$html .= '<input type="text" name="nombre_tema_act"  id="nombre_tema_act" class="form-control form-control-sm" value="'. $la['nombre_tema'] .'">';
			$html .= '</div>  ';    		
		$html .= '</div>';

		$html .= '<div class="row mt-3" id="update1">';
			$html .= '<div class="label">';
				$html .= '<label>Descripción</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
				$html .= '<textarea name="descripcion_tema_act" id="descripcion_tema_act" class="form-control form-control-sm">'. $la['descripcion_tema'] .'</textarea>';
			$html .= '</div>  ';    		
		$html .= '</div>';
	}
}




echo $html;

 ?>