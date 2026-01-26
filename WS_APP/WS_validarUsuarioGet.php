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

if((!isset($_GET['us']))or(!isset($_GET['pw']))){
	
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','1');
    		$Lname = $titulo->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
	
	$user = $_GET['us'];
	$pass = base64_encode($_GET['pw']);
	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');

	$query = "SELECT id_usuario,id_perfil,nombre,id_empresa,id_cliente FROM usuario where usuario = '$user' and clave = '$pass' and estado = '1'";
	//echo $query;
	$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

	$posts = array();
	if(mysql_num_rows($result)) {
	        while($post = mysql_fetch_assoc($result)) {
	                $posts[] = array('post'=>$post);
	        }
	}


	if($format == 'json') {
	        header('Content-type: application/json');
	        echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type:text/xml');
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfDatosUsuario></ArrayOfDatosUsuario>");
		$cant = count($posts);
		if($cant > 0){
			for($i=0;$i<count($posts);$i++){
				$titulo = $xml->addChild('DatosUsuario');
		    	$id = $titulo->addChild('id',$posts[$i]['post']['id_usuario']);
		    	$perfil = $titulo->addChild('perfil',$posts[$i]['post']['id_perfil']);
		    	$nombre = $titulo->addChild('nombre',$posts[$i]['post']['nombre']);
		    	$empresa = $titulo->addChild('empresa',$posts[$i]['post']['id_empresa']);
		    	$cliente = $titulo->addChild('cliente',$posts[$i]['post']['id_cliente']);
			}
			print($xml->asXML());
		} else {
			header('Content-type:text/xml');
			$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','2');
		    $Lname = $titulo->addChild('detalle','No se encontro un usuario o se encuentra bloqueado');

		    print($xml->asXML());
		}
	}
	mysql_close($link);
			
}
?>