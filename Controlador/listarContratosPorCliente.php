<?php 
require_once ("../Modelo/Contrato.php");
require_once ("../Modelo/EmpresaEnt.php");
require_once ("../Modelo/Cliente.php");

$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();

$id_cliente = $_POST['id_cliente'];

$listarPorCliente = $contrato->listarPorCliente($id_cliente);

$html = '';
    
if(count($listarPorCliente) > 0 ){
    
    
    $html .= '<option value="">SELECCIONAR</option>';

    foreach($listarPorCliente As $lpc){
        
        $emp = $empresa->listarPorId($lpc['id_empresa']);
        $cli = $cliente->listarClientePorId($lpc['id_cliente']);
        
        $html .= '<option value="' . $lpc['id_contrato'] .'">CONTRATO N° ' . $lpc['id_contrato'] . " ENTRE " . $cli[0]['razon_social'] . " Y " . $emp[0]['nombre_empresa'] .'</option>';
    }
}else{
	$html .= '<option value=""> EL CLIENTE NO TIENE CONTRATOS ACTIVOS CREADOS.</option>';
}

echo $html;

?>