<?php 
require_once '../Modelo/Contrato.php';
require_once '../Modelo/Cliente.php';
require_once '../Modelo/EmpresaEnt.php';

$id_contrato = $_POST['id_contrato'];

$contrato = new Contrato();
$empresa = new Empresa();
$cliente = new Cliente();

$hoy = date('Y-m-d');
$listarC = $contrato->listarContratosHabiles($hoy);


$html = '<option value="0">ESTE VEHÍCULO NO TIENE CONTRATOS ANCLADOS</option>';


foreach($listarC as $lc){
	$emp = $empresa->listarPorId($lc['id_empresa']);
	$cli = $cliente->listarClientePorId($lc['id_cliente']);
	if ($lc['id_contrato'] != $id_contrato) {	

		$html .= '<option value="' . $lc['id_contrato'] . '"> No. interno ' .$lc['id_contrato']. ' - CONTRATO N° ' . $lc['numero_contrato'] . ' Entre ' . $cli[0]['razon_social'] . ' y ' . $emp[0]['nombre_empresa'];'</option>';
	}
}

echo $html;


 ?>

