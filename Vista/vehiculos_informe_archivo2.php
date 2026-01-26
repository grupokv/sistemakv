<?php 
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Conductor.php");

$vehiculo = new vehiculo();
$listarV = $vehiculo->listarVehiculoFlotaPropia();

$usuario = new Usuario();
$tipovehiculo = new TipoVehiculo();
$conductor = new Conductor();


include("Template/styles.php"); 
?>

<table  id="dataT" class="table" style="width:100%">
      		<thead>
      			<tr>
              <th>MOVIL</th>
              <th>PLACA</th>
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
              
              <!--INICIO CONDUCTORES-->
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
              <!--FIN CONDUCTORES-->

              <th>FLOTA PROPIA</th>
              <th>EMPRESA</th>
              <th>ESTADO</th>
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
                  <td>
                    <?php $tipov = $tipovehiculo->listarPorId($lv['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
                  </td>
                  
                  <td><?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cant_pasajeros'] . " Pasajero";
                      }else{
                            echo $lv['cant_pasajeros'] . " Pasajeros";
                      }?>
                  </td>
                  <td><?php echo $lv['numero_motor'] ?></td>
                  <td><?php echo $lv['numero_chasis'] ?></td>
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
                  <td><?php echo $lv['fecha_vencimiento_to'] ?></td>
                  <td><?php echo $lv['fecha_vencimiento_lt'] ?></td>
                  <td><?php echo $lv['fecha_vencimiento_soat'] ?></td>
                  <td><?php echo $lv['fecha_vencimiento_rt'] ?></td>
                  <td><?php echo $lv['fecha_vencimiento_rp'] ?></td>
                  <td><?php echo $lv['fecha_vencimiento_contra'] ?></td>
                  <td><?php echo $lv['fecha_exp_disp_velocidad'] ?></td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['nombre_conductor'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['numero_documento_conductor'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['fecha_nacimiento_conductor'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['fecha_vencimiento_licencia'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['categoria_licencia'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['direccion'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['grupo_sanguineo'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['estado_civil'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['telefono1'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['telefono2'].'<br/>';?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php foreach($cant_v as $cond){ ?>
                      <?php $datos_c = $conductor->listarPorId($cond['id_conductor']);?>
                      <?php echo $datos_c[0]['telefono3'].'<br/>';?>
                    <?php } ?>
                  </td>
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