<?php 
require_once '../Modelo/Operativo.php';
require_once("../Modelo/Festivos.php");

$id_producto = $_POST['id_producto'];
$tipo_vehiculo_cliente = $_POST['tipo_vehiculo_cliente'];
$tipo_tarifa = $_POST['tipo_tarifa'];

$operativo = new Operativo();
$festivos = new Festivos();

$listarProductosPorID = $operativo->listarProductosPorID($id_producto);
$listarTarifasProductosPorIdYTipoVehiculo = $operativo->listarTarifasProductosPorIdYTipoVehiculo($id_producto, $tipo_vehiculo_cliente);
//print_r($listarTarifasProductosPorIdYTipoVehiculo);

if (count($listarTarifasProductosPorIdYTipoVehiculo) > 0) {

	$val_cliente = 0;
	$val_movil = 0;

	if ($tipo_tarifa == 'fija') {
		
		if ($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_recorrido'] != NULL) {
			
			$val_recorrido = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_recorrido']);

			$val_cliente = $val_recorrido->{'cliente'};
			$val_movil = $val_recorrido->{'movil'};

		}

		if ($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_hora'] != NULL) {
			
			$val_hora = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_hora']);

			$date1 = date("Y-m-d H:i:s", strtotime($_POST['fecha_inicial'] . " " . $_POST['hora_inicial']));
			$date2 = date("Y-m-d H:i:s", strtotime($_POST['fecha_final'] . " " . $_POST['hora_final']));
			
			$date1 = new DateTime($date1);
			$date2 = new DateTime($date2);

			$diff = $date1->diff($date2);

			$min = ($diff->d * 24 * 60);
			$min += ($diff->h * 60);
			$min += ($diff->i);

			$val_cliente = round($val_hora->{'cliente'} * ($min / 60));
			$val_movil = round($val_hora->{'movil'} * ($min / 60));
		}

		if (($listarTarifasProductosPorIdYTipoVehiculo[0]['recorridos_x_dia'] != NULL) && ($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_mensual'] != NULL)) {
			
			$recorridos_x_dia = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['recorridos_x_dia']);
			$val_mensual = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_mensual']);

			if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'TODOS'){
				$days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
			}else if ($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
				$month_start = strtotime('first day of this month', time());
				$month_end = strtotime('last day of this month', time());

				/*------------------------------------*/
				$primerDia = date('Y-m-d', $month_start);
				$ultimoDía = date('Y-m-d', $month_end);
				$festivo = 'SD';

				$days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
			}else if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
				$month_start = strtotime('first day of this month', time());
				$month_end = strtotime('last day of this month', time());

				/*------------------------------------*/
				$primerDia = date('Y-m-d', $month_start);
				$ultimoDía = date('Y-m-d', $month_end);
				$festivo = 'S';

				$days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
			}

			$val_cliente = round($val_mensual->{'cliente'} / ($recorridos_x_dia->{'cliente'} * $days));
			$val_movil = round($val_mensual->{'movil'} / ($recorridos_x_dia->{'movil'} * $days));
			
		}

	}else if ($tipo_tarifa == 'relevo') {

		if ($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_relevo_sencillo'] != NULL) {

			$val_relevo_sencillo = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_relevo_sencillo']);

			$val_cliente = $val_relevo_sencillo->{'cliente'};
			$val_movil = $val_relevo_sencillo->{'movil'};

		}

		if ($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_relevo_doble'] != NULL) {

			$val_relevo_doble = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_relevo_doble']);

			$val_cliente = $val_relevo_doble->{'cliente'};
			$val_movil = $val_relevo_doble->{'movil'};
			
		}

	}else if ($tipo_tarifa == 'disponibilidad') {

		$costo_disponibilidad = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_relevo_sencillo']);

		$val_cliente = $costo_disponibilidad->{'cliente'};
		$val_movil = $costo_disponibilidad->{'movil'};

	}else{
		$val_recorrido = json_decode($listarTarifasProductosPorIdYTipoVehiculo[0]['valor_recorrido']);

		$val_cliente = $val_recorrido->{'cliente'};
		$val_movil = $val_recorrido->{'movil'};
	}

	echo $val_cliente . '_' . $val_movil;

}else{
	return 0;
}

?>