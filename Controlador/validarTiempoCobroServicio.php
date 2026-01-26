<?php 
require_once ("../Modelo/ConceptosCobro.php");

$concepto = new ConceptoCobro();

$id_concepto = $_POST['id_servicio'];

$listarPorId = $concepto->listarPorId($id_concepto);

if($listarPorId[0]['frecuencia'] == "M"){
    echo "<input type='hidden' class='form-control' name='frecuencia_servicio' id='frecuencia_servicio' value='M'>";
}else if($listarPorId[0]['frecuencia'] == "A"){
    echo "<input type='hidden' class='form-control' name='frecuencia_servicio' id='frecuencia_servicio' value='A'>";
}else if($listarPorId[0]['frecuencia'] == "N"){
    echo "<input type='hidden' class='form-control' name='frecuencia_servicio' id='frecuencia_servicio' value='N'>";
}

?>