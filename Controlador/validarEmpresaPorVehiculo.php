<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/EmpresaEnt.php");

$vehiculo = new Vehiculo();
$empresa = new Empresa();

$id_vehiculo = $_POST['id_vehiculo'];

$listarVehiculoPorId = $vehiculo->listarPorId($id_vehiculo);
$cant = count($listarVehiculoPorId);

$html = '';
$id_empresa = 0;

if ($cant > 0) {

	$html .= '<input type="hidden" name="pasajeros_vehiculo" id="pasajeros_vehiculo" class="form-control" value="' . $listarVehiculoPorId[0]['cant_pasajeros'] .'" />';

	if (($listarVehiculoPorId[0]['numero_movil'] >= 1) && ($listarVehiculoPorId[0]['numero_movil'] <= 999)){ 
		
    	$id_empresa = 1;
		$listarEmpresaID = $empresa->listarPorId($id_empresa);

      	$html .= '<select name="id_empresa" id="id_empresa" class="form-control">';
			$html .= '<option value="">SELECCIONAR</option>';
			foreach ($listarEmpresaID as $leID){
	        	$html .= '<option value="' . $leID['id_empresa'].' ">' . $leID['nombre_empresa'] .'</option>';
	        }
	    $html .= '</select>';

    } else if (($listarVehiculoPorId[0]['numero_movil'] >= 1000) && ($listarVehiculoPorId[0]['numero_movil'] <= 1999)){ 
		
		$id_empresa = 2;
		$listarEmpresaID = $empresa->listarPorId($id_empresa);

      	$html .= '<select name="id_empresa" id="id_empresa" class="form-control">';
			$html .= '<option value="">SELECCIONAR</option>';
			foreach ($listarEmpresaID as $le){
	        	$html .= '<option value="' . $le['id_empresa'].' ">' . $le['nombre_empresa'] .'</option>';
	        }
	    $html .= '</select>';
        
    }else{
		$listarEmpresaORTyLP = $empresa->listarEmpresaORTyLP();

      	$html .= '<select name="id_empresa" id="id_empresa" class="form-control">';
			$html .= '<option value="">SELECCIONAR</option>';
			foreach ($listarEmpresaORTyLP as $le){
	        	$html .= '<option value="' . $le['id_empresa'].' ">' . $le['nombre_empresa'] .'</option>';
	        }
	    $html .= '</select>';

    }
}


echo $html;

?>