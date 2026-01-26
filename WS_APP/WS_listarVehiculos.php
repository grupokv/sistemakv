<?php
require('../Modelo/Vehiculo.php');
date_default_timezone_set('America/Bogota');

$vehiculo = new Vehiculo();
$listado = $vehiculo->listarActivos();

if(isset($_GET['format'])){
    if($_GET['format'] == 'json'){
        $format = $_GET['format'];
    } else {
        $format = 'xml';    
    }
} else {
    $format = 'xml';
}

if($format == 'json') {
        header('Content-type: application/json');
        echo json_encode(array($listado));
}
else {
    header('Content-type:text/xml');
    $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><ArrayOfVehiculos></ArrayOfVehiculos>");
   
    foreach($listado as $ls){
        $titulo = $xml->addChild('Vehiculo');
        $name = $titulo->addChild('id',$ls['id_vehiculo']);
        $Lname = $titulo->addChild('id_tipo_vehiculo',$ls['id_tipo_vehiculo']);
        $nit = $titulo->addChild('placa',$ls['placa']);
        $dir = $titulo->addChild('numero_movil',$ls['numero_movil']);
    }

    print($xml->asXML());
}
?>