<?php 

require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Contrato.php";
require_once "../Modelo/EmpresaEnt.php";
require_once "../Modelo/Cliente.php";

$id_vehiculo = $_POST['id_vehiculo'];

$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();

$vehiculo = new Vehiculo();
$listarContratoPorVehiculo = $vehiculo->listarContratoPorVehiculo($id_vehiculo);
$cant = count($listarContratoPorVehiculo);

$html = '';

	$html .= '<div class="alert alert-primary text-center" role="alert" style="height: 35px; line-height: 10px;">';
		$html .= '<strong>BASE</strong>';
	$html .= '</div>';

		foreach ($listarContratoPorVehiculo as $lcpv) {
			if ($lcpv['tipo_contrato'] == 'BASE') {
				$listarContratosId = $contrato->listarId($lcpv['id_contrato']);
				foreach ($listarContratosId	 as $lci) {
					$emp = $empresa->listarPorId($lci['id_empresa']);
	                $cli = $cliente->listarClientePorId($lci['id_cliente']);

					$html .= '<p style="font-size: 0.8rem;"><span class="fa fa-dot-circle-o mr-1" style="font-size: 0.5rem;"></span> N° INTERNO <strong>' . $listarContratosId[0]['id_contrato'] . "</strong> Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'] .'</p>';
				}
			}
		}

	$html .= '<div class="alert alert-primary text-center" role="alert" style="height: 35px; line-height: 10px;">';
		$html .= '<strong>APOYO</strong>';
	$html .= '</div>';

		foreach ($listarContratoPorVehiculo as $lcpv) {
			if ($lcpv['tipo_contrato'] == 'APOYO') {
				$listarContratosId = $contrato->listarId($lcpv['id_contrato']);
				foreach ($listarContratosId	 as $lci) {
					$emp = $empresa->listarPorId($lci['id_empresa']);
	                $cli = $cliente->listarClientePorId($lci['id_cliente']);
					$html .= '<p style="font-size: 0.8rem;"><span class="fa fa-dot-circle-o mr-1" style="font-size: 0.5rem;"></span> N° INTERNO <strong>' . $listarContratosId[0]['id_contrato'] . "</strong> Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'] .'</p>';
					$html .= '<hr>';
				}
			}
		}

echo $html;

 ?>