<?php 
require_once ('../../Modelo/ConceptosCobro.php');
require_once ('../../Modelo/Vehiculo.php');
require_once ("../../Modelo/Usuario.php");
require_once ("../../Modelo/General.php");

$filename = 'COMPROBANTES_PAGO-' . date('YmdHis') .'.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

$conceptosCobro = new ConceptoCobro();
$vehiculo = new Vehiculo();
$usuario = new Usuario();

if($_POST['tipo_reporte'] == 1){
    $listarComprobantesPagosFecha = $conceptosCobro->listarComprobantesPagosFecha(date('Y-m-d'));
}else{
    $listarComprobantesPagosFecha = $conceptosCobro->listarComprobantesPagosSemanales($_POST['fecha_inicial'], $_POST['fecha_final']);
}

?>

<table>
	<thead>
		<tr style="color: #b31e1e;">
			<th colspan="11">TOTAL COMPROBANTES: <?php echo count($listarComprobantesPagosFecha); ?></th>
		</tr>
		<tr>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">ID COMPROBANTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VEHICULO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">NUMERO MOVIL</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">PROPIETARIO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">DOCUMENTO PROPIETARIO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;"># DE COMPROBANTE</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">TOTAL PAGADO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">CONCEPTO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">VALOR POR CONCEPTO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">BANCO DE CONSIGNACION </th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">USUARIO DE REGISTRO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">FECHA DE REGISTRO</th>
			<th style="color: #fff; border: 1px solid #fff; background-color: #5e99b1;">COMPROBANTE</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($listarComprobantesPagosFecha as $lcpf) { 
				$listarCobroId = $conceptosCobro->listarPorIdCobrosPropietario($lcpf['id_cobro_propietario']);
				$listarConceptoId = $conceptosCobro->listarPorId($listarCobroId[0]['id_concepto']);
				$listarVehiculoID = $vehiculo->listarPorId($listarCobroId[0]['id_vehiculo']);
				$listarBancosId = $conceptosCobro->listarBancosId($lcpf['banco_consignacion']);
				$listarUsuarioPorId = $usuario->listarUsuarioPorId($lcpf['usuario_registro']);
				$listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoID[0]['id_propietario']);
		?>
			<tr>
				<td style="text-align center;"><?php echo $lcpf['id_comprobante']; ?></td>
				<td style="text-align: center;"><?php echo $listarVehiculoID[0]['placa']; ?></td>
				<td style="text-align: center;"><?php echo $listarVehiculoID[0]['numero_movil']; ?></td>

				<td style="text-align: center;"><?php echo $listarPropietarioPorId[0]['nombre']; ?></td>
				<td style="text-align: center;"><?php echo utf8_encode($listarPropietarioPorId[0]['usuario']); ?></td>
				<td style="text-align: center;"><?php echo utf8_encode($lcpf['num_id_comprobante']); ?></td>
				<td style="text-align: center;"><?php echo $lcpf['valor_pagado']; ?></td>
				<td style="text-align: center;">
					<?php 
						$mesCobro = explode("-", $listarCobroId[0]['fecha_cobro']);
						echo $listarConceptoId[0]['detalle_concepto'] . " - " . strtoupper(mes($mesCobro[1])); 
					?>
				</td>
				<td style="text-align: center;"><?php echo $listarCobroId[0]['valor']; ?></td>
				<td style="text-align: center;"><?php echo $listarBancosId[0]['descripcion']; ?></td>
				<td style="text-align: center;"><?php echo $listarUsuarioPorId[0]['nombre']; ?></td>
				<td style="text-align: center;"><?php echo $lcpf['fecha_registro_comprobante']; ?></td>
				<td style="text-align: center;"><a target="_blank" href="http://www.sistemakv.com/Documentos/Comprobantes/<?php echo $lcpf['comprobante_pago'] ?>"><?php echo $lcpf['comprobante_pago']; ?></a></td>
			</tr>
				
		<?php } ?>
	</tbody>
</table>