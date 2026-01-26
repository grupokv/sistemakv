<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';

$id_notificacion = $_POST['id_notificacion'];

$listarPersonasContactoNotificaciones = listarPersonasContactoNotificaciones($id_notificacion);

$html = '';

if (count($listarPersonasContactoNotificaciones) > 0) {
 	$html .= '<table class="table" >';
	 	$html .= '<thead>';
	 		$html .= '<tr >';
		 		$html .= '<th style="border: none !important;"></th>';
		 		$html .= '<th style="border: none !important;">NOMBRE PERSONA</th>';
		 		$html .= '<th style="border: none !important;">LUGAR CONTACTO</th>';
		 		$html .= '<th style="border: none !important;">FECHA</th>';
	 		$html .= '</tr>';
	 	$html .= '</thead>';
	 	$html .= '<tbody>';
	 		foreach($listarPersonasContactoNotificaciones As $lpcn){
		 		$html .= '<tr>';
		 			$html .= '<td style="border: none !important;"><i class="fa fa-user-circle" style="font-size:1.8rem; color:#d3d3d3;"></i></td>';
		 			$html .= '<td style="border: none !important;">' . strtoupper($lpcn['nombre_persona']) .'</td>';
		 			$html .= '<td style="border: none !important;">' . strtoupper($lpcn['lugar_contacto']) .'</td>';
		 			$html .= '<td style="border: none !important;">' . $lpcn['fecha_contacto'] .'</td>';
		 		$html .= '</tr>';
	 		}
	 	$html .= '</tbody>';
 	$html .= '</table>';
}else{

$html .= '<div> No hay personas registradas</div>';

}

echo $html;

?>