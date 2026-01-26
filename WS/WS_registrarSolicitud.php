<?php
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

if((!isset($_POST['idas']))or(!isset($_POST['retornos']))or(!isset($_POST['id_cliente']))or(!isset($_POST['id_usuario']))){
	
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
	$name = $xml->addChild('id_error','1');
    $Lname = $xml->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
	
	$idas = $_POST['idas'];
	$retornos = $_POST['retornos'];
	$id_cliente = $_POST['id_cliente'];
	$id_usuario = $_POST['id_usuario'];
	$fecha = date('Y-m-d H:i:s');
	$estado = 'A';
	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
	$query = "INSERT INTO solicitud_cliente (servicios_ida,servicios_retorno,fecha_solicitud,id_cliente,id_usuario,estado) VALUES ('$idas','$retornos','$fecha','$id_cliente','$id_usuario','$estado')";
	$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

	$id_solicitud = mysql_insert_id();

	//print_r($posts);

	if($format == 'json') {
	        header('Content-type: application/json');
	        echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type:text/xml');
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfDatosSolicitud></ArrayOfDatosSolicitud>");
		//print_r($posts[1]['post']['id_tipo_vehiculo']);
		if($id_solicitud > 0){
			$titulo = $xml->addChild('DatosSolicitud');
			$id = $titulo->addChild('id',$id_solicitud);

			$mensaje = $xml->addChild('Mensaje');
			$name = $mensaje->addChild('id_mensaje','1');
		    $Lname = $mensaje->addChild('detalle','Registro realizado correctamente');

		} else {
			header('Content-type:text/xml');
			$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$name = $xml->addChild('id_error','2');
		    $Lname = $xml->addChild('detalle','No se pudo realizar el registro');

		    print($xml->asXML());
		}	    
	}
	mysql_close($link);
			
}
?>