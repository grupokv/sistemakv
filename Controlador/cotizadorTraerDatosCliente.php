<?php 
require_once("../Modelo/CotizadorKV.php");
$cotizadorkv = new CotizadorKV();
$html = '';

$id_cliente = $_POST['id_cliente'];

$datos_cliente = $cotizadorkv->buscarClientePorNit($id_cliente); 

if(count($datos_cliente) > 0){
    
    $nombre_cliente = $datos_cliente[0]['nombre_cliente'];
    $ident_cliente = $datos_cliente[0]['ident_cliente'];
    $dir_cliente = $datos_cliente[0]['dir_cliente'];
    $tel_cliente = $datos_cliente[0]['tel_cliente'];
    $email_cliente = $datos_cliente[0]['email_cliente'];
    $contacto_cliente = $datos_cliente[0]['contacto_cliente'];
    
    $html = $nombre_cliente."|".$ident_cliente."|".$dir_cliente."|".$tel_cliente."|".$email_cliente."|".$contacto_cliente;
    
} 

echo $html;
?>