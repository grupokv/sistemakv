<?php
include("../Controlador/Sesion/autenticar.php");require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Contrato.php");
$cliente = $_POST['cliente'];$fecha = date('Y-m-d');
$contrato = new Contrato();$empresa = new Empresa();
$ListarContratos = $contrato->listarPorClienteActivo($cliente,$fecha);

//print_r($ListarContratos);
if(count($ListarContratos) < 1){
	$html = '<option value="0">NO TIENE CONTRATOS ACTIVOS</option>';
} else {
	$html = '<option value="">Seleccione Contrato</option>';
	foreach($ListarContratos as $lc){		
		$tipo_contrato = $contrato->listarTiposContratosId($lc["id_tipo_contrato"]);		
		$datos_empresa = $empresa->listarPorId($lc['id_empresa']);
		$html .= '<option value="'.$lc["id_contrato"].'" >Con '.$datos_empresa[0]['nombre_empresa'].' No. '.$lc["id_contrato"].' - Desde: '.$lc["fecha_inicial_contrato"].' Hasta: '.$lc["fecha_final_contrato"].' - '.$tipo_contrato[0]["tipo_contrato"].'</option>';
	}
}

echo $html;

?>
