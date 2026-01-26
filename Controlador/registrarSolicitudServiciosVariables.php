<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/Usuario.php");

setlocale(LC_TIME, "spanish");

$programacion = new Programacion();
$usuario = new Usuario();

$id_solicitante = $_POST['id_solicitante'];
$unidad_operativa = mb_strtoupper($_POST['unidad_operativa'],'utf-8');
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$direccion = mb_strtoupper($_POST['direccion'],'utf-8');
$lugar_destino = mb_strtoupper($_POST['lugar_destino'],'utf-8');
$hora_encuentro = $_POST['hora_encuentro'];
$hora_regreso = $_POST['hora_regreso'];
$capacidad = $_POST['capacidad'];
$cant_pax = $_POST['cant_pax'];

if ($_POST['observaciones'] == '') {
	$observaciones = '-';
}else{	
	mb_strtoupper($observaciones = $_POST['observaciones'],'utf-8');
}
$tipo_servicio = $_POST['tipo_servicio'];
$num_buses = $_POST['num_buses'];
$fecha_registro = date('Y-m-d h:i:s');

//$registrarSolicitudesVariables = 1;
$registrarSolicitudesVariables = $programacion->registrarSolicitudesVariables($id_solicitante, $unidad_operativa, $fecha_inicial, $fecha_final, $direccion, $lugar_destino, $hora_encuentro, $hora_regreso, $capacidad, $cant_pax, $observaciones, $tipo_servicio, $num_buses, $fecha_registro);


$firstDate = date('Y-m-d', strtotime($fecha_inicial));
$secondDate = date('Y-m-d', strtotime($fecha_final));

$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

$years  = floor($dateDifference / (365 * 60 * 60 * 24));
$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

$listarUnidadOperativaId = $programacion->listarUnidadOperativaId($unidad_operativa);
$listarTiposServiciosVariablesID = $programacion->listarTiposServiciosVariablesID($tipo_servicio);
$listarUsuarioPorId = $usuario->listarUsuarioPorId($id_solicitante);
//print_r($listarUsuarioPorId);

$message = '<html>';
    $message .= '<head><meta charset="gb18030">';
                    $message .= '<title></title>';
                $message .= '</head>';
        $message = '<body style="margin: 0; padding: 0;">';
            $message .= '<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">';
                $message .= '<tr>';
                    $message .= '<td bgcolor="#1b2d3b" style="padding: 10px 25px 13px 50px;">';
                        $message .= '<img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo King Vision" width="180" height="100" style="display: block;"> ';
                    $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                    $message .= '<td bgcolor="#fcfcfc" style="padding: 10px 10px 40px 30px;">';
                        $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;"><strong>' .strtoupper($listarUsuarioPorId[0]['nombre']). '</strong></p>';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                        $message .= '<tr>';
                                            $message .= '<td>';
                                                $message .= '<p style="margin-left: 18px; font-family: Verdana; font-size: 0.8rem;">' . strtoupper(strftime("%B %d de %Y",strtotime(date("Y-m-d")))) . '</p>';
                                            $message .= '</td>';
                                        $message .= '</tr>';
             
                                        $message .= '<tr>';
                                            $message .= '<td>';
                                                $message .= '<p style="margin-top: 5px; margin-left: 18px; font-family: Verdana; font-size: 0.8rem;">Cordial Saludo, recientemente se registro una solicitud para un servicio variable, por favor valide la información ingresada para realizar el debido proceso.</p>';
                                            $message .= '</td>';
                                        $message .= '</tr>';
                                    $message .= '</table>';
                                $message .= '</td>';
                            $message .= '</tr>';
 
                            $message .= '<tr>';
                                $message .= '<td style="padding: 40px 30px 10px 30px;">';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                        $message .= '<tr>';
                                            $message .= '<td align="center"><img src="https://sistemakv.com/Resources/img/new-solicitud.png" alt="Logo Email" width="70" height="70" style="display: block;"></td>';
                                            $message .= '<td><p style=" font-family: Verdana;"><strong>Nueva Solicitud</strong></p></td>';
                                        $message .= '</tr>';
                                    $message .= '</table>';
                                $message .= '</td>';
                            $message .= '</tr>';
                            
                            $message .= '<tr>';
                                $message .= '<td style="padding: 10px 30px 20px 30px; font-family: Verdana; font-size: .8rem;">';

                                   $message .= '<p style="margin-top: 20px;"><strong>Solicitud N°:</strong> ' . str_pad($registrarSolicitudesVariables, 4, "0", STR_PAD_LEFT) .'</p>';

                                   $message .= '<p><strong>Fecha de Registro:</strong> ' . $fecha_registro .'</p>';

                                   $message .= '<p><strong>Duración del Servicio:</strong> ' . ($days + 1) . ' Días - Desde <strong>' . $fecha_inicial . '</strong> Hasta <strong>'. $fecha_final . '</strong> de <strong>' . date('h:i A', strtotime($hora_encuentro)) . '</strong> a <strong>' . date('h:i A', strtotime($hora_regreso)) .'</strong></p>';

                                   $message .= '<p><strong>Unidad Operativa:</strong> ' . $listarUnidadOperativaId[0]['unidad_operativa'] .'</p>';
                                   
                                   $message .= '<p><strong>Lugar encuentro y recogida:</strong> ' . $direccion . ' - ' . $lugar_destino . '</p>';
                                   
                                   $message .= '<p><strong>Capacidad del servicio:</strong> ' . $capacidad .'</p>';

                                   $message .= '<p><strong>Cantidad de Pasajeros:</strong> ' . $cant_pax .'</p>';

                                   $message .= '<p><strong>Tipo de Servicio:</strong> ' . $listarTiposServiciosVariablesID[0]['codigo'] . ' - ' . $listarTiposServiciosVariablesID[0]['tipo_servicio'] .'</p>';

                                $message .= '</td>';
                            $message .= '</tr>';

                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<p style="margin-top: 5px; margin-left: 18px; font-family: Verdana; font-size: 0.8rem;">Ingrese a la plataforma SISTEMAKV para visualizar la infomación de la soicitud y actualizar su estado para la respectiva asignación del servicio. </p>';
                                $message .= '</td>';
                            $message .= '</tr>';

                        $message .= '</table>';
                    $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                    $message .= '<td bgcolor="#365f96" style="padding: 20px 15px 20px 15px;">';
                        $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<p style="margin-left: 15px; font-family: Verdana; font-size: 0.8rem; color:#fff;"><strong>Nota: </strong>Por favor, no responda a este mensaje ya que se genero automaticamente, si tiene alguna duda comuniquese con el area de desarrollo.</p>';
                                $message .= '</td>';
                            $message .= '</tr>';
 
                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<p style="margin-top: 10px; margin-left: 16px; font-family: Verdana; font-size: 0.8rem; color:#fff;"><strong>Gracias, Sistema KV.</strong></p>';
                                $message .= '</td>';
                            $message .= '</tr>';
                        $message .= '</table>';
                    $message .= '</td>';
                $message .= '</tr>';
            $message .= '</table>';
        $message .= '</body>';
    $message .= '</html>';

    echo $message;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";


mail($listarUsuarioPorId[0]['correo_electronico'], 'Nueva Solicitud de Servicio Variable - SistemaKV', $message, $headers);


include '../Vista/Template/scripts.php';

header("Location: ../Vista/solicitud_servicios_variables.php");

?>