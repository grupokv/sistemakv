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

$user = $_GET['us'];
$pass = base64_encode($_GET['pw']);

if((!isset($user))or(!isset($pass))){
	if($format = 'xml'){
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
			$titulo = $xml->addChild('Resultado');
			$name = $titulo->addChild('id_error','1');
    		$Lname = $titulo->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());
	} else {
		header('Content-type: application/json');
		$posts['mensaje'] = 'Debe ingresar datos de usuario'; 
		echo json_encode(array('posts'=>$posts));
	}

} else {
	
	include('WS_con_BD.php');
	
	$query = "SELECT id_usuario,id_perfil,nombre,id_empresa,id_cliente FROM usuario where usuario = '$user' and clave = '$pass' and estado = '1'";
	$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

	$posts = array();
	if(mysql_num_rows($result)) {
	        while($post = mysql_fetch_assoc($result)) {
					$posts['datos_usuario'] = $post;
	        }
			
			$fecha = date('YmdHis');
			$hoy = date('Y-m-d H:i:s');
			$id_us = $posts['datos_usuario']['id_usuario'];
			
			$valido = array();
			$query = "SELECT * FROM token WHERE id_usuario = '$id_us' and fecha_caducidad > '$hoy'";
			$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);
			while($val = mysql_fetch_assoc($result)) {
					$valido['existe'] = $val;
	        }
			$existe = count($valido['existe']);
			
			if($existe < 1){
				$validez = date("Y-m-d H:i:s",strtotime($hoy."+ 1 days"));
				$token = md5($us.$fecha);
				$query = "INSERT into token (token,id_usuario,fecha_generacion,fecha_caducidad) VALUES ('$token','$id_us','$hoy','$validez')";
				$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);
			} else {
				$token = $valido['existe']['token'];
			}
	} else {
		$posts['mensaje'] = 'No se encontro un usuario o se encuentra bloqueado'; 
	}

	//print_r($posts);

	if($format == 'json') {
	        header('Content-type: application/json');
			$posts['token'] = $token;
	        echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type:text/xml');
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><ArrayOfDatosUsuario></ArrayOfDatosUsuario>");
		
		$cant = (count($posts));
		
		if($cant > 0){
			for($i=0;$i<count($cant);$i++){
				$titulo = $xml->addChild('DatosUsuario');
		    	$id = $titulo->addChild('id',$posts['datos_usuario']['id_usuario']);
		    	$perfil = $titulo->addChild('perfil',$posts['datos_usuario']['id_perfil']);
		    	$nombre = $titulo->addChild('nombre',$posts['datos_usuario']['nombre']);
		    	$empresa = $titulo->addChild('empresa',$posts['datos_usuario']['id_empresa']);
		    	$cliente = $titulo->addChild('cliente',$posts['datos_usuario']['id_cliente']);
				$token = $titulo->addChild('token',$token);
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