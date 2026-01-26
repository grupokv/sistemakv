<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");

$empresa = $_POST['empresa'];
$cliente = $_POST['cliente'];

$contrato = new Contrato();
$ListarContratos = $contrato->listarPorEmpresaCliente($empresa,$cliente);

//print_r($ListarContratos);

$html = '<option value="">Seleccione Contrato</option>';
$cantidad = count($ListarContratos);
if($cantidad < 1){
	$html = 'No hay registros';
} else {
	foreach($ListarContratos as $lc){
		$tipo_contrato = $contrato->listarTiposContratosId($lc["id_tipo_contrato"]);
		if ($lc['fecha_final_contrato'] < date('Y-m-d')) {
			$html .= '<option value="'.$lc["id_contrato"].'" disabled style="color:red;font-weight:bolder" >No. '.$lc["id_contrato"].' - Desde: '.$lc["fecha_inicial_contrato"].' Hasta: '.$lc["fecha_final_contrato"].' - '.$tipo_contrato[0]["tipo_contrato"].'</option>';
		}else{
			$html .= '<option value="'.$lc["id_contrato"].'" >No. '.$lc["id_contrato"].' - Desde: '.$lc["fecha_inicial_contrato"].' Hasta: '.$lc["fecha_final_contrato"].' - '.$tipo_contrato[0]["tipo_contrato"].'</option>';
		}
	}
}
echo $html;
?>
