<?php 
require_once '../Modelo/Vehiculo.php';
$veh = new Vehiculo();

$id = $_POST['id'];

$datos = $veh->buscarRecorridoId($id);
$html = '';
$i = 1;
$html .= '<table widht="100%"><th>#</th><th><strong>NOMBRE PASAJERO</strong></th><th><strong>HORA RECOGIDA</strong></th>';
foreach($datos as $dt){
	$datos_pas = $veh->buscarPasajeroFijoPorId($dt['id_pasajero']);
	$hora = date("g:i a",strtotime($dt['hora_recogida']));
	$html .= '<tr><td>'.$i.'</td><td width="80%">'.$datos_pas[0]['nombres'].' '.$datos_pas[0]['apellidos'].'</td>';
	$html .= '<td>'.$hora.'</td></tr>';
	$i++;
}
$html .= '</table>';
echo $html;
 ?>