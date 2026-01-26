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

if(!isset($_POST['id_empresa'])){
	
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','1');
    		$Lname = $titulo->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
	
	$id = $_POST['id_empresa'];
	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
	$query = "SELECT id_empresa,nombre_empresa,nit_empresa,direccion,telefono FROM empresa where id_empresa = '$id'";
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
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfDatosEmpresa></ArrayOfDatosEmpresa>");
		//print_r($posts[1]['post']['id_tipo_vehiculo']);
		$cant = count($posts);
		if($cant > 0){
			for($i=0;$i<count($posts);$i++){
				$titulo = $xml->addChild('DatosEmpresa');
		    	$id = $titulo->addChild('id',$posts[$i]['post']['id_empresa']);
		    	$perfil = $titulo->addChild('nombre',$posts[$i]['post']['nombre_empresa']);
		    	$nombre = $titulo->addChild('nit',$posts[$i]['post']['nit_empresa']);
		    	$empresa = $titulo->addChild('direccion',$posts[$i]['post']['direccion']);
		    	$cliente = $titulo->addChild('telefono',$posts[$i]['post']['telefono']);
			}
			print($xml->asXML());
		} else {
			header('Content-type:text/xml');
			$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','2');
		    $Lname = $titulo->addChild('detalle','No se encontro una empresa');

		    print($xml->asXML());
		}	    
	}
	mysql_close($link);
			
}
?>