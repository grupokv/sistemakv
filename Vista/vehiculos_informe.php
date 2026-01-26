<?php
$filename = 'informe_vehiculos_todos.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listar();

$hoy = date('Y-m-d');
$limite = date("Y-m-d",strtotime($hoy."+ 5 days")); 

$usuario = new Usuario();
$i = 1;
?>
<table  id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="width:100%">
      		<thead>
      			<tr>
                    <th scope="col">No.</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist">MOVIL</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PLACA</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MARCA Y LINEA</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MODELO</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FECHA REGISTRO</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CIUDAD REGISTRO</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">No. PUERTAS</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CILINDRAJE</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO CARROCERIA</th>
      			    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO COMBUSTIBLE</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NUMERO CHASIS</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NUMERO MOTOR</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO VEHICULO</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO AFILIACION</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EMPRESA AFILIADA</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CANTIDAD DE PASAJEROS</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SERVICIO</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MOVIL</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NOMBRE PROPIETARIO</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DOCUMENTO PROPIETARIO</th>
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
                <tr style="text-align: center;">
                  <td><?php echo $i;?></td>
                  <td><?php echo $lv['numero_movil'] ?></td>
                  <td><?php echo $lv['placa'] ?></td>
                  <td><?php echo $lv['marca'] ?></td>
                  <td><?php echo $lv['modelo'] ?></td>
				  <td><?php echo $lv['fecha_registro'] ?></td>
				  <td><?php echo $lv['ciudad_registro'] ?></td>
				  <td><?php echo $lv['num_puertas'] ?></td>
				  <td><?php echo $lv['cilindraje'] ?></td>
				  <td><?php echo $lv['tipo_carroceria'] ?></td>
				  <td><?php echo $lv['tipo_combustible'] ?></td>
                  <td><?php echo $lv['numero_chasis'] ?></td>
                  <td><?php echo $lv['numero_motor'] ?></td>
                  <td><?php echo $lv['nombre_tipo_vehiculo'] ?></td>
                  <td><?php echo $lv['tipo_afiliacion'] ?></td>
                  <td><?php echo $lv['empresa_afiliada'] ?></td>
                  <td><?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cant_pasajeros'] . " Pasajero";
                      }else{
                            echo $lv['cant_pasajeros'] . " Pasajeros";
                      }?></td>
                  <td><?php echo $lv['nombre_tipo_servicio'] ?></td>
                  <td><?php echo $lv['numero_movil'] ?></td>
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
                  <td><?php echo $lv['fecha_nac_propietario'] ?></td>
                  <td><?php echo $lv['direccion_propietario'] ?></td>
                  <td><?php echo $lv['telefono_propietario'] ?></td>
                    <td><?php echo $lv['num_tarjeta_operacion'] ?></td>
                    <td>
                        <?php if($lv['tarjeta_operacion'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['tarjeta_operacion'];?>" target="_blank"><?php echo $lv['tarjeta_operacion'];?></a>
                        <?php } ?>
                    </td>  
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_to']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_to']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_to']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>">
                        <?php echo $lv['fecha_vencimiento_to'] ?>
                    </td>
                    <td>
                        <?php if($lv['licencia_transito'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['licencia_transito'];?>" target="_blank"><?php echo $lv['licencia_transito'];?></a>
                        <?php } ?>
                    </td>  
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_lt']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_lt']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_lt']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_lt'] ?></td>
                    <td>
                        <?php if($lv['soat'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['soat'];?>" target="_blank"><?php echo $lv['soat'];?></a>
                        <?php } ?>
                    </td> 
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_soat']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_soat']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_soat']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_soat'] ?></td>
                    <td>
                        <?php if($lv['revision_tecnomecanica'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['revision_tecnomecanica'];?>" target="_blank"><?php echo $lv['revision_tecnomecanica'];?></a>
                        <?php } ?>
                    </td>  
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_rt']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_rt']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_rt']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_rt'] ?></td>
                    <td>
                        <?php if($lv['revision_preventiva'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['revision_preventiva'];?>" target="_blank"><?php echo $lv['revision_preventiva'];?></a>
                        <?php } ?>
                    </td> 
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_rp']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_rp']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_rp']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_rp'] ?></td>
                    <td>
                        <?php if($lv['poliza_contra'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['poliza_contra'];?>" target="_blank"><?php echo $lv['poliza_contra'];?></a>
                        <?php } ?>
                    </td>  
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_contra']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_contra']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_contra']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_contra'] ?></td>
                    <td>
                        <?php if($lv['disp_velocidad'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['disp_velocidad'];?>" target="_blank"><?php echo $lv['disp_velocidad'];?></a>
                        <?php } ?>
                    </td> 
                    <?php 
                        if(strtotime($lv['fecha_exp_disp_velocidad']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_exp_disp_velocidad']) >= strtotime($hoy))&&(strtotime($lv['fecha_exp_disp_velocidad']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_exp_disp_velocidad'] ?></td>
                    <td>
                        <?php if($lv['seguro_todo_riesgo'] == ''){ ?>
                            <p>NO</p>
                        <?php }else{ ?>
                            <a href="http://www.sistemakv.com/Documentos/Vehiculos/<?php echo $lv['placa'];?>/<?php echo $lv['seguro_todo_riesgo'];?>" target="_blank"><?php echo $lv['seguro_todo_riesgo'];?></a>
                        <?php } ?>
                    </td>  
                    <?php 
                        if(strtotime($lv['fecha_vencimiento_seguro_todo_riesgo']) < strtotime($hoy)){ 
                            $bg = '#E92E04'; 
                        } else if((strtotime($lv['fecha_vencimiento_seguro_todo_riesgo']) >= strtotime($hoy))&&(strtotime($lv['fecha_vencimiento_seguro_todo_riesgo']) < strtotime($limite) )){
                            $bg = '#F0F002'; 
                        } else {
                            $bg = '#23C104'; 
                        }
                    ?>
                    <td style="background-color:<?php echo $bg;?>"><?php echo $lv['fecha_vencimiento_seguro_todo_riesgo'] ?></td>
                  
                  <td><?php echo $lv['flota_propia'] ?></td>
                  <td><?php if($lv['id_empresa'] == 1){ echo 'ORT'; } else if($lv['id_empresa'] == 2){ echo 'LINEAS PREMIUM'; } else { echo $lv['id_empresa']; } ?></td>
                  <td>
                    <?php 
                      if($lv['estado'] == 0){
                        echo "Inactivo";
                      } else if($lv['estado'] == 1){
                        echo "Activo";
                      } else if($lv['estado'] == 2){
                        echo "Desvinculado";
                      } else if($lv['estado'] == 3){
                        echo "Retirado";
                      }
                    ?>
                  </td>       
              </tr>
            <?php $i++; } ?>
    		  </tbody>
    	  </table>
  