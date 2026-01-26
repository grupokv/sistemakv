<?php
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");

$conductor = new Conductor();
$vehiculo = new Vehiculo();
$listarC = $conductor->listar();

 ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    
    
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
                    <th>NOMBRE</th>
                    <th>N° DOCUMENTO</th>
                    <th>FECHA NACIMIENTO</th>
                    <th>FECHA VEN. LICENCIA</th>
                    <th>DIRECCION</th>
                    <th>RH</th>
                    <th>ESTADO CIVIL</th>
                    <th>TELEFONO 1</th>
                    <th>TELEFONO 2</th>
                    <th>TELEFONO 3</th>
                    <th>VEHICULOS</th>
                    <th>ESTADO</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php foreach ($listarC as $lc){ ?>
                    <tr>
                        <td><?php echo $lc['nombre_conductor'] ?></td>
                        <td><?php echo $lc['numero_documento_conductor'] ?></td>
                        <td><?php echo $lc['fecha_nacimiento_conductor'] ?></td>
                        <td><?php echo $lc['fecha_vencimiento_licencia'] ?></td>
                        <td><?php echo $lc['direccion'] ?></td>
                        <td><?php echo $lc['grupo_sanguineo'] ?></td>
                        <td>
                            <?php if($lc['estado_civil'] == 'S'){echo "SOLTERO";}else if($lc['estado_civil'] == 'C'){echo "CASADO";}else if($lc['estado_civil'] == 'D'){echo "DIVORCIADO";}else if($lc['estado_civil'] == 'U'){echo "UNION LIBRE";} else { echo 'VIUDO';}?>
                        </td>
                        <td><?php echo $lc['telefono1'] ?></td>
                        <td><?php echo $lc['telefono2'] ?></td>
                        <td><?php echo $lc['telefono3'] ?></td>
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
                            <?php if ($lc['estado'] == 1){ echo "Activo"; } else { echo "Inactivo"; } ?>
                        </td>
                        
                </tr>
                <?php } ?>
    		</tbody>
    	</table>