<?php
session_start();
require_once "../Modelo/ConceptosCobro.php";

$conceptoCobro = new ConceptoCobro();
date_default_timezone_set('America/Bogota');

$estado = $_POST['estado'];
$revisado_por = $_SESSION['id_usuario'];
$fecha_revision = date('YmdHis');



$id_comprobante = $_POST['id_comprobante'];
$listarComprobantesPagosPropietario = $conceptoCobro->listarComprobantesPagosPropietario($id_comprobante);


foreach($listarComprobantesPagosPropietario As $lcpp){
    
    if($estado == 'R'){
        $novedad = $_POST['novedad_rechazo'];
        $actualizarEstadoComprobante = $conceptoCobro->actualizarComprobantePagoPropietario($lcpp['id_comprobante'], $estado, $novedad, $revisado_por, $fecha_revision);
    }else if($estado == 'A'){
        $novedad = "";
        $actualizarEstadoComprobante = $conceptoCobro->actualizarComprobantePagoPropietario($lcpp['id_comprobante'], $estado, $novedad, $revisado_por, $fecha_revision);
        
        $estadoCobroProp = "S";
        $actualizarEstadoCobroPropietario = $conceptoCobro->actualizarEstadoCobroPropietario($estadoCobroProp, $lcpp['id_cobro_propietario']);
    }
    
}

    if($estado == 'R'){    
        
        $comunicado = $_POST['novedad_rechazo'];
        $id_usuario_comprobante = $listarComprobantesPagosPropietario[0]['usuario_registro'];
        $estadoNotificacion = "R";
        $registrarNotificacionComprobante = $conceptoCobro->registrarNotificacionComprobante($comunicado, $id_comprobante, $id_usuario_comprobante, $fecha_revision, $revisado_por, $estadoNotificacion);
    
        
    }else if($estado == 'A'){
       
        $comunicado = "SU COMPROBANTE FUE APROBADO CORRECTAMENTE";
        $id_usuario_comprobante = $listarComprobantesPagosPropietario[0]['usuario_registro'];
        $estadoNotificacion = "A";
        $registrarNotificacionComprobante = $conceptoCobro->registrarNotificacionComprobante($comunicado, $id_comprobante, $id_usuario_comprobante, $fecha_revision, $revisado_por, $estadoNotificacion);
    
    }


header("Location: ../Vista/inicio.php");

?>