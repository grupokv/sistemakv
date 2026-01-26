<?php 
require_once '../Modelo/OrdenServicio.php';

$orden = new OrdenServicio();

$id_servicio = $_POST['id_servicio'];
$id_orden = $_POST['id_orden'];
$valor = $_POST['valor'];
$valorActual = $_POST['valorActual'];

$listarOrdenId = $orden->listarPorId($id_servicio);

$nuevo_valor = $valorActual - $valor;

if ($id_servicio != '') {
	$eliminarDetallePorId = $orden->eliminarDetallePorId($id_servicio);
	$actualizarValor = $orden->actualizarValorTotal($id_orden, $nuevo_valor);
}



 ?>