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

$reporteServiciosVehEntrada = $operativo->reporteServiciosVehEntrada($fecha, $fecha2, $id_cliente, $tipo_servicio, $emisor, $id_vehiculo, $id_conductor, $estado, $id_producto);
$reporteServiciosVehSalida = $operativo->reporteServiciosVehSalida($fecha, $fecha2, $id_cliente, $tipo_servicio, $emisor, $id_vehiculo, $id_conductor, $estado, $id_producto);

//print_r($listarServicios);

?>

<!-- ENTRADAS -->
<table>
	<thead>
		<tr style="color: #b31e1e;">
			<th>RESULTADO: </th>
			<th><?php echo count($reporteServiciosVehEntrada); ?></th>
		</tr>
		<tr></tr>
		<tr>
			<th colspan="8" style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">ENTRADAS</th>
		</tr>
		<tr>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PLACA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">MOVIL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TIPO VEHICULO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PRODUCTO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TOTAL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL MOVIL</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$totalcliente = 0; 
		 	$totalmovil = 0; 
		 	$totalservicios = 0; 
		 ?>

		<?php foreach ($reporteServiciosVehEntrada as $lsve){ 
			$listarVehiculosPorId = $vehiculo->listarPorId(str_replace('"', '', $lsve['id_vehiculo']));
			$listaripoVehPorId = $tipoVehiculo->listarPorId($listarVehiculosPorId[0]['id_tipo_vehiculo']);
			$cliente_ID = $cliente->cliente_ID($lsve['id_cliente']);
			$listarProductosPorID = $operativo->listarProductosPorID($lsve['id_producto']);
    	?>

			<tr style="text-align: center;">
				<td><?php echo $listarVehiculosPorId[0]['placa'] ?></td>
				<td><?php echo $listarVehiculosPorId[0]['numero_movil'] ?></td>
				<td><?php echo $listaripoVehPorId[0]['nombre_tipo_vehiculo'] ?></td>
				<td><?php echo utf8_decode($cliente_ID[0]['razon_social']) ?></td>
				<td><?php echo utf8_decode($listarProductosPorID[0]['detalle_producto']) . ' - ' . $listarProductosPorID[0]['tipo_producto']; ?></td>
				<td><?php echo $lsve['total'] ?></td>
				<td><?php echo "$" . $lsve['valor_cliente'] ?></td>
				<td><?php echo "$" . $lsve['valor_movil'] ?></td>
			</tr>

			<?php 
				$totalcliente =  ($totalcliente + $lsve['valor_cliente']); 
			 	$totalmovil = ($totalmovil + $lsve['valor_movil']);  
			 	$totalservicios = ($totalservicios + $lsve['total']);  
			?>
		<?php } ?>

		<tr>
			<th colspan="5" style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TOTAL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo $totalservicios ?></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $totalcliente; ?></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $totalmovil; ?></th>
		</tr>
	</tbody>
</table>

<!-- SALIDAS -->
<table>
	<thead>
		<tr style="color: #b31e1e;">
			<th>RESULTADO: </th>
			<th><?php echo count($reporteServiciosVehSalida); ?></th>
		</tr>
		<tr></tr>
		<tr>
			<th colspan="8" style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">SALIDAS</th>
		</tr>
		<tr>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PLACA</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">MOVIL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TIPO VEHICULO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PRODUCTO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TOTAL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL CLIENTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR TOTAL MOVIL</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$totalcliente = 0; 
		 	$totalmovil = 0; 
		 	$totalservicios = 0; 
		 ?>

		<?php foreach ($reporteServiciosVehSalida as $lsvs){ 
			$listarVehiculosPorId = $vehiculo->listarPorId(str_replace('"', '', $lsvs['id_vehiculo']));
			$listaripoVehPorId = $tipoVehiculo->listarPorId($listarVehiculosPorId[0]['id_tipo_vehiculo']);
			$cliente_ID = $cliente->cliente_ID($lsvs['id_cliente']);
			$listarProductosPorID = $operativo->listarProductosPorID($lsvs['id_producto']);
    	?>

			<tr style="text-align: center;">
				<td><?php echo $listarVehiculosPorId[0]['placa'] ?></td>
				<td><?php echo $listarVehiculosPorId[0]['numero_movil'] ?></td>
				<td><?php echo $listaripoVehPorId[0]['nombre_tipo_vehiculo'] ?></td>
				<td><?php echo utf8_decode($cliente_ID[0]['razon_social']) ?></td>
				<td><?php echo utf8_decode($listarProductosPorID[0]['detalle_producto']) . ' - ' . $listarProductosPorID[0]['tipo_producto']; ?></td>
				<td><?php echo $lsvs['total'] ?></td>
				<td><?php echo "$" . $lsvs['valor_cliente'] ?></td>
				<td><?php echo "$" . $lsvs['valor_movil'] ?></td>
			</tr>

			<?php 
				$totalcliente =  ($totalcliente + $lsvs['valor_cliente']); 
			 	$totalmovil = ($totalmovil + $lsvs['valor_movil']);  
			 	$totalservicios = ($totalservicios + $lsvs['total']);  
			?>
		<?php } ?>

		<tr>
			<th colspan="5" style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TOTAL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo $totalservicios ?></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $totalcliente; ?></th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"><?php echo "$" . $totalmovil; ?></th>
		</tr>
	</tbody>
</table>

