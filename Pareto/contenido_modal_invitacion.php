<?php
session_start();
require('bd/datos.php');
$idp = $_GET["id"];

$querys = new consultas;
$invitados = $querys->invitacion_actividad($idp);
$cantact = count($invitados);

?>
<html lang="es">
<?php include('head.php');?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><!-- date picker -->
  
<div class="col-lg-12">
<section class="panel">
<header align="right">
</header>
<div class="table-responsive">
<table class="table">

<thead>
<tr>
<th>#</th>
<th>Invitado</th>
<th>Estado</th>
<th>Respuesta</th>
</tr>
</thead>
<tbody>
<?php if ($cantact > 0){ $i = 1; ?>
<?php foreach($invitados as $acti1){?>
<tr>

<td><?php echo $i;?></td>
<td><?php $user = $querys->usuarioid($acti1['id_invitado']); echo $user[0]['nombre'];?></td>
<td>
	<?php
	if($acti1['estado'] == 'P'){
		$estado = 'Pendiente';
	} else if ($acti1['estado'] == 'A') {
		$estado = 'Aceptada';
	} else if ($acti1['estado'] == 'R') {
		$estado = 'Rechazada';
	}
	echo $estado;
	?>
</td>
<td><?php echo $acti1['respuesta'];?></td>
</tr>
<?php $i++; } ?>
<?php } else { ?>
<tr><td colspan="5" align="center">sin registros</td></tr>
<?php } ?>
</tbody>
</table>
</div>


</section>
</div>
</html>