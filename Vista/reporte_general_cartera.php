<?php
$hoy = date('Ymd_His');
$filename = $hoy.'_reporte_general_cartera.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

include ("../Controlador/Sesion/autenticar.php");
require_once ('../Modelo/Cartera.php');

$cartera = new Cartera();

$listado = $cartera->reporteGeneral();
$total_cartera = 0;
?>

<table class=" text-center  style="width:100%">
		<thead>
			<tr>
				<th>PLACA</th>
				<th>NUMERO MOVIL</th>					
				<th>TOTAL CARTERA</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($listado as $ls){ ?>
				<tr>
					<td><?php echo $ls['placa']; ?></td>
					<td><?php echo $ls['numero_movil']; ?></td>
					<td><?php echo number_format($ls['total'],0,',','.'); ?></td>
					<?php $total_cartera = $total_cartera + $ls['total']; ?>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" align="center"><b><?php echo "TOTAL DE CARTERA GENERAL ".number_format($total_cartera,0,',','.');?></b></td>
			</tr>
		</tfoot>
</table>
