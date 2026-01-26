<?php 

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte-VehiculosContrato.xls');


require_once '../Modelo/Vehiculo-Contrato.php';
require_once '../Modelo/TipoVehiculo.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';


$id_contrato = $_GET['id_contrato'];

$tipo_contrato_base = "BASE";
$tipo_contrato_apoyo = "APOYO";

$tipovehiculo = new TipoVehiculo();
$usuario = new Usuario();
$vehiculoContrato = new Vehiculo_Contrato();
$conductor = new Conductor();
$vehiculo = new Vehiculo();

$listarPorTipoContratoBase = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_base);


$listarPorTipoContratoApoyo = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_apoyo);

?>

<table>
	<thead>
		<tr style="text-align: center;">

			<!-- VEHICULOS-->
          	<th>PLACA</th>
          	<th>MOVIL</th>
          	<th>MARCA Y LINEA</th>
          	<th>MODELO</th>
          	<th>TIPO VEHICULO</th>
          	<th>CANTIDAD DE PASAJEROS</th>
          	<th>MOTOR</th>
          	<th>CHASIS</th>              
          	<th>NOMBRE PROPIETARIO</th>
          	<th>DOCUMENTO PROPIETARIO</th>
          	<th>FECHA NAC PROPIETARIO</th>
          	<th>DIRECCION PROPIETARIO</th>
          	<th>TELEFONO PROPIETARIO</th>
          	<th># TARJETA OPERACION</th>
          	<th>VENCIMIENTO T.O.</th>
          	<th>EXPEDICION L.T.</th>
          	<th>VENCIMIENTO SOAT</th>
          	<th>VENCIMIENTO R.T.</th>
          	<th>VENCIMIENTO R.P.</th>
          	<th>VENCIMIENTO POLIZAS</th>
          	<th>EXPEDICION D.V.</th>
            <th>FLOTA PROPIA</th>
            <th>EMPRESA</th>
            <th>ESTADO</th>
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
				$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($ltcb['id_vehiculo']);
				$cant = count($listarConductorPorVehiculo);
			?>
			<tr style="text-align: center;">

				<td <?php if($cant != 0){ ?> rowspan="<?php echo $cant ?>" <?php } ?> ><?php echo $ltcb['placa']; ?></td>
				<td rowspan="<?php echo $cant ?>"><?php echo $ltcb['numero_movil']; ?></td>
				<td rowspan="<?php echo $cant ?>"><?php echo $ltcb['marca']; ?></td>
				<td rowspan="<?php echo $cant ?>"><?php echo $ltcb['modelo']; ?></td>
				<td rowspan="<?php echo $cant ?>">
                    <?php $tipov = $tipovehiculo->listarPorId($ltcb['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
                </td>
                <td rowspan="<?php echo $cant ?>">
                	<?php 
                		if($ltcb['cant_pasajeros'] == 1){
                            echo $ltcb['cant_pasajeros'] . " Pasajero";
                      	}else{
                            echo $ltcb['cant_pasajeros'] . " Pasajeros";
                      	}
                    ?>
                </td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['numero_motor'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['numero_chasis'] ?></td>
                <td rowspan="<?php echo $cant ?>">
                    <?php
                      	$listarUsuario = $usuario->listarPropietariosPorId($ltcb['id_propietario']);
                      	echo $listarUsuario[0]['nombre'];
                    ?>
		        </td>
		        <td rowspan="<?php echo $cant ?>">
	                <?php
		                echo $listarUsuario[0]['usuario'];
	                ?>
		        </td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_nac_propietario'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['direccion_propietario'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['telefono_propietario'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['num_tarjeta_operacion'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_to'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_lt'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_soat'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_rt'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_rp'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_vencimiento_contra'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['fecha_exp_disp_velocidad'] ?></td>
                <td rowspan="<?php echo $cant ?>"><?php echo $ltcb['flota_propia'] ?></td>
				<td rowspan="<?php echo $cant ?>">
                	<?php 
                		if($ltcb['numero_movil'] == 0){ 
                          echo 'CONVENIO'; 
                        } else if (($ltcb['numero_movil'] >= 1)&&($ltcb['numero_movil'] <= 999)){ 
                          echo 'ORT'; 
                        } else if (($ltcb['numero_movil'] >= 1000)&&($ltcb['numero_movil'] <= 1999)){ 
                          echo 'LINEAS PREMIUM';
                        }  
                    ?>
                </td>
                <td rowspan="<?php echo $cant ?>">
                    <?php 
                      	if($ltcb['estado'] == 1){
                        	echo "Activo";
                      	} else{
                        	echo "Inactivo";
                      	} 
                    ?>
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
				$listarConductorPorVehiculo2 = $vehiculo->listarConductoresPorId($ltca['id_vehiculo']);
				$cant2 = count($listarConductorPorVehiculo2);
			?>
			<tr style="text-align: center;">
				<td <?php if($cant2 != 0){ ?> rowspan="<?php echo $cant2 ?>" <?php } ?>><?php echo $ltca['placa']; ?></td>
				<td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['numero_movil']; ?></td>
				<td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['marca']; ?></td>
				<td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['modelo']; ?></td>
				<td rowspan="<?php echo $cant2 ?>">
                    <?php $tipov = $tipovehiculo->listarPorId($ltca['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
                </td>
                <td rowspan="<?php echo $cant2 ?>">
                	<?php 
                		if($ltca['cant_pasajeros'] == 1){
                            echo $ltca['cant_pasajeros'] . " Pasajero";
                      	}else{
                            echo $ltca['cant_pasajeros'] . " Pasajeros";
                      	}
                    ?>
                </td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['numero_motor'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['numero_chasis'] ?></td>
                <td rowspan="<?php echo $cant2 ?>">
                    <?php
                      	$listarUsuario = $usuario->listarPropietariosPorId($ltca['id_propietario']);
                      	echo $listarUsuario[0]['nombre'];
                    ?>
		        </td>
		        <td rowspan="<?php echo $cant2 ?>">
	                <?php
		                echo $listarUsuario[0]['usuario'];
	                ?>
		        </td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_nac_propietario'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['direccion_propietario'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['telefono_propietario'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['num_tarjeta_operacion'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_to'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_lt'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_soat'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_rt'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_rp'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_vencimiento_contra'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['fecha_exp_disp_velocidad'] ?></td>
                <td rowspan="<?php echo $cant2 ?>"><?php echo $ltca['flota_propia'] ?></td>
                <td rowspan="<?php echo $cant2 ?>">
                	<?php 
                		if($ltca['numero_movil'] == 0){ 
                          echo 'CONVENIO'; 
                        } else if (($ltca['numero_movil'] >= 1)&&($ltca['numero_movil'] <= 999)){ 
                          echo 'ORT'; 
                        } else if (($ltca['numero_movil'] >= 1000)&&($ltca['numero_movil'] <= 1999)){ 
                          echo 'LINEAS PREMIUM';
                        }  
                    ?>
                </td>
                <td rowspan="<?php echo $cant2 ?>">
                    <?php 
                      	if($ltca['estado'] == 1){
                        	echo "Activo";
                      	} else{
                        	echo "Inactivo";
                      	} 
                    ?>
                </td>
                <td rowspan="<?php echo $cant2 ?>">APOYO</td>

                <!-- CONDUCTORES-->

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