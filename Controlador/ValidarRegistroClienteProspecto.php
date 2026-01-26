<?php
require_once("../Modelo/ClienteProspecto.php");

$cliente = new ClienteProspecto();

$nit_cliente = $_POST['nit_cliente'];
$validarPorNitCliente = $cliente->validarPorNitCliente($nit_cliente);

$html = '';

if(count($validarPorNitCliente) == 0){
    $html .= '<input type="hidden" name="valorVerificar" id="valorVerificar"  class="form-control" value="1">';
}else{
    $html .= '<input type="hidden" name="valorVerificar" id="valorVerificar"  class="form-control" value="2">';
}

echo $html;

?>