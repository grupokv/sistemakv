<?php 
require_once '../Modelo/Facturacion.php';

$id_facturacion = $_POST['id_facturacion'];
$id_vehiculo = $_POST['id_vehiculo'];
$mes = $_POST['mes'] . '-' . '01';
$dias_facturados = $_POST['dias_facturados'];
$valor_total_facturado = $_POST['valor_total_facturado'];
$valor_total_pagar_terceros = $_POST['valor_total_pagar_terceros'];
$fecha_factura = $_POST['fecha_factura'];
$fecha_recibo_pago = $_POST['fecha_recibo_pago'];
$id_contrato = $_POST['id_contrato'];
$estado = $_POST['estado'];

$facturacion = new Facturacion();
$actualizarFacturacion = $facturacion->actualizar($id_facturacion, $id_vehiculo, $mes, $dias_facturados, $valor_total_facturado, $valor_total_pagar_terceros, $fecha_factura, $fecha_recibo_pago, $id_contrato, $estado);

header('Location: ../Vista/facturaciones.php');

 ?>