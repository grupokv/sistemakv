<?php 
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Contrato.php";
require_once "../Modelo/EmpresaEnt.php";
require_once "../Modelo/Cliente.php";

$id_vehiculo = $_POST['id_vehiculo'];
$id_contrato = $_POST['id_contrato'];

$vehiculo = new Vehiculo();
$listarContratoPorVehiculo = $vehiculo->listarContratoPorVehiculo($id_vehiculo);

$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();

$cant = count($listarContratoPorVehiculo);

$html = '';

$html .= '<option value="">SELECCIONAR</option>';

if ($cant > 0) {
	  foreach ($listarContratoPorVehiculo as $lcpv) {
		    $id_contrato1 = $lcpv['id_contrato'];
		    $listarContrato = $contrato->listarId($id_contrato1);

		      foreach ($listarContrato as $lc) {
			           $emp = $empresa->listarPorId($lc['id_empresa']);
                  $cli = $cliente->listarClientePorId($lc['id_cliente']);
                  $hoy = date('Y-m-d');

                  $listarContratosVencidosPorVehiculo = $contrato->listarContratosVencidosPorVehiculo($lcpv['id_contrato'], $hoy);
            
                  if (count($listarContratosVencidosPorVehiculo) > 0) {
                  	$html .= '<option value=' .$lc['id_contrato'].' disabled style="color:red;font-weight:bolder">' ."CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];  $lci['nombre_conductor']. '</option>';

                  }else{
                        if($id_contrato > 0){
                             if($lcpv['id_contrato'] == $id_contrato){
                  	           $html .= '<option value=' .$lc['id_contrato'].' selected="selected" >' ."CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];  $lci['nombre_conductor']. '</option>';
                              } else {
                                     $html .= '<option value=' .$lc['id_contrato']. '>' ."CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];  $lci['nombre_conductor']. '</option>';
                              }
                        } else {
                               $html .= '<option value=' .$lc['id_contrato'].'>' ."CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];  $lci['nombre_conductor']. '</option>';
                        }
                  }
		      }
	  }
}else{
    $html .= '<option value="" selected="selected">EL VEHICULO NO TIENE CONTRATOS ANCLADOS</option>';
}

echo $html;
 ?>