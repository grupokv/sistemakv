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

if((!isset($_POST['id_solicitud']))or(!isset($_POST['id_cliente']))or(!isset($_POST['tipo']))or(!isset($_POST['id_usuario']))or(!isset($_POST['hora_servicio']))or(!isset($_POST['contacto']))or(!isset($_POST['tel_contacto']))or(!isset($_POST['cant_pasajeros']))or(!isset($_POST['id_tipo_vehiculo']))or(!isset($_POST['id_tipo_servicio']))or(!isset($_POST['origen']))or(!isset($_POST['periodicidad']))or(!isset($_POST['horas']))or(!isset($_POST['centro_costo']))or(!isset($_POST['unidad']))){
	
	header('Content-type:text/xml');
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
	$name = $xml->addChild('id_error','1');
    $Lname = $xml->addChild('detalle','Los parametros no son validos');

    print($xml->asXML());

} else {
	
	$id_solicitud = $_POST['id_solicitud'];
	$id_cliente = $_POST['id_cliente'];
	$tipo = $_POST['tipo'];
	$id_usuario = $_POST['id_usuario'];
	$fecha = date('Y-m-d H:i:s');
	$fecha_servicio = $_POST['fecha_servicio'];
	$hora_servicio = $_POST['hora_servicio'];
	$contacto = $_POST['contacto'];
	$tel_contacto = $_POST['tel_contacto'];
	$cant_pasajeros = $_POST['cant_pasajeros'];
	$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
	$id_tipo_servicio = $_POST['id_tipo_servicio'];
	$origen = $_POST['origen'];
	$destino = $_POST['destino'];
	if($destino == ''){
		$destino = $origen;
	}
	$horas = $_POST['horas'];
	$centro_costo = $_POST['centro_costo'];
	$unidad = $_POST['unidad'];
	$estado = 'P';

	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
	$periodicidad = $_POST['periodicidad'];

	if($periodicidad == 'S'){
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];

		$lunes = $_POST['lunes'];
		$martes = $_POST['martes'];
		$miercoles = $_POST['miercoles'];
		$jueves = $_POST['jueves'];
		$viernes = $_POST['viernes'];
		$sabado = $_POST['sabado'];
		$domingo = $_POST['domingo'];

		$dias_array = array();
		if($lunes == 1){
			array_push($dias_array,1); 
		}
		if($martes == 1){
			array_push($dias_array,2); 
		}
		if($miercoles == 1){
			array_push($dias_array,3); 
		}
		if($jueves == 1){
			array_push($dias_array,4); 
		}
		if($viernes == 1){
			array_push($dias_array,5); 
		}
		if($sabado == 1){
			array_push($dias_array,6); 
		}
		if($domingo == 1){
			array_push($dias_array,0); 
		}

		$fecha_servicio = $fecha_inicial;
		$id_servicios = array();
		$id_padre = 0;
		while($fecha_servicio <= $fecha_final){
			
			$hoy = date("N",strtotime($fecha_servicio));
			if(in_array($hoy,$dias_array)){
				$query = "INSERT INTO detalle_servicio (id_solicitud,id_usuario,id_cliente,tipo,fecha_solicitud,fecha_servicio,hora_servicio,nombre_contacto,telefono_contacto,cant_pasajeros,listado,id_tipo_vehiculo,id_tipo_servicio,ciudad,origen,destino,horas_disponibilidad,centro_costo,id_unidad_operativa,estado,valor) VALUES ('$id_solicitud','$id_usuario','$id_cliente','$tipo','$fecha','$fecha_servicio','$hora_servicio','$contacto','$tel_contacto','$cant_pasajeros','','$id_tipo_vehiculo','$id_tipo_servicio','1','$origen','$destino','$horas','$centro_costo','$unidad','$estado','0')";
				$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

				$id_servicio = mysql_insert_id();

				array_push($id_servicios,$id_servicio);

				$query1 = "INSERT INTO frecuencia_servicio (id_servicio, lunes, martes, miercoles, jueves, viernes, sabado, domingo, fecha_inicial, fecha_final, id_padre) VALUES ('$id_servicio','$lunes','$martes','$miercoles','$jueves','$viernes','$sabado','$domingo','$fecha_inicial','$fecha_final','$id_padre')";
				$result1 = mysql_query($query1,$link) or die('Query no funcional:  '.$query1);
				if($id_padre == 0){
					$id_padre = $id_servicio;
				}
				
			}
			$fecha_servicio = date("Y-m-d",strtotime($fecha_servicio."+ 1 days"));
		}


	} else {
		
		$query = "INSERT INTO detalle_servicio (id_solicitud,id_usuario,id_cliente,tipo,fecha_solicitud,fecha_servicio,hora_servicio,nombre_contacto,telefono_contacto,cant_pasajeros,listado,id_tipo_vehiculo,id_tipo_servicio,ciudad,origen,destino,horas_disponibilidad,centro_costo,id_unidad_operativa,estado,valor) VALUES ('$id_solicitud','$id_usuario','$id_cliente','$tipo','$fecha','$fecha_servicio','$hora_servicio','$contacto','$tel_contacto','$cant_pasajeros','','$id_tipo_vehiculo','$id_tipo_servicio','1','$origen','$destino','$horas','$centro_costo','$unidad','$estado','0')";
		$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

	
		$id_servicio = mysql_insert_id();
		$id_servicios = array();
		array_push($id_servicios,$id_servicio);

	}

	if($format == 'json') {
	        header('Content-type: application/json');
	        echo json_encode(array('posts'=>$posts));
	}
	else {
		header('Content-type:text/xml');
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><Mensaje></Mensaje>");
		//print_r($posts[1]['post']['id_tipo_vehiculo']);
		if($id_servicio > 0){
			for($i = 0;$i<count($id_servicios);$i++){
				$id = $xml->addChild('id_servicio',$id_servicios[$i]);
				$name = $xml->addChild('id_mensaje','1');
		    	$Lname = $xml->addChild('detalle','Registro realizado correctamente');
			}
			

		    print($xml->asXML());

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