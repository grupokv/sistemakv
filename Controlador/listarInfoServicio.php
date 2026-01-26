<?php 

require_once '../Modelo/Programacion.php';
require_once '../Modelo/Cliente.php';

$programacion = new Programacion();
$cliente = new Cliente();

$id_servicio = $_POST['id_servicio'];
$listarServiciosPorId = $programacion->listarDetallesServiciosPorId($id_servicio);
$listarClientePorId = $cliente->listarClientePorId($listarServiciosPorId[0]['id_cliente']);

$html = '<div class="row">';
	$html .= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="border-right: 1px solid #ddd;">';
		$html .= '<p style="font-size: .8rem;"><strong>TIPO SERVICIO:</strong><br/>' . $listarServiciosPorId[0]['tipo'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>FECHA SOLICITUD: </strong><br/>' . $listarServiciosPorId[0]['fecha_solicitud'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>FECHA SERVICIO: </strong><br/>' . $listarServiciosPorId[0]['fecha_servicio'] . ' '. $listarServiciosPorId[0]['hora_servicio'].'</p>'.'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>CLIENTE:</strong><br/>' . $listarClientePorId[0]['razon_social'].'</p>';

	$html .= '</div>';

	$html .= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="border-right: 1px solid #ddd;">';
		$html .= '<p style="font-size: .8rem;"><strong>NOMBRE DEL CONTACTO: </strong><br/>' . $listarServiciosPorId[0]['contacto'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>TELEFONO DEL CONTACTO: </strong><br/>' . $listarServiciosPorId[0]['telefono_contacto'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>PERSONAS A TRANSPORTAR (LISTADO): </strong><br/>' . '<a target="_blank" href="../Servicios/' . $listarServiciosPorId[0]['listado'].' ">'. $listarServiciosPorId[0]['listado'] . '</a></p>';

	$html .= '</div>';

	$html .= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="border-right: 1px solid #ddd;">';
		$html .= '<p style="font-size: .8rem;"><strong>ORIGEN: </strong><br/>' . $listarServiciosPorId[0]['origen'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>DESTINO: </strong><br/>' . $listarServiciosPorId[0]['destino'].'</p>';
		$html .= '<p style="font-size: .8rem;"><strong>SOLICITANTE: </strong><br/>' . $listarServiciosPorId[0]['solicitante'].'</p>';
	$html .= '</div>';
$html .= '</div>';
echo $html;
 ?>