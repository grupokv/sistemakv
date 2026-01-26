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

if(!isset($_POST['id_solicitud'])){
	
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','1');
    		$Lname = $titulo->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
	
	$id = $_POST['id_solicitud'];
	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
	$query = "SELECT * FROM detalle_servicio where id_solicitud = '$id'";
	$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

	$posts = array();
	if(mysql_num_rows($result)) {
	        while($post = mysql_fetch_assoc($result)) {
	                $posts[] = array('post'=>$post);
	        }
	}

	//print_r($posts);

	if($format == 'json') {
	        header('Content-type: application/json');
	        echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type:text/xml');
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfDatosServiciosSolicitud></ArrayOfDatosServiciosSolicitud>");
		//print_r($posts[1]['post']['id_tipo_vehiculo']);
		$cant = count($posts);
		if($cant > 0){
			for($i=0;$i<count($posts);$i++){
				$titulo = $xml->addChild('DatosServicio');
		    	$id = $titulo->addChild('id',$posts[$i]['post']['id_servicio']);
		    	$solicitud = $titulo->addChild('id_solicitud',$posts[$i]['post']['id_solicitud']);
		    	$usuario = $titulo->addChild('id_solicitante',$posts[$i]['post']['id_usuario']);
		    	$cliente = $titulo->addChild('id_cliente',$posts[$i]['post']['id_cliente']);
		    	$tipo = $titulo->addChild('tipo',$posts[$i]['post']['tipo']);
		    	$fecha = $titulo->addChild('fecha_solicitud',$posts[$i]['post']['fecha_solicitud']);
		    	$fecha_servicio = $titulo->addChild('fecha_servicio',$posts[$i]['post']['fecha_servicio']);
		    	$hora_servicio = $titulo->addChild('hora_servicio',$posts[$i]['post']['hora_servicio']);
		    	$contacto = $titulo->addChild('contacto',$posts[$i]['post']['nombre_contacto']);
		    	$tel_contacto = $titulo->addChild('tel_contacto',$posts[$i]['post']['telefono_contacto']);
		    	$cantidad = $titulo->addChild('cant_pasajeros',$posts[$i]['post']['cant_pasajeros']);
		    	$tipo_vehiculo = $titulo->addChild('id_tipo_vehiculo',$posts[$i]['post']['id_tipo_vehiculo']);
		    	$tipo_servicio = $titulo->addChild('id_tipo_servicio',$posts[$i]['post']['id_tipo_servicio']);
		    	$origen = $titulo->addChild('origen',$posts[$i]['post']['origen']);
		    	$destino = $titulo->addChild('destino',$posts[$i]['post']['destino']);
		    	$horas = $titulo->addChild('horas',$posts[$i]['post']['horas_disponibilidad']);
		    	$centro_costo = $titulo->addChild('centro_costo',$posts[$i]['post']['centro_costo']);
		    	$unidad = $titulo->addChild('id_unidad',$posts[$i]['post']['id_unidad_operativa']);
		    	$estado = $titulo->addChild('estado',$posts[$i]['post']['estado']);
			}
			print($xml->asXML());
		} else {
			header('Content-type:text/xml');
			$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','2');
		    $Lname = $titulo->addChild('detalle','No se encontraron servicios para la solicitud');

		    print($xml->asXML());
		}	    
	}
	mysql_close($link);
			
}
?>