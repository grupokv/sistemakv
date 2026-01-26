<?php  
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/ConceptosCobro.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Cartera.php';

date_default_timezone_set('America/Bogota');

$id_vehiculo = $_POST['id_vehiculo'];

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$cartera = new Cartera();

/*VALIDACIÓN DOCUMENTACIÓN VENCIDA DEL VEHICULO*/
$docs_vacios = $vehiculo->documentosvencidosPorId($id_vehiculo, $hoy, $fecha2);
$cant_docs = count($docs_vacios);

/*VALIDACIÓN CARTERA PENDIENTE DEL VEHICULO*/

$anio = date('Y');
$mes = date('m');

$consultarAvalesActivosMesVehiculo = $cartera->consultarAvalesActivosMesVehiculo($id_vehiculo, $mes, $anio);
$cantAval = count($consultarAvalesActivosMesVehiculo);

$pagos_pendientes = $concepto->pagosPendientesPorVehiculo($id_vehiculo);
$cant_carteraPendiente = (count($pagos_pendientes) + $cantAval);

$html = '';

if(($cant_docs != 0) && ($cant_carteraPendiente == 0)){
    $html .= '<input class="form-control" type="hidden" id="validacion_doc_cartera" name="validacion_doc_cartera" value="1" />';
}else if(($cant_docs == 0) && ($cant_carteraPendiente != 0)){
    $html .= '<input class="form-control" type="hidden" id="validacion_doc_cartera" name="validacion_doc_cartera" value="2" />';
}else if(($cant_docs != 0) && ($cant_carteraPendiente != 0)){
    $html .= '<input class="form-control" type="hidden" id="validacion_doc_cartera" name="validacion_doc_cartera" value="3" />';
}else{
    $html .= '<input class="form-control" type="hidden" id="validacion_doc_cartera" name="validacion_doc_cartera" value="0" />';
}

echo $html;

?>