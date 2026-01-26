<?php  

require_once '../Modelo/BitacoraTransaccion.php';

$transacciones = new Transacciones();

$listarHistorialTransacciones = $transacciones->listarHistorialTransacciones();

foreach ($listarHistorialTransacciones as $lht) {
	$nueva_fecha = date("Y-m-d H:i:s",strtotime($lht['fecha'] . "+ 1 days")); 

	if(($lht['estado'] == 'REJECTED') || (($lht['estado'] == 'PENDING') && ($lht['resultado'] == ''))){
		if ($nueva_fecha < date('Y-m-d H:i:s')) {

			/*ACtUALIZAR ESTADO TRANSACCION*/
			$estado = 'SUSPENDED';
			$actualizarEstadoTransaccion = $transacciones->actualizarEstadoTransaccion($lht['id_transaccion'], $estado);
		}
	}
}

?>