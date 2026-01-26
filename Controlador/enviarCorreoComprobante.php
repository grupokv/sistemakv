<?php

include '../Vista/Template/styles.php';
require_once '../Modelo/ConceptosCobro.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Vehiculo.php';

$conceptoCobro = new ConceptoCobro();
$usuario = new Usuario();
$vehiculo = new Vehiculo();

$num_id_comprobante = $_GET['num_id'];
$listarComprobantesPagosPropietario = $conceptoCobro->listarComprobantesPagosPropietario($num_id_comprobante);

$listarUsuarioPorId = $usuario->listarUsuarioPorId($listarComprobantesPagosPropietario[0]['usuario_registro']);
setlocale(LC_TIME, 'spanish');

$message = '<html>';
    $message .= '<head><meta charset="gb18030">';
                    $message .= '<title></title>';
                $message .= '</head>';
        $message = '<body style="margin: 0; padding: 0;">';
            $message .= '<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">';
                $message .= '<tr>';
                    $message .= '<td bgcolor="#1b2d3b" style="padding: 10px 25px 13px 50px;">';
                        $message .= '<img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo King Vision" width="150" height="110" style="display: block;"> ';
                    $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                    $message .= '<td bgcolor="#fcfcfc" style="padding: 10px 10px 40px 30px;">';
                        $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<p style="margin: 15px; font-family: Verdana; font-size: 0.8rem;">ESTIMADO USUARIO</strong></p>';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                        $message .= '<tr>';
                                            $message .= '<td>';
                                                $message .= '<p style="margin-left: 18px; font-family: Verdana; font-size: 0.8rem;">' . strtoupper(strftime("%B %d del %Y",strtotime(date("Y-m-d")))) . '</p>';
                                            $message .= '</td>';
                                        $message .= '</tr>';
             
                                        $message .= '<tr>';
                                            $message .= '<td>';
                                                $message .= '<p style="margin-left: 18px; font-family: Verdana; font-size: 0.8rem;">Cordial Saludo, la persona <strong>'. $listarUsuarioPorId[0]['nombre'] . '</strong> con numero de identificación <strong>'. $listarUsuarioPorId[0]['usuario'] . '</strong> registro su comprobante de pago para los servicios pendiente.</p>';
                                            $message .= '</td>';
                                        $message .= '</tr>';
                                    $message .= '</table>';
                                $message .= '</td>';
                            $message .= '</tr>';
 
                            $message .= '<tr>';
                                $message .= '<td style="padding: 40px 30px 10px 30px;">';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                        $message .= '<tr>';
                                            $message .= '<td align="center"><img src="https://sistemakv.com/Resources/img/email-icon.png" alt="Logo Email" width="70" height="70" style="display: block;"></td>';
                                            $message .= '<td><a target="_blank" href="https://sistemakv.com/Documentos/Comprobantes/' . $listarComprobantesPagosPropietario[0]['comprobante_pago'] . '"  style="font-family: Verdana; font-size: 0.8rem;"><strong>Comprobante Pago</strong></a><p >'. $num_id_comprobante . '</p></td>';
                                        $message .= '</tr>';
                                    $message .= '</table>';
                                $message .= '</td>';
                            $message .= '</tr>';
                            
                            $message .= '<tr>';
                                $message .= '<td style="padding: 10px 30px 100px 30px;">';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                        $message .= '<thead>';
                                            $message .= '<tr>';
                                                $message .= '<td align="center"><strong style="font-family: Verdana; font-size: 0.8rem;">SERVICIOS PAGOS</strong></td>';
                                                $message .= '<td align="center"><strong style="font-family: Verdana; font-size: 0.8rem;">VALOR SERVICIO</strong></td>';
                                                $message .= '<td align="center"><strong style="font-family: Verdana; font-size: 0.8rem;">FECHA COBRO</strong></td>';
                                                $message .= '<td align="center"><strong style="font-family: Verdana; font-size: 0.8rem;">VEHICULO</strong></td>';
                                            $message .= '</tr>';
                                        $message .= '</thead>';
                                        $message .= '</tbody>';
                                            
                                            foreach($listarComprobantesPagosPropietario As $lcpp){
                                                $listarPorId = $conceptoCobro->listarPorIdCobrosPropietario($lcpp['id_cobro_propietario']);
                                                $listarConceptosId = $conceptoCobro->listarPorId($listarPorId[0]['id_concepto']);
                                                $listarVehiculosId = $vehiculo->listarPorId($listarPorId[0]['id_vehiculo']);
                                                
                                                $message .= '<tr>';
                                                    $message .= '<td align="center" style="font-family: Verdana; font-size: 0.8rem;">' . $listarConceptosId[0]['detalle_concepto'] . '</td>';
                                                    $message .= '<td align="center" style="font-family: Verdana; font-size: 0.8rem;">$ '  . number_format($listarPorId[0]['valor']) .'</td>';
                                                    $message .= '<td align="center" style="font-family: Verdana; font-size: 0.8rem;">' . strtoupper(strftime("%B %d del %Y",strtotime($listarPorId[0]['fecha_cobro']))) . '</td>';
                                                    $message .= '<td align="center" style="font-family: Verdana; font-size: 0.8rem;">' .  $listarVehiculosId[0]['placa'] . '</td>';
                                                $message .= '</tr>';
                                            }
                                        $message .= '</tbody>';
                                    $message .= '</table>';
                                $message .= '</td>';
                            $message .= '</tr>';
 
                            $message .= '<tr>';
                                $message .= '<td>';
                                    $message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
                                            $message .= '<tr>';
                                                    $message .= '<td align="center"><a href="https://sistemakv.com/index_old.php?estadoBoton=A&id_comprobante=' . $num_id_comprobante .'" style="border-radius:25px; border:2px solid #16660f; background-color: #1b8013; color:#fff; width:140px; height:40px; padding: 9px 18px 9px 18px;">APROBAR</a></td>';
                                                    $message .= '<td align="center"><a href="https://sistemakv.com/index_old.php?estadoBoton=R&id_comprobante=' . $num_id_comprobante .'" style="border-radius:25px; border:2px solid #961b1d; background-color: #b02022; color:#fff; width:140px; height:40px; padding: 9px 18px 9px 18px;">RECHAZAR</a></td>';
                                        $message .= '</tr>';
                                    $message .= '</table>';
                                    
                                    
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
                                    $message .= '<p style="margin-left: 16px; font-family: Verdana; font-size: 0.8rem; color:#fff;"><strong>Gracias, King Vision.</strong></p>';
                                $message .= '</td>';
                            $message .= '</tr>';
                        $message .= '</table>';
                    $message .= '</td>';
                $message .= '</tr>';
            $message .= '</table>';
        $message .= '</body>';
    $message .= '</html>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";


mail('asistcontable@ortsas.com, desarrollo@ortsas.com', 'Comprobante de Pagos pendientes - SistemaKV', $message, $headers);


include '../Vista/Template/scripts.php';

header("Location: ../Vista/inicioPropietarios.php");

?>
