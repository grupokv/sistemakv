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

//print_r($listarServicios);

?>

<table>
	<thead>
		<tr style="color: #b31e1e;">
			<th>SERVICIOS: </th>
			<th><?php echo count($listarServicios); ?></th>
		</tr>
		<tr></tr>
		<tr>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>ID SERVICIO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>ESTADO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>FECHA Y HORA INICIO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>FECHA Y HORA FINAL</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>CLIENTE</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>DIVISION</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>TIPO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>PRODUCTO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>GRUPO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>PAX</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>KMS</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>CLASE VEHICULO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>VEHICULO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>CONDUCTOR</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>RELEVO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>SOLICITANTE</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>OBSERVACIONES</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>REQUISITOS</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>ORIGEN</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>DESTINO</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>VALOR CLIENTE</b></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>VALOR MOVIL</b></th>
		</tr>
	</thead>
	<tbody style="text-align: center;">
		<?php 
			$valor_total_cliente = 0;
			$valor_total_movil = 0;
		?>
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
    		<?php if ($servicioJSON->{'entrada'} != 0){ ?>
    			<tr>
					
					<td><?php echo $ls['id_servicio'] ?></td>
					<td style="background-color: #00fdd9;">
						<?php
						if ($ls['estado_servicio'] == 'A') {
						 	echo "ACTIVO (ENTRADA)";
						 } 
							 
						?>
					</td>
					<td><?php echo $ls['fecha_inicio'] . ' - ' . date('h:i A', strtotime($ls['hora_inicio'])) ?></td>
					<td><?php echo $ls['fecha_final'] . ' - ' . date('h:i A', strtotime($ls['hora_final'])) ?></td>
					<td><?php echo $cliente_ID[0]['razon_social'] ?></td>
					<td><?php echo $ls['division_cliente'] ?></td>
					<td><?php echo $ls['tipo_servicio'] ?></td>
					<td><?php echo $listarProductosPorID[0]['detalle_producto'] . ' - ' . $listarProductosPorID[0]['tipo_producto'] ?></td>
					<td><?php echo $ls['grupo'] ?></td>
					<td><?php echo $cant_paxJSON->{'entrada'} ?></td>
					<td><?php echo $kmsJSON->{'entrada'} ?></td>
					<td><?php echo strtoupper($listarClasesMovilEntrada[0]['clase_movil_producto']) . ' ( ' . $listarTvEntrada[0]['nombre_tipo_vehiculo'] .' )' ?></td>
					<td><?php echo $listarVehiculoEntrada[0]['placa'] . ' - '. $listarVehiculoEntrada[0]['numero_movil'] ?></td>
					<td><?php echo utf8_decode($listarConductorEntrada[0]['nombre_conductor']) ?></td>
					<td><?php echo $listarVehiculoRelevoEntrada[0]['placa'] . ' - '. $listarVehiculoRelevoEntrada[0]['numero_movil'] ?></td>
					<td><?php echo $ls['solicitante'] ?></td>
					<td><?php echo $ls['observaciones'] ?></td>
					<td><?php echo $ls['requisitos'] ?></td>
					<td><?php echo $ls['origen'] ?></td>
					<td><?php echo $ls['destino'] ?></td>
					<td><?php echo "$" . $val_clienteJSON->{'entrada'} ?></td>
					<td><?php echo "$" . $val_movilJSON->{'entrada'} ?></td>
				</tr>
    		<?php } ?>
    		<?php if ($servicioJSON->{'salida'} != 0){ ?>
    			<tr>
					
					<td><?php echo $ls['id_servicio'] ?></td>
					<td style="background-color: #ffff00;">
						<?php
						if ($ls['estado_servicio'] == 'A') {
						 	echo "ACTIVO (SALIDA)";
						 } 
							 
						?>
					</td>
					<td><?php echo $ls['fecha_inicio'] . ' - ' . date('h:i A', strtotime($ls['hora_inicio'])) ?></td>
					<td><?php echo $ls['fecha_final'] . ' - ' . date('h:i A', strtotime($ls['hora_final'])) ?></td>
					<td><?php echo $cliente_ID[0]['razon_social'] ?></td>
					<td><?php echo $ls['division_cliente'] ?></td>
					<td><?php echo $ls['tipo_servicio'] ?></td>
					<td><?php echo $listarProductosPorID[0]['detalle_producto'] . ' - ' . $listarProductosPorID[0]['tipo_producto'] ?></td>
					<td><?php echo $ls['grupo'] ?></td>
					<td><?php echo $cant_paxJSON->{'salida'} ?></td>
					<td><?php echo $kmsJSON->{'salida'} ?></td>
					<td><?php echo strtoupper($listarClasesMovilSalida[0]['clase_movil_producto']) . ' ( ' . $listarTvSalida[0]['nombre_tipo_vehiculo'] .' )' ?></td>
					<td><?php echo $listarVehiculoSalida[0]['placa'] . ' - '. $listarVehiculoSalida[0]['numero_movil'] ?></td>
					<td><?php echo utf8_decode($listarConductorSalida[0]['nombre_conductor']) ?></td>
					<td><?php echo $listarVehiculoRelevoSalida[0]['placa'] . ' - '. $listarVehiculoRelevoSalida[0]['numero_movil'] ?></td>
					<td><?php echo $ls['solicitante'] ?></td>
					<td><?php echo $ls['observaciones'] ?></td>
					<td><?php echo $ls['requisitos'] ?></td>
					<td><?php echo $ls['origen'] ?></td>
					<td><?php echo $ls['destino'] ?></td>
					<td><?php echo "$" . $val_clienteJSON->{'salida'} ?></td>
					<td><?php echo "$" . $val_movilJSON->{'salida'} ?></td>
				</tr>
    		<?php } ?>
		
    		<?php 
    			$valor_total_cliente = $valor_total_cliente + $valor_cliente;
				$valor_total_movil = $valor_total_movil + $valor_movil;
    		?>
		<?php } ?>

		<tr>
			<td colspan="20" style="text-align: center; color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><b>TOTAL:</b></td>
			<td style="text-align: center; color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $valor_total_cliente; ?></td>
			<td style="text-align: center; color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $valor_total_movil; ?></td>
		</tr>

	</tbody>
</table>