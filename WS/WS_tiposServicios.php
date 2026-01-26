<?php
date_default_timezone_set('America/Bogota');
if($_GET['format'] != 'json'){
	$format = 'xml';
} else {
	$format = $_GET['format'];
}
/* conectamos a la bd */
$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
/* sacamos los posts de bd */
$query = "SELECT * FROM tipo_servicio";
$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

/* creamos el array con los datos */
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
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' standalone='yes'?><ArrayOfTipoServicio></ArrayOfTipoServicio>");
	//print_r($posts[1]['post']['id_tipo_vehiculo']);
	//echo count($posts);
	for($i=0;$i<count($posts);$i++){
		$titulo = $xml->addChild('TipoServicio');
    	$name = $titulo->addChild('id',$posts[$i]['post']['id_tipo_servicio']);
    	$Lname = $titulo->addChild('detalle',$posts[$i]['post']['nombre_tipo_servicio']);
	}

    print($xml->asXML());
}
mysql_close($link);
?>