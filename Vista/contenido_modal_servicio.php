<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");require_once("../Modelo/TipoServicioCliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");

$ids = $_GET["ids"];

$programacion = new Programacion();
$servicio = new TipoServicio();$servicio_cliente = new TipoServicioCliente();
$vehiculo = new TipoVehiculo();
$modVehiculo = new Vehiculo();
$modConductor = new Conductor();

$cant_servicios = $detalle[0]['servicios_ida'] + $detalle[0]['servicios_retorno'];
$servicios = $programacion->serviciosPorIdDetalle($ids);
$cant = count($servicios);

setlocale(LC_ALL,"es_CO.utf8");
?>
<html lang="es">

<div class="col-lg-12">
<section class="panel">
<div class="table-responsive">
<table class="table">
<tbody>
	<tr>
		<td style="border: none;"><b>TIPO</b></td>
		<td style="border: none;"><?php echo $servicios[0]['tipo'];?></td>
		<td style="border: none;"><b>FECHA SERVICIO</b></td>
		<td style="border: none;"><?php echo date('d-m-Y',strtotime($servicios[0]['fecha_servicio']));?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>HORA SERVICIO</b></td>
		<td style="border: none;"><?php echo strtoupper(date('g:i a',strtotime($servicios[0]['hora_servicio']))); ?></td>
		<td style="border: none;"><b>CONTACTO</b></td>
		<td style="border: none;"><?php echo $servicios[0]['contacto'];?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>TELEFONO CONTACTO</b></td>
		<td style="border: none;"><?php echo $servicios[0]['telefono_contacto'];?></td>
		<td style="border: none;"><b>CANTIDAD PASAJEROS</b></td>
		<td style="border: none;"><?php echo $servicios[0]['cantidad'];?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>LISTADO</b></td>
		<td style="border: none;">
			<?php if($servicios[0]['listado'] != ''){ ?>
			<a href="../Servicios/<?php echo $servicios[0]['listado'];?>" target="_blank">
				<?php echo $servicios[0]['listado'];?>
			</a>
			<?php } ?>
		</td>
		<td style="border: none;"><b>TIPO VEHICULO</b></td>
		<td style="border: none;"><?php $tipo_vehiculo = $vehiculo->listarPorId($servicios[0]['id_tipovehiculo']); echo $tipo_vehiculo[0]['nombre_tipo_vehiculo'];?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>TIPO SERVICIO</b></td>
		<td style="border: none;">                <?php if($servicios[0]['id_solicitud'] != 0){ ?>
		<?php $tipo_servicio = $servicio->listarPorIdCliente($servicios[0]['id_tiposervicio']); echo $tipo_servicio[0]['nombre_tipo_servicio'];?>		<?php } else { ?>		<?php $tipo_servicio = $servicio_cliente->listarPorId($servicios[0]['id_tiposervicio']); echo $tipo_servicio[0]['detalle'];?>		<?php } ?>
		</td>
		<td style="border: none;"><b>ORIGEN</b></td>
		<td style="border: none;"><?php echo strtoupper($servicios[0]['origen']); ?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>DESTINO</b></td>
		<td style="border: none;"><?php echo strtoupper($servicios[0]['destino']); ?></td>
		<td style="border: none;"><b>CENTRO COSTO</b></td>
		<td style="border: none;"><?php echo strtoupper($servicios[0]['centro_costo']); ?></td>
	</tr>
	<tr>
		<td style="border: none;"><b>SOLICITANTE</b></td>
		<td style="border: none;"><?php echo strtoupper($servicios[0]['solicitante']); ?></td>
		<td style="border: none;"><b>ESTADO</b></td>
		<td style="border: none;">
			<?php 
			if($servicios[0]['estado'] == 'P'){
				echo "PENDIENTE";	
			} else if($servicios[0]['estado'] == 'C'){
				echo "CANCELADO";	
			} else if($servicios[0]['estado'] == 'A'){
				echo "ASIGNADO";	
			} else {
				echo "FINALIZADO";
			} 
			?>
		</td>
	</tr>
	<tr>
		<td style="border: none;"><b>VALOR</b></td>
		<td style="border: none;"><?php echo '$ '.number_format($servicios[0]['valor'],0,',','.');?></td>
		<td style="border: none;"><b></b></td>
		<td style="border: none;"></td>
	</tr>
	<?php if(($servicios[0]['estado'] == 'A')or($servicios[0]['estado'] == 'F')){ ?>
	<tr>
		<?php
		if($servicios[0]['estado'] == 'A'){
		$datos_asignacion = $programacion->asignadoActivoPorServicio($ids);
		} else {
		$datos_asignacion = $programacion->asignadoFinalizadoPorServicio($ids);
		}
		$datos_vehiculo = $modVehiculo->listarPorId($datos_asignacion[0]['id_vehiculo']);
		$datos_conductor = $modConductor->listarPorId($datos_asignacion[0]['id_conductor']);
		?>
		<td class="mt-2" style="border: none;"><b>PLACA</b></td>
		<td class="mt-2" style="border: none;"><?php echo $datos_vehiculo[0]['placa'];?></td>
		<td class="mt-2" style="border: none;"><b>CONDUCTOR</b></td>
		<td class="mt-2" style="border: none;"><?php echo $datos_conductor[0]['nombre_conductor'];?></td>
	</tr>
	<?php } ?>
</tbody>
</table>
</div>
</section>
</div>

</html>