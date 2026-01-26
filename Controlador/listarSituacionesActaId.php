<?php 
require_once '../Modelo/Actas.php';
require_once '../Modelo/Usuario.php';

$acta = new Acta();
$usuario = new Usuario();

$id_situacion = $_POST['id_situacion'];

$listarSituacionId = $acta->listarSituacionId($id_situacion);
$listarTodosUsuarios = $usuario->listarUsuariosInternosEmpresa();
$listarEstadoSituacion = $acta->listarEstadoSituacion();
$html = '';

if (count($listarSituacionId) > 0) {
	
	foreach ($listarSituacionId as $lsi) {
		$html .= '<input type="hidden" name="id_situacion" id="id_situacion" value="' . $lsi['id_situacion'] . '">';

		$html .= '<div class="row mt-3" id="update">';
			$html .= '<div class="label">';
				$html .= '<label>Situación - Problema</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
				$html .= '<textarea type="text" name="act_descripcion_situacion"  id="descripcion_situacion" class="form-control form-control-sm">' . $lsi['descripcion_situacion'] .'</textarea>';
			$html .= '</div>';      		
		$html .= '</div>';

		$html .= '<div class="row mt-3" id="update1">';
			$html .= '<div class="label">';
				$html .= '<label>Solución</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
				$html .= '<textarea name="act_solucion_situacion" id="solucion_situacion" class="form-control form-control-sm" required="required">' . $lsi['solucion_situacion'] .'</textarea>';
			$html .= '</div>';      		
		$html .= '</div>';

		$html .= '<div class="row mt-3" id="update2">';
			$html .= '<div class="label">';
					$html .= '<label>Responsable</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
					$html .= '<select  class="form-control form-control-sm" multiple="multiple" id="act_id_responsable" name="act_id_responsable[]">';
			            foreach ($listarTodosUsuarios as $lu){
							$responsables = explode(",", $lsi['id_responsable']);
							for ($i=0; $i < count($responsables); $i++) { 
								if ($responsables[$i] ==  $lu['id_usuario']) {
									$html .= '<option value="' . $lu['id_usuario'] .'" selected="selected">'.$lu['nombre'].'</option>';
								}
							}
							$html .= '<option value="' . $lu['id_usuario'] .'">'.$lu['nombre'].'</option>';
			            }
			        $html .= '</select>'; 
			$html .= '</div>';      		
		$html .= '</div>';
        
        $html .= '<div class="row mt-3" id="update6">';
			$html .= '<div class="label">';
					$html .= '<label>Estado Situacion</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
					$html .= '<select  class="form-control form-control-sm" id="act_estado_situacion" name="act_estado_situacion">';
			            foreach ($listarEstadoSituacion as $est){
							if ($est['id_estado'] == $lsi['estado_solucion']) {
							    $html .= '<option value="'.$est['id_estado'].'" selected="selected">'.$est['detalle'].'</option>';
							} else {
							    $html .= '<option value="'.$est['id_estado'].'">'.$est['detalle'].'</option>';
							}
			            }
			        $html .= '</select>'; 
			$html .= '</div>';      		
		$html .= '</div>';
        
		$html .= '<div class="row mt-3" id="update3">';
				$html .= '<div class="label">';
					$html .= '<label>Reportar a</label>';
				$html .= '</div>';
				$html .= '<div class="input">';
					$html .= '<select class="form-control form-control-sm" id="id_reportar_a" name="act_id_reportar_a">';
			           	foreach ($listarTodosUsuarios as $lu){
			           		if ($lsi['id_reportar_a'] ==  $lu['id_usuario']) {	
			                	$html .= '<option value="' . $lu['id_usuario'].'" selected="selected">'.$lu['nombre'].'</option>';
			                }else{
			                	$html .= '<option value="' . $lu['id_usuario'].'" >'.$lu['nombre'].'</option>';
			                }
			            }
			        $html .= '</select>'; 
				$html .= '</div>';      		
		$html .= '</div>';

		$html .= '<div class="row mt-3" id="update4">';
				$html .= '<div class="label">';
					$html .= '<label>Fecha Limite</label>';
				$html .= '</div>';
				$html .= '<div class="input">';
					$html .= '<input type="date" name="act_fecha_limite"  id="datepicker1" class="form-control form-control-sm" value="' . $lsi['fecha_limite'] .'">';
				$html .= '</div>';      		
		$html .= '</div>';

		$html .= '<div class="row mt-3" id="update5">';
			$html .= '<div class="label">';
				$html .= '<label>Prioridad</label>';
			$html .= '</div>';
			$html .= '<div class="input">';
	
					$html .= '<select name="act_prioridad" id="prioridad" class="form-control form-control-sm">';

						if ($lsi['prioridad'] == 1) {		
							$html .= '<option value="1" selected="selected">BAJA</option>';	
							$html .= '<option value="2">MEDIA</option>';	
							$html .= '<option value="3">ALTA</option>';	
						}	
						if ($lsi['prioridad'] == 2) {	

							$html .= '<option value="1">BAJA</option>';
							$html .= '<option value="2" selected="selected">MEDIA</option>';
							$html .= '<option value="3">ALTA</option>';	
						}
						if ($lsi['prioridad'] == 3) {			
							$html .= '<option value="1">BAJA</option>';
							$html .= '<option value="2">MEDIA</option>';	
							$html .= '<option value="3" selected="selected">ALTA</option>';			
						}	

					$html .= '</select>';

			$html .= '</div> ';     		
		$html .= '</div>';
	}
}

echo $html;

?>