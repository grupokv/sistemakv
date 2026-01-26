<?php  
require('bd/datos.php');

date_default_timezone_set('America/Bogota');
$querys = new consultas;

$hoy = date('Ymd_His');
$filename = $hoy . '_pareto_usuario.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);


$id_pareto = $_GET['id'];

$actividades1 = $querys->actividades($id_pareto,'1');
$cant1 = count($actividades1);
$actividades2 = $querys->actividades($id_pareto,'2');
$cant2 = count($actividades2);
$actividades3 = $querys->actividades($id_pareto,'3');
$cant3 = count($actividades3);
$actividades4 = $querys->actividades($id_pareto,'4');
$cant4 = count($actividades4);

?>

<!-- LLAMADAS -->
<table class="table" style="text-align: center;">
  	<thead>
		<tr>
			<th colspan="7"><b>LLAMADAS</b></th>
		</tr>
        <tr>
          	<th>#</th>
          	<th><?php utf8_encode("Descripción"); ?></th>
		  	<th>Fecha</th>
		  	<th>Horario</th>
		  	<th>Aplica Objetivo</th>
		  	<th>Objetivo</th>
		  	<th>Estado</th>
        </tr>
    </thead>
    <tbody>
    	<?php if ($cant1 > 0){ ?>
			<?php $i = 1; ?>
			<?php foreach($actividades1 as $act1){ ?>
                <tr>
					<td><?php echo $i;?></td>
                    <td><?php echo $act1['descripcion']; ?></td>
					<td><?php echo $act1['fecha'];?></td>
					<td>
						<?php 
							echo date('h:i A', strtotime($act1['hora'])) . " A " . date('h:i A', strtotime($act1['hora_fin']));
						?>
					</td>
					<td>
						<?php if ($act1['aplica_objetivo'] == 'S'){ ?>
					  		SI 
					  	<?php } else { ?>
					  		NO
					  	<?php } ?>
					</td>
					<td>
						<?php 
							$detalle = $querys->obj_especificosid2($act1['id_objetivo']); 

							if ($act1['aplica_objetivo'] == 'S'){
								echo utf8_decode($detalle[0]['descripcion']); 
							}else{
								echo "-";
							}	
						?>
					</td>
					<td>
						<?php 
							if ($act1['estado'] == 1) {
								echo "CULMINADO";
							}else{
								echo "PENDIENTE";
							}
						?>
					</td>
                </tr>
            	<?php $i++; ?>
            <?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="7">No hay actividades</td>
			</tr>
		<?php } ?>
    </tbody>
</table>

<!-- IMPORTANTES -->
<table class="table"  style="text-align: center;">
  	<thead>
		<tr>
			<th colspan="7"><b>IMPORTANTES</b></th>
		</tr>
        <tr>
          	<th>#</th>
          	<th><?php utf8_encode("Descripción"); ?></th>
		  	<th>Fecha</th>
		  	<th>Horario</th>
		  	<th>Aplica Objetivo</th>
		  	<th>Objetivo</th>
		  	<th>Estado</th>
        </tr>
    </thead>
    <tbody>
    	<?php if ($cant2 > 0){ ?>
			<?php $a = 1; ?>
			<?php foreach($actividades2 as $act2){?>
                <tr>
					<td><?php echo $a;?></td>
                    <td><?php echo utf8_decode($act2['descripcion']);?></td>
					<td><?php echo $act2['fecha'];?></td>
					<td>
						<?php 
							echo date('h:i A', strtotime($act2['hora'])) . " A " . date('h:i A', strtotime($act2['hora_fin']));
						?>
					</td>
					<td>
						<?php if ($act2['aplica_objetivo'] == 'S'){ ?>
					  		SI
					  	<?php } else { ?>
					  		NO
					  	<?php } ?>
					</td>
					<td>
						<?php 
							$detalle = $querys->obj_especificosid2($act2['id_objetivo']); 

							if ($act2['aplica_objetivo'] == 'S'){
								echo utf8_decode($detalle[0]['descripcion']); 
							}else{
								echo "-";
							}	
						?>
					</td>
					<td>
						<?php 
							if ($act2['estado'] == 1) {
								echo "CULMINADO";
							}else{
								echo "PENDIENTE";
							}
						?>
					</td>
                </tr>
            	<?php $a++; ?>
            <?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="7">No hay actividades</td>
			</tr>
		<?php } ?>
    </tbody>
</table>

<!-- FUERA DE TIEMPO -->
<table class="table" style="text-align: center;">
  	<thead>
		<tr>
			<th colspan="7"><b>FUERA DE TIEMPO</b></th>
		</tr>
        <tr>
          	<th>#</th>
          	<th><?php utf8_encode("Descripción"); ?></th>
		  	<th>Fecha</th>
		  	<th>Horario</th>
		  	<th>Aplica Objetivo</th>
		  	<th>Objetivo</th>
		  	<th>Estado</th>
        </tr>
    </thead>
    <tbody>
    	<?php if ($cant3 > 0){ ?>
			<?php $i = 1; ?>
			<?php foreach($actividades3 as $act3){?>
                <tr>
					<td><?php echo $i;?></td>
                    <td><?php echo utf8_decode($act3['descripcion']);?></td>
					<td><?php echo $act3['fecha'];?></td>
					<td>
						<?php 
							echo date('h:i A', strtotime($act3['hora'])) . " A " . date('h:i A', strtotime($act3['hora_fin']));
						?>
					</td>
					<td>
						<?php if ($act3['aplica_objetivo'] == 'S'){ ?>
					  		SI
					  	<?php } else { ?>
					  		NO
					  	<?php } ?>
					</td>
					<td>
						<?php 
							$detalle = $querys->obj_especificosid2($act3['id_objetivo']); 

							if ($act3['aplica_objetivo'] == 'S'){
								echo utf8_decode($detalle[0]['descripcion']); 
							}else{
								echo "-";
							}	
						?>
					</td>
					<td>
						<?php 
							if ($act3['estado'] == 1) {
								echo "CULMINADO";
							}else{
								echo "PENDIENTE";
							}
						?>
					</td>
                </tr>
            	<?php $i++; ?>
            <?php } ?>
		<?php } else { ?>
			<tr>
				<td colspan="7">No hay actividades</td>
			</tr>
		<?php } ?>
    </tbody>
</table>
