<?php
$filename = 'BaseOrt.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

require_once("../../Modelo/Vehiculo.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/TipoVehiculo.php");
require_once("../../Modelo/Conductor.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listarBaseOrt();

$usuario = new Usuario();
$tipovehiculo = new TipoVehiculo();
$conductor = new Conductor();
?>

<table  id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="width:100%">
  	<thead>
  		<tr>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist">MOVIL</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PLACA</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MARCA Y LINEA</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MODELO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CANTIDAD DE PASAJEROS</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MOTOR</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CHASIS</th>              
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">N° DE PUERTAS</th>              
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CILINDRAJE</th>              
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO CARROCERIA</th>              
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO COMBUSTIBLE</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO VEHICULO</th>              
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NOMBRE PROPIETARIO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DOCUMENTO PROPIETARIO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FOTOCOPIA CEDULA</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FECHA NAC PROPIETARIO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DIRECCION PROPIETARIO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TELEFONO PROPIETARIO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># TARJETA OPERACION</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">T.O.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO T.O.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">L.T.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EXPEDICION L.T.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SOAT</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO SOAT</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">R.T.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO R.T.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">R.P.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO R.P.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">POLIZAS</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO POLIZAS</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">D.V.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EXPEDICION D.V.</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SEGURO TODO RIESGO</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO S.T.R</th>
              

            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FLOTA PROPIA</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EMPRESA</th>
            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">ESTADO</th>
  	    </tr>
  	</thead>
    <tbody>
        <?php foreach ($listarV as $lv){ ?>
              <?php $cant_v = $vehiculo->listarConductoresPorId($lv['id_vehiculo']);?>
              <?php $c = count($cant_v); if($c < 1){ $c = 1; } ?>
              <tr>
                  <td><?php echo $lv['numero_movil'] ?></td>
                  <td><?php echo $lv['placa'] ?></td>
                  <td><?php echo $lv['marca'] ?></td>
                  <td><?php echo $lv['modelo'] ?></td>
                  
                  <td><?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cant_pasajeros'] . " Pasajero";
                      }else{
                            echo $lv['cant_pasajeros'] . " Pasajeros";
                      }?>
                  </td>
                  <td><?php echo $lv['numero_motor'] ?></td>
                  <td><?php echo $lv['numero_chasis'] ?></td>
                  <td><?php echo $lv['num_puertas'] ?></td>
                  <td><?php echo $lv['cilindraje'] ?></td>
                  <td><?php echo $lv['tipo_carroceria'] ?></td>
                  <td><?php echo $lv['tipo_combustible'] ?></td>
                  <td>
                    <?php $tipov = $tipovehiculo->listarPorId($lv['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
                  </td>
                  <td>
                    <?php
                      $listarUsuario = $usuario->listarPropietariosPorId($lv['id_propietario']);
                      echo $listarUsuario[0]['nombre'];
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $listarUsuario[0]['usuario'];
                    ?>
                  </td>
                    <td>
                        <?php if($lv['fotocopia_cedula_propietario'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['fotocopia_cedula_propietario'];?>" target="_blank"><?php echo $lv['fotocopia_cedula_propietario'];?></a>
                        <?php } ?>
                    </td>  
                    <td>
                        <?php echo $lv['fecha_nac_propietario'] ?>
                    </td>
                    <td>
                        <?php echo $lv['direccion_propietario'] ?>
                    </td>
                    <td><?php echo $lv['telefono_propietario'] ?></td>
                    <td><?php echo $lv['num_tarjeta_operacion'] ?></td>
                    <td>
                        <?php if($lv['tarjeta_operacion'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['tarjeta_operacion'];?>" target="_blank"><?php echo $lv['tarjeta_operacion'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_to'] ?></td>
                    <td>
                        <?php if($lv['licencia_transito'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['licencia_transito'];?>" target="_blank"><?php echo $lv['licencia_transito'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_lt'] ?></td>
                    <td>
                        <?php if($lv['soat'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['soat'];?>" target="_blank"><?php echo $lv['soat'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_soat'] ?></td>
                    <td>
                        <?php if($lv['revision_tecnomecanica'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['revision_tecnomecanica'];?>" target="_blank"><?php echo $lv['revision_tecnomecanica'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_rt'] ?></td>
                    <td>
                        <?php if($lv['revision_preventiva'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['revision_preventiva'];?>" target="_blank"><?php echo $lv['revision_preventiva'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_rp'] ?></td>
                    <td>
                        <?php if($lv['poliza_contra'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['poliza_contra'];?>" target="_blank"><?php echo $lv['poliza_contra'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_contra'] ?></td>
                    <td>
                        <?php if($lv['disp_velocidad'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['disp_velocidad'];?>" target="_blank"><?php echo $lv['disp_velocidad'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_exp_disp_velocidad'] ?></td>
                    <td>
                        <?php if($lv['seguro_todo_riesgo'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['seguro_todo_riesgo'];?>" target="_blank"><?php echo $lv['seguro_todo_riesgo'];?></a>
                        <?php } ?>
                    </td>  
                    <td><?php echo $lv['fecha_vencimiento_seguro_todo_riesgo'] ?></td>
                  
                  <td><?php echo $lv['flota_propia'] ?></td>
                  <td><?php if($lv['numero_movil'] == 0){ 
                          echo 'CONVENIO'; 
                        } else if (($lv['numero_movil'] >= 1)&&($lv['numero_movil'] <= 999)){ 
                          echo 'ORT'; 
                        } else if (($lv['numero_movil'] >= 1000)&&($lv['numero_movil'] <= 1999)){ 
                          echo 'LINEAS PREMIUM';
                        }  ?></td>
                  <td>
                    <?php 
                      if($lv['estado'] == 1){
                        echo "Activo";
                      } else{
                        echo "Inactivo";
                      } 
                    ?>
                  </td>
              </tr>

        <?php } ?>
	  </tbody>
</table>
  