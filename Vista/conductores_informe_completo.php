<?php

$filename = 'informeConductores.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");

$conductor = new Conductor();
$vehiculo = new Vehiculo();
$listarC = $conductor->listar();

?>
    
<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
	<thead>
		<tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>N° DOCUMENTO</th>
			<th>CORREO ELECTRONICO</th>
            <th>FECHA NACIMIENTO</th>
            <th>DIRECCION</th>
			<th>GENERO</th>
            <th>RH</th>
            <th>ESTADO CIVIL</th>
            <th>TELEFONO 1</th>
            <th>TELEFONO 2</th>
            <th>TELEFONO 3</th>
			<th>FOTOCOPIA DOCUMENTO</th>
			<th>FOTOCOPIA LICENCIA</th>
			<th>NUM. LICENCIA</th>
			<th>CATEGORIA</th>
            <th>FECHA VEN. LICENCIA</th>
			<th>CERT. LABORALES</th>
			<th>CERT. ESTUDIOS</th>
			<th>CERT. CURSOS</th>
			<th>LIBRETA MILITAR</th>
			<th>EXAMEN MEDICO</th>
			<th>FECHA EXAMEN MEDICO</th>
			<th>FOTOGRAFIA CONDUCTOR</th>
			<th>HOJA DE VIDA</th>
			<th>PROCURADURIA</th>
			<th>PERSONERIA</th>
			<th>CONTRALORIA</th>
			<th>SIMIT</th>
			<th>POLICIA</th>
			<th>RUT</th>
			<th>CARNET VACUNAS</th>
			<th>CONTRATO TRABAJO</th>
            <th>VEHICULOS</th>
            <th>ESTADO</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($listarC as $lc){ ?>
            <tr style="text-align: center;">
				<?php $link = 'http://www.sistemakv.com/Documentos/Conductores/'.$lc['numero_documento_conductor'].'/'; ?>

                <td><?php echo $lc['id_conductor'] ?></td>
                <td><?php echo $lc['nombre_conductor'] ?></td>
                <td><?php echo $lc['numero_documento_conductor'] ?></td>
				<td><?php echo $lc['correo_electronico'] ?></td>
                <td><?php echo $lc['fecha_nacimiento_conductor'] ?></td>
                <td><?php echo $lc['direccion'] ?></td>
				<td>
                    <?php 
                    	if($lc['genero'] == 'M'){ 
                    		echo "MASCULINO"; 
                    	} else { 
                    		echo 'FEMENINO';
                    	}
                    ?>
                </td>
                <td><?php echo $lc['grupo_sanguineo'] ?></td>
                <td>
                    <?php 
                    	if($lc['estado_civil'] == 'S'){
                    		echo "SOLTERO";
                    	}else if($lc['estado_civil'] == 'C'){
                    		echo "CASADO";
                    	}else if($lc['estado_civil'] == 'D'){
                    		echo "DIVORCIADO";
                    	}else if($lc['estado_civil'] == 'U'){
                    		echo "UNION LIBRE";
                    	} else { 
                    		echo 'VIUDO';
                    	}
                    ?>
                </td>
                <td><?php echo $lc['telefono1'] ?></td>
                <td><?php echo $lc['telefono2'] ?></td>
                <td><?php echo $lc['telefono3'] ?></td>
				<td>
					<?php 
						if($lc['fotocopia_documento'] != ''){ 
							echo '<a href="' . $link . $lc["fotocopia_documento"] . '">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['fotocopia_licencia'] != ''){ 
							echo '<a href="'.$link.$lc["fotocopia_liccencia"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td><?php echo $lc['num_licencia'] ?></td>
				<td><?php echo $lc['categoria_licencia'] ?></td>
                <td><?php echo $lc['fecha_vencimiento_licencia'] ?></td>
				<td>
					<?php 
						if($lc['certificados_laborales'] != ''){ 
							echo '<a href="'.$link.$lc["certificados_laborales"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['certificados_estudios'] != ''){ 
							echo '<a href="'.$link.$lc["certificados_estudios"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['certificados_cursos'] != ''){ 
							echo '<a href="'.$link.$lc["certificados_cursos"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['libreta_militar'] != ''){ 
							echo '<a href="'.$link.$lc["libreta_militar"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['examen_medico'] != ''){ 
							echo '<a href="'.$link.$lc["examen_medico"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						echo $lc["fecha_expedicion_examen_medico"]; 
					?>
				</td>
				<td>
					<?php 
						if($lc['fotografia_conductor'] != ''){ 
							echo '<a href="'.$link.$lc["fotografia_conductor"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>		
				</td>
				<td>
					<?php 
						if($lc['hoja_vida'] != ''){ 
							echo '<a href="'.$link.$lc["hoja_vida"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['procuraduria'] != ''){ 
							echo '<a href="'.$link.$lc["procuraduria"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['personeria'] != ''){ 
							echo '<a href="'.$link.$lc["personeria"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['contraloria'] != ''){ 
							echo '<a href="'.$link.$lc["contraloria"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['simit'] != ''){ 
							echo '<a href="'.$link.$lc["simit"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['policia'] != ''){ 
							echo '<a href="'.$link.$lc["policia"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['rut'] != ''){ 
							echo '<a href="'.$link.$lc["rut"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['vacunas'] != ''){ 
							echo '<a href="'.$link.$lc["vacunas"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
				<td>
					<?php 
						if($lc['contrato_trabajo'] != ''){ 
							echo '<a href="'.$link.$lc["contrato_trabajo"].'">S</a>'; 
						} else { 
							echo 'N'; 
						} 
					?>
				</td>
                <td>
                    <?php
	                    $veh = $vehiculo->listarVehiculosPorConductor($lc['id_conductor']);
	                    foreach($veh as $v){
	                      $datos_v = $vehiculo->listarPorId($v['id_vehiculo']);
	                      echo $datos_v[0]['numero_movil'].' | '.$datos_v[0]['placa'].'<br/>';
	                    }
                    ?>
                </td>
                <td>
                    <?php 
                    	if ($lc['estado'] == 1){ 
                    		echo "Activo"; 
                    	} else { 
                    		echo "Inactivo"; 
                    	} 
                    ?>
                </td>
        	</tr>
        <?php } ?>
	</tbody>
</table>

<!-- <script type="text/javascript">
	$(function() {
	   myWindow.close();
	});
</script> -->
