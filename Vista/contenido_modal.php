<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");

$ids = $_GET["id"];

$programacion = new Programacion();
$servicio = new TipoServicio();
$vehiculo = new TipoVehiculo();

$detalle = $programacion->solicitudPorId($ids);
$cant_servicios = $detalle[0]['servicios_ida'] + $detalle[0]['servicios_retorno'];
$servicios = $programacion->serviciosPorIdSolicitud($ids);
$cant = count($servicios);
?>
<html lang="es">

<div class="col-lg-12">
<section class="panel">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th>#</th>
<th>Fecha Servicio</th>
<th>Hora servicio</th>
<th>Tipo</th>
<th>Origen</th>
<th>Destino</th>
<th>Pasajero</th>
<th>Estado</th>
<th>Opciones</th>
</tr>
</thead>
<tbody>
<?php if ($cant > 0){ $i = 1; ?>
<?php foreach($servicios as $acti1){?>
<tr>

<td><?php echo $i;?></td>
<td><?php echo $acti1['fecha_servicio'];?></td>
<td><?php echo date('g:i a', strtotime($acti1['hora_servicio']));?></td>
<td><?php echo $acti1['tipo']; ?></td>
<td><?php echo strtr(strtoupper($acti1['origen']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");?></td>
<td><?php echo strtr(strtoupper($acti1['destino']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");?></td>
<td><?php echo strtr(strtoupper($acti1['contacto']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");?></td>
<td>
    <?php 
    if($acti1['estado'] == 'P'){
      echo "PENDIENTE"; 
    } else if($acti1['estado'] == 'C'){
      echo "CANCELADO"; 
    } else if($acti1['estado'] == 'A'){
      echo "ASIGNADO";  
    } else {
      echo "FINALIZADO";
    } 
    ?>
</td>
<td>
	<a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modal_servicio" onclick="modal_servicio(<?php echo $acti1['id_detalle'];?>)">
    	<span class="fa fa-search"></span>
    </a>
    <a href="actualizarServicio.php?ids=<?php echo $acti1['id_detalle'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
        <span class="fa fa-edit"></span>
  	</a>
  	<a href="javascript:void(0)" data-toggle="modal" data-target="#cerrarServicio" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="cerrarServicio(<?php echo $acti1['id_detalle'];?>,<?php echo $acti1['id_solicitud'];?>)">
        <span class="fa fa-close"></span></a>
  	</a>
  	<a href="duplicarSolucitud.php?id_s=<?php echo $acti1['id_detalle']; ?>" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;">
        <span class="fa fa-files-o"></span></a>
  	</a>

</td>
</tr>
<?php $i++; } ?>
<?php } else { ?>
<tr><td colspan="10" align="center">sin registros</td></tr>
<?php } ?>
</tbody>
</table>
</div>


</section>
</div>

</html>