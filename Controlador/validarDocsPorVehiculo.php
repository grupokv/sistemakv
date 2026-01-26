<?php  
require_once '../Modelo/Vehiculo.php';

$id_vehiculo = $_POST['id_vehiculo'];

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

$vehiculo = new Vehiculo();

/*VALIDACIÓN DOCUMENTACIÓN VENCIDA DEL VEHICULO*/
$docs_vacios = $vehiculo->documentosvencidosPorId($id_vehiculo, $hoy, $fecha2);
$cant_docs = count($docs_vacios);

$html = '';

if($cant_docs != 0){
    $html .= '<input class="form-control" type="hidden" id="validacion_doc" name="validacion_doc" value="1" />';
}

echo $html;

?>