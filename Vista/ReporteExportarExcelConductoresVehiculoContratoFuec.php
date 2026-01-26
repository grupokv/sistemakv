<?php 

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte_ConductoresVehiculosContrato.xls');

require_once('../Modelo/Vehiculo-Contrato.php');
require_once('../Modelo/Usuario.php');
require_once('../Modelo/Vehiculo.php');
require_once('../Modelo/Conductor.php');

$id_contrato = $_GET['id_contrato'];

$tipo_contrato_base = "BASE";
$tipo_contrato_apoyo = "APOYO";

$vehiculoContrato = new Vehiculo_Contrato();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();

$listarPorTipoContratoBase = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_base);
//print_r($listarPorTipoContratoBase);

$listarPorTipoContratoApoyo = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_apoyo);

?>

<table>
	<thead>
		<tr style="text-align: center;">

			<!-- VEHICULOS-->
          	<th>PLACA</th>
          	<th>TIPO CONTRATO</th>

			<!-- CONDUCTORES-->
            <th>NOMBRE CONDUCTOR</th>
            <th>N° DOCUMENTO</th>
            <th>FECHA NACIMIENTO</th>
            <th>FECHA VEN. LICENCIA</th>
            <th>CATEGORIA</th>
            <th>DIRECCION</th>
            <th>RH</th>
            <th>ESTADO CIVIL</th>
            <th>TELEFONO 1</th>
            <th>TELEFONO 2</th>
            <th>TELEFONO 3</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listarPorTipoContratoBase as $ltcb){ 

        		$id_veh = $ltcb['id_vehiculo'];
				$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($ltcb['id_vehiculo']);
				$cant = count($listarConductorPorVehiculo); ?>

			<tr style="text-align: center;">

				<td <?php if($cant != 0){ ?> rowspan="<?php echo $cant ?>" <?php } ?> >
					<?php echo $ltcb['placa']; ?>
				</td>
                <td rowspan="<?php echo $cant ?>">BASE</td>

			<?php foreach ($listarConductorPorVehiculo as $lcpv){ ?>
				
					<!-- CONDUCTORES-->

					<td><?php echo $lcpv['nombre_conductor'] ?></td>
					<td><?php echo $lcpv['numero_documento_conductor'] ?></td>
					<td><?php echo $lcpv['fecha_nacimiento_conductor'] ?></td>
					<td><?php echo $lcpv['fecha_vencimiento_licencia'] ?></td>
					<td><?php echo $lcpv['categoria_licencia'] ?></td>
					<td><?php echo $lcpv['direccion'] ?></td>
					<td><?php echo $lcpv['grupo_sanguineo'] ?></td>
					<td><?php echo $lcpv['estado_civil'] ?></td>
					<td><?php echo $lcpv['telefono1'] ?></td>
					<td><?php echo $lcpv['telefono2'] ?></td>
					<td><?php echo $lcpv['telefono3'] ?></td>

				</tr>
			<?php } ?>
			
		<?php } ?>


		<?php foreach ($listarPorTipoContratoApoyo as $ltca){
        		$id_veh1 = $ltca['id_vehiculo'];
				$listarConductorPorVehiculo2 = $vehiculo->listarConductoresPorId($ltca['id_vehiculo']);
				$cant2 = count($listarConductorPorVehiculo2); ?>

			<tr style="text-align: center;">
				<td <?php if($cant2 != 0){ ?> rowspan="<?php echo $cant2 ?>" <?php } ?>><?php echo $ltca['placa']; ?></td>
                <td rowspan="<?php echo $cant2 ?>">APOYO</td>

				<?php foreach ($listarConductorPorVehiculo2 as $lcpv2){ ?>
				
					<!-- CONDUCTORES-->
					<td><?php echo $lcpv2['nombre_conductor'] ?></td>
					<td><?php echo $lcpv2['numero_documento_conductor'] ?></td>
					<td><?php echo $lcpv2['fecha_nacimiento_conductor'] ?></td>
					<td><?php echo $lcpv2['fecha_vencimiento_licencia'] ?></td>
					<td><?php echo $lcpv2['categoria_licencia'] ?></td>
					<td><?php echo $lcpv2['direccion'] ?></td>
					<td><?php echo $lcpv2['grupo_sanguineo'] ?></td>
					<td><?php echo $lcpv2['estado_civil'] ?></td>
					<td><?php echo $lcpv2['telefono1'] ?></td>
					<td><?php echo $lcpv2['telefono2'] ?></td>
					<td><?php echo $lcpv2['telefono3'] ?></td>

				</tr>
			<?php } ?>
		<?php } ?>

		
	</tbody>
</table>