<?php 
	require_once '../Modelo/OrdenServicio.php';

	$ordenServicio = new OrdenServicio();

	$id_orden = $_POST['id_orden'];

	$datos = explode('|', $_POST['id_vehiculo']);
	
	if($datos[0] < 1000){
	 	$id_empresa = '1';
	} else {
		$id_empresa = '2';
	}

	$id_vehiculo = $datos[1];
	$tipo_combustible = $_POST['tipo_combustible'];
	$id_proveedor = $_POST['id_proveedor'];
	$id_tipo_servicio = $_POST['id_tipo_servicio'];

	if ($_POST['cronograma'] == 'S') {
		$solicitado_por = "CRONOGRAMA MTO";
	}else{
		$solicitado_por = $_POST['solicitado_por'];
	}

	$fecha_inicial = $_POST['fecha_inicial'];
	$fecha_final = $_POST['fecha_final'];
	$detalle = $_POST['detalle'];
	$fecha_creacion = $_POST['fecha_creacion'];
	$id_usuario = $_POST['id_usuario'];

	$actualizar = $ordenServicio->actualizar($id_orden, $id_empresa, $id_vehiculo, $tipo_combustible, $id_proveedor, $id_tipo_servicio, $solicitado_por, $fecha_inicial, $fecha_final, $detalle, $fecha_creacion, $id_usuario);
		
	$id_categoria = $_POST['id_categoria'];
	$id_subcategoria = $_POST['id_subcategoria'];
	$cantidad = $_POST['cantidad'];
	$valor = $_POST['valorTotal'];
	$valorActual = $_POST['valorActual'];
	$nuevo_valor = $valorActual + $valor;

	if (($id_categoria != '') && ($id_subcategoria != '') && ($cantidad != '') && ($valor != '')) {
		$id = $ordenServicio->registrarDetalle($id_orden, $id_categoria, $id_subcategoria, $cantidad, $valor, $nuevo_valor);
	}

	header('Location: ../Vista/actualizarOrdenServicio.php?id_orden_servicio=' . $id_orden);

?>