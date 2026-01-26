<?php  

include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Convenio.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");

$vehiculo = new Vehiculo();
$cliente = new Cliente();
$convenio = new Convenio();
$clienteConvenio = new Cliente_Convenio();
$Objcontrato = new Contrato();

$id_vehiculo = $_POST['id_vehiculo'];
$fecha = date('Y-m-d');

$html = '';
if ($id_vehiculo != "") {
	$listarConveniosActivosPorVehiculo = $convenio->listarConveniosActivosPorVehiculo($id_vehiculo, $fecha);

	if (count($listarConveniosActivosPorVehiculo) > 0) {
		
		$html = '<select readonly="true" class="form-control" name="convenio" id="convenio" onchange="tipoextracto(this.value); validarDocFirmadoConvenio(this.value);">';
			$html .= '<option value="">SELECCIONAR</option>';
			foreach ($listarConveniosActivosPorVehiculo as $lcapv) {

				$listarClienteID = $clienteConvenio->cliente_ID($lcapv['id_cliente']);
				$contratoid = $Objcontrato->listarId($lcapv['id_contrato']);
				$clienteContratoID = $cliente->cliente_ID($contratoid[0]['id_cliente']);

				$html .= '<option value="' . $lcapv['id_convenio'] .'">CONVENIO N° ' . $lcapv['id_convenio'] . ' CON '  . $listarClienteID[0]['razon_social'] . ' DEL CONTRATO N° ' . $lcapv['id_contrato'] . ' - ' . $clienteContratoID[0]['razon_social']; /* . ' - DESDE ' . $lcapv['fecha_inicio_convenio'] . ' HASTA ' . $lcapv['fecha_final_convenio'] . '</option>'*/;

			}

		$html .= '</select>';
	

		$html .= '<input type="hidden" class="form-control" name="valConv" id="valConv" value="1" >';

	}else{
		$html = '<select readonly="true" class="form-control" name="convenio" id="convenio"><option ="0">ESTE VEHICULO NO TIENE CONVENIOS ACTIVOS ACTUALMENTE</option></select>';

		$html .= '<input type="hidden" class="form-control" name="valConv" id="valConv" value="0" >';
	}	
}

echo $html;

?>