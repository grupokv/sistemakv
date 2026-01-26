<?php
require_once "../Modelo/Encuesta.php";

$id = $_POST['id'];

$encuesta = new Encuesta();

$preguntas = $encuesta->listarPreguntasPorIdEncuesta($id);
$cant = count($preguntas);
$datos = $encuesta->listarPorId($id);

$html = '<table width="100%">';
$html .= '<tr><td colpan="2" align="center"><b>'.$datos[0]['nombre_encuesta'].'</b></td></tr>';
if($datos[0]['descripcion'] != ''){
$html .= '<tr><td colspan="2" align="center">'.$datos[0]['descripcion'].'</td></tr>';
}
$html .= '<tr><td colspan="2" height="8px"></td></tr>';
if($cant > 0){
	foreach($preguntas as $preg){
	$html .= '<tr>';
	$html .= '<td colspan="2" align="center"><b><i>'.$preg['detalle'].'</i></b></td>';
	$html .= '</tr>';
	
	$respuestas = $encuesta->listarRespuestasPorIdPregunta($preg['id_pregunta']);
	$cant1 = count($respuestas);
	
	//RESPUESTAS//
	if($preg['id_tipo_pregunta'] == '1'){
		if($cant1 > 0){
			foreach($respuestas as $resp){
			$html .= '<tr>';
			$html .= '<td>'.$resp['detalle'].'</td>';
			$html .= '<td><input type="checkbox"></td>';
			$html .= '</tr>';
			}
		} else {
			$html .= '<tr><td colspan="2" align="center">NO EXISTEN RESPUESTAS</td></tr>';
		}
	} else if($preg['id_tipo_pregunta'] == '2'){
		if($cant1 > 0){
			foreach($respuestas as $resp){
			$html .= '<tr>';
			$html .= '<td>'.$resp['detalle'].'</td>';
			$html .= '<td><input type="radio" name="1"></td>';
			$html .= '</tr>';
			}
		} else {
			$html .= '<tr><td colspan="2" align="center">NO EXISTEN RESPUESTAS</td></tr>';
		}
	} else if($preg['id_tipo_pregunta'] == '3'){
		
			$html .= '<tr>';
			$html .= '<td colspan="2"><textarea style="width:100%;height:50px"></textarea></td>';
			$html .= '</tr>';

	} else if($preg['id_tipo_pregunta'] == '4'){
		if($cant1 > 0){
			foreach($respuestas as $resp){
			$html .= '<tr>';
			$html .= '<td>'.$resp['detalle'].'</td>';
			$html .= '<td><input type="checkbox" name="1"></td>';
			$html .= '</tr>';
				if($resp['ampliacion'] == 'S'){
				$html .= '<tr>';
				$html .= '<td colspan="2"><textarea style="width:100%;height:50px"></textarea></td>';
				$html .= '</tr>';
				}
			}
		} else {
			$html .= '<tr><td colspan="2" align="center">NO EXISTEN RESPUESTAS</td></tr>';
		}
	} else if($preg['id_tipo_pregunta'] == '5'){
		if($cant1 > 0){
			foreach($respuestas as $resp){
			$html .= '<tr>';
			$html .= '<td>'.$resp['detalle'].'</td>';
			$html .= '<td><input type="radio" name="1"></td>';
			$html .= '</tr>';
				if($resp['ampliacion'] == 'S'){
				$html .= '<tr>';
				$html .= '<td colspan="2"><textarea style="width:100%;height:50px"></textarea></td>';
				$html .= '</tr>';
				}
			}
		} else {
			$html .= '<tr><td colspan="2" align="center">NO EXISTEN RESPUESTAS</td></tr>';
		}
	} else if($preg['id_tipo_pregunta'] == '6'){
		
			$html .= '<tr>';
			$html .= '<td colspan="2"><input type="file" style="width:100%" /></td>';
			$html .= '</tr>';
		
	}
	//FIN RESPUESTAS//
	$html .= '<tr><td colspan="2" height="8px"></td></tr>';
	}	
} else {
	$html .= '<tr><td colspan="2" align="center">NO EXISTEN PREGUNTAS</td></tr>';
}
$html .= '</table>';

echo $html;
?>