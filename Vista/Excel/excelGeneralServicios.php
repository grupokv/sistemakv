<?php  
$filename = 'SERVICIOS-' . date('YmdHis') .'.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

include ("../../Controlador/Sesion/autenticar.php");
require_once("../../Modelo/Operativo.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/Cliente.php");
require_once("../../Modelo/Vehiculo.php");
require_once("../../Modelo/Conductor.php");
require_once("../../Modelo/TipoVehiculo.php");

$operativo = new Operativo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();
$cliente = new Cliente();
$tipoVehiculo = new TipoVehiculo();


/* ---------------------------- */
/* VALIDAR PERMISOS ESPECIFICOS */
/* ---------------------------- */

$id_usuario = $_SESSION['id_usuario'];
$listarPermisosUsuariosOperativo = $operativo->listarPermisosUsuariosOperativoIdUsuario($id_usuario);

$clientes = $listarPermisosUsuariosOperativo[0]['id_cliente'];
$anular = $listarPermisosUsuariosOperativo[0]['anulacion'];
$consulta = $listarPermisosUsuariosOperativo[0]['consulta'];

/* ---------------------------- */
/* ---------------------------- */

if ($_GET['id_cliente'] != "") {
	$id_cliente = " = " . $_GET['id_cliente'];
}else{
	if($clientes == 'ALL'){
		$id_cliente = "LIKE '%%'";
	}else{
		$id_cliente = "IN ('". $clientes ."')";
	}	
}

if ($_GET['tipo_servicio'] != "") {
	$tipo_servicio = $_GET['tipo_servicio'];
}else{
	$tipo_servicio = "";
}

if ($_GET['fecha_inicial'] != "") {
	$fecha = $_GET['fecha_inicial'];
}else{
	$fecha = "0000-00-00";
}

if ($_GET['fecha_final'] != "") {
	$fecha2 = $_GET['fecha_final'];
}else{
	$fecha2 = "9999-99-99";
}

if ($_GET['emisor'] != "") {
	$emisor = $_GET['emisor'];
}else{
	$emisor = "";
}

if ($_GET['id_vehiculo'] != "") {
	$id_vehiculo = " = '" . $_GET['id_vehiculo']. "'";
}else{
	$id_vehiculo = "LIKE '%%'";
}

if ($_GET['id_conductor'] != "") {
	$id_conductor = " = '" . $_GET['id_conductor']. "'";
}else{
	$id_conductor = "LIKE '%%' ";
}

if ($_GET['pend_asignacion'] != "") {
	$estado = " = '" . $_GET['pend_asignacion'] . "'";
}else{
	$estado = " != 'E' ";
}

if ($_GET['id_producto'] != "") {
	$id_producto = $_GET['id_producto'];
}else{
	$id_producto = "";
}

$listarServicios = $operativo->listarServicios($fecha, $fecha2, $id_cliente, $tipo_servicio, $emisor, $id_vehiculo, $id_conductor, $estado, $id_producto);
//echo count($listarServicios);
?>

<table>
	<thead>
		<tr style="color: #b31e1e;">
			<th>REGISTROS: </th>
			<th><?php echo count($listarServicios); ?></th>
		</tr>
		<tr></tr>
		<tr>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">ID SERVICIO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">ESTADO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">FECHA Y HORA INICIO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">FECHA Y HORA FINAL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">DIVISION</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TIPO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PRODUCTO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">GRUPO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CANT ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PAX ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">KMS ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CLASE VEHICULO ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VEHICULO ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CONDUCTOR ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">RELEVO ENTRADA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CANT SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PAX SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">KMS SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CLASE VEHICULO SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VEHICULO SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CONDUCTOR SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">RELEVO SALIDA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">SOLICITANTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">REQUISITO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">OBSERVACIONES</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">ORIGEN</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">DESTINO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL MOVIL</th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($listarServicios as $ls){ 

			$cliente_ID = $cliente->cliente_ID($ls['id_cliente']);
			$listarProductosPorID = $operativo->listarProductosPorID($ls['id_producto']);
			$listarUsuarioPorId = $usuario->listarUsuarioPorId($ls['id_usuario_creador']);
		    $listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($ls['id_servicio']);

			$val_clienteJSON = json_decode($listarVehiculosPorServicioID[0]['valor_cliente']);
			$val_movilJSON = json_decode($listarVehiculosPorServicioID[0]['valor_movil']);

			$valor_cliente = ($val_clienteJSON->{'entrada'} + $val_clienteJSON->{'salida'});
			$valor_movil = ($val_movilJSON->{'entrada'} + $val_movilJSON->{'salida'});

			/* ---------------------------------------- */

			$servicioJSON = json_decode($listarVehiculosPorServicioID[0]['servicio']);
			$clase_vehJSON = json_decode($listarVehiculosPorServicioID[0]['clase_vehiculo']);
			$cant_paxJSON = json_decode($listarVehiculosPorServicioID[0]['cant_pasajeros']);
			$kmsJSON = json_decode($listarVehiculosPorServicioID[0]['kms']);
			$id_vehJSON = json_decode($listarVehiculosPorServicioID[0]['id_vehiculo']);
			$id_condJSON = json_decode($listarVehiculosPorServicioID[0]['id_conductor']);
			$id_vehRelevoJSON = json_decode($listarVehiculosPorServicioID[0]['id_vehiculo_relevo']);

			$listarClasesMovilEntrada = $operativo->listarClasesMovilClientesID($clase_vehJSON->{'entrada'}->{'cliente'});
			$listarClasesMovilSalida = $operativo->listarClasesMovilClientesID($clase_vehJSON->{'salida'}->{'cliente'});
			$listarTvEntrada = $tipoVehiculo->listarPorId($listarClasesMovilEntrada[0]['id_tipo_vehiculo']);
			$listarTvSalida = $tipoVehiculo->listarPorId($listarClasesMovilSalida[0]['id_tipo_vehiculo']);

			$listarVehiculoEntrada = $vehiculo->listarPorId($id_vehJSON->{'entrada'});
			$listarVehiculoSalida = $vehiculo->listarPorId($id_vehJSON->{'salida'});
			$listarVehiculoRelevoEntrada = $vehiculo->listarPorId($id_vehRelevoJSON->{'entrada'});
			$listarVehiculoRelevoSalida = $vehiculo->listarPorId($id_vehRelevoJSON->{'salida'});
			$listarConductorEntrada = $conductor->listarPorId($id_condJSON->{'entrada'});
			$listarConductorSalida = $conductor->listarPorId($id_condJSON->{'salida'});

    	?>

			<tr>
				<td><?php echo str_pad($ls['id_servicio_base'], 5, "0", STR_PAD_LEFT) ?></td>
				<td><?php echo $ls['estado'] ?></td>
				<td><?php echo $ls['fecha_inicio'] . ' - ' . date('h:i A', strtotime($ls['hora_inicio'])) ?></td>
				<td><?php echo $ls['fecha_final'] . ' - ' . date('h:i A', strtotime($ls['hora_final'])) ?></td>
				<td><?php echo $cliente_ID[0]['razon_social'] ?></td>
				<td><?php echo $ls['division_cliente'] ?></td>
				<td><?php echo $ls['tipo_servicio'] ?></td>
				<td><?php echo $listarProductosPorID[0]['detalle_producto'] . ' - ' . $listarProductosPorID[0]['tipo_producto'] ?></td>
				<td><?php echo $ls['grupo'] ?></td>
				<td><?php echo $servicioJSON->{'entrada'} ?></td>
				<td><?php echo $cant_paxJSON->{'entrada'} ?></td>
				<td><?php echo $kmsJSON->{'entrada'} ?></td>
				<td><?php echo strtoupper($listarClasesMovilEntrada[0]['clase_movil_producto']) . ' ( ' . $listarTvEntrada[0]['nombre_tipo_vehiculo'] .' )' ?></td>
				<td><?php echo $listarVehiculoEntrada[0]['placa'] . ' - '. $listarVehiculoEntrada[0]['numero_movil'] ?></td>
				<td><?php echo utf8_decode($listarConductorEntrada[0]['nombre_conductor']) ?></td>
				<td><?php echo $listarVehiculoRelevoEntrada[0]['placa'] . ' - '. $listarVehiculoRelevoEntrada[0]['numero_movil'] ?></td>
				<td><?php echo $servicioJSON->{'salida'} ?></td>
				<td><?php echo $cant_paxJSON->{'salida'} ?></td>
				<td><?php echo $kmsJSON->{'salida'} ?></td>
				<td><?php echo strtoupper($listarClasesMovilSalida[0]['clase_movil_producto']) . ' ( ' . $listarTvSalida[0]['nombre_tipo_vehiculo'] .' )' ?></td>
				<td><?php echo $listarVehiculoSalida[0]['placa'] . ' - '. $listarVehiculoSalida[0]['numero_movil'] ?></td>
				<td><?php echo utf8_decode($listarConductorSalida[0]['nombre_conductor']) ?></td>
				<td><?php echo $listarVehiculoRelevoSalida[0]['placa'] . ' - '. $listarVehiculoRelevoSalida[0]['numero_movil'] ?></td>
				<td><?php echo  utf8_decode($ls['solicitante']) ?></td>
				<td><?php echo $ls['requisitos'] ?></td>
				<td><?php echo $ls['observaciones'] ?></td>
				<td><?php echo $ls['origen'] ?></td>
				<td><?php echo $ls['destino'] ?></td>
				<td><?php echo $valor_cliente ?></td>
				<td><?php echo $valor_movil ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>