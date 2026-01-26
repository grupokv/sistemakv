<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");
require_once("../Modelo/General.php");

$id_empleado = $_POST['id_empleado'];

$empleado = new Empleado();
$listarSSIDEmpleado = $empleado->listarSSIDEmpleado($id_empleado);

$html = '';


if (count($listarSSIDEmpleado) > 0) {
	
	$html .= '<table class="table">';
		$html .= '<thead>';
			$html .= '<tr class="text-center">';
				$html .= '<th style="border: none;">DOC SEGURIDAD SOCIAL</th>';
				$html .= '<th width="150" style="border: none;">FECHA</th>';
			$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
			foreach ($listarSSIDEmpleado as $lsse) {
				$html .= '<tr class="text-center">';
					$html .= '<td style="border: none;">';
						$html .= '<a style="font-size: .9rem;" href="../Documentos/Empleados/SeguridadSocial/' . $lsse['seguridad_social'] . '" target="_blank">SEGURIDAD SOCIAL | '.  $lsse['seguridad_social'] .'</a>';
					$html .= '</td>';

					$html .= '<td style="border: none;">';
						$html .= '<p style="font-size: .9rem;"><strong>' . strtoupper(mes($lsse['mes'])) . '</strong> DE ' . $lsse['anio'] . '</p>';
					$html .= '</td>';
				$html .= '</tr>';
			}
		$html .= '</tbody>';
	$html .= '</table>';

}else{
	$html .= '<div class="text-center" style="font-size: .9rem;">';
		$html .= '<p>ESTE EMPLEADO NO TIENE CARGADO ACTUALMENTE DOCUMENTOS DE SEGURIDAD SOCIAL<p>';
	$html .= '</div>';
}

echo $html;

?>