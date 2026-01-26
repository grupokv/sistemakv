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

	
	$id_solicitud = '1';
	$id_cliente = '1';
	$tipo = 'IDA';
	$id_usuario = '2';
	$fecha = date('Y-m-d H:i:s');
	$fecha_servicio = '2020/02/21';
	$hora_servicio = '15:30:00';
	$contacto = 'Prueba Juan';
	$tel_contacto = '1234567';
	$cant_pasajeros = '19';
	$id_tipo_vehiculo = '1';
	$id_tipo_servicio = '1';
	$origen = 'BOGOTA';
	$destino = 'MEDELLIN';
	if($destino == ''){
		$destino = $origen;
	}
	$horas = '12';
	$centro_costo = '0';
	$unidad = '1';
	$estado = 'P';

	$link = mysql_connect('localhost','uimoilmy_appuser','XqoMcB?Ta0v_') or die('No se puede conectar a la BD');
	mysql_select_db('uimoilmy_appkv',$link) or die('No se puede seleccionar la BD');
	$periodicidad = 'S';

	if($periodicidad == 'S'){
		$fecha_inicial = '2020-02-21';
		$fecha_final = '2020-03-15';

		$lunes = '1';
		$martes = '0';
		$miercoles = '1';
		$jueves = '0';
		$viernes = '1';
		$sabado = '0';
		$domingo = '0';

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
				echo $query = "INSERT INTO detalle_servicio (id_solicitud,id_usuario,id_cliente,tipo,fecha_solicitud,fecha_servicio,hora_servicio,nombre_contacto,telefono_contacto,cant_pasajeros,listado,id_tipo_vehiculo,id_tipo_servicio,ciudad,origen,destino,horas_disponibilidad,centro_costo,id_unidad_operativa,estado,valor) VALUES ('$id_solicitud','$id_usuario','$id_cliente','$tipo','$fecha','$fecha_servicio','$hora_servicio','$contacto','$tel_contacto','$cant_pasajeros','','$id_tipo_vehiculo','$id_tipo_servicio','1','$origen','$destino','$horas','$centro_costo','$unidad','$estado','0')";
				$result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

				$id_servicio = mysql_insert_id();

				array_push($id_servicios,$id_servicio);

				echo $query1 = "INSERT INTO frecuencia_servicio (id_servicio, lunes, martes, miercoles, jueves, viernes, sabado, domingo, fecha_inicial, fecha_final, id_padre) VALUES ('$id_servicio','$lunes','$martes','$miercoles','$jueves','$viernes','$sabado','$domingo','$fecha_inicial','$fecha_final','$id_padre')";
				$result1 = mysql_query($query1,$link) or die('Query no funcional:  '.$query1);
				$id_padre = $id_servicio;
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
			

?>