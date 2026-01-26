<?php
include('../Modelo/Vehiculo.php');
date_default_timezone_set('America/Bogota');
if(isset($_GET['format'])){
    if($_GET['format'] == 'json'){
        $format = $_GET['format'];
    } else {
        $format = 'xml';    
    }
} else {
    $format = 'xml';
}

if(!isset($_GET['id_tipo_vehiculo'])){
    
    header('Content-type:text/xml');
    $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
    $titulo = $xml->addChild('Resultado');
    $name = $titulo->addChild('id_error','1');
    $Lname = $titulo->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
    
    $id = $_GET['id_tipo_vehiculo'];
    $vehiculo = new Vehiculo();
    $listado = $vehiculo->listarPorTipoVehiculo($id);
    
    if($format == 'json') {
            header('Content-type: application/json');
            echo json_encode(array($listado));
    }
    else {
        header('Content-type:text/xml');
        $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfVehiculos></ArrayOfVehiculos>");
        $cant = count($listado);
        if($cant > 0){
	    
            foreach($listado as $ls){
                $titulo = $xml->addChild('DatosVehiculo');
                $id = $titulo->addChild('id',$ls['id_vehiculo']);
                $perfil = $titulo->addChild('id_tipo_vehiculo',$ls['id_tipo_vehiculo']);
                $nombre = $titulo->addChild('placa',$ls['placa']);
                $empresa = $titulo->addChild('numero_movil',$ls['numero_movil']);
            }
            print($xml->asXML());
        } else {
            header('Content-type:text/xml');
            $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
            $titulo = $xml->addChild('Resultado');
            $name = $titulo->addChild('id_error','2');
            $Lname = $titulo->addChild('detalle','No se encontraron vehiculos por ese tipo de vehiculo  ');

            print($xml->asXML());
        }       
    }
    mysql_close($link);            
}
?>