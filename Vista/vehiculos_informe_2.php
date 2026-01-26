<?php
/*$filename = 'informe.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);*/

require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Conductor.php");

$vehiculo = new vehiculo();
//$listarV = $vehiculo->listarVehiculoActivos();
$listarV = $vehiculo->listarVehiculoInactivos();

$usuario = new Usuario();
$tipovehiculo = new TipoVehiculo();
$conductor = new Conductor();

//echo count($listarV);
?>
<table  id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="width:100%">
      		<thead>
      			<tr>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist">MOVIL</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PLACA</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MARCA Y LINEA</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MODELO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TIPO VEHICULO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CANTIDAD DE PASAJEROS</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MOTOR</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CHASIS</th>              
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NOMBRE PROPIETARIO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DOCUMENTO PROPIETARIO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FECHA NAC PROPIETARIO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DIRECCION PROPIETARIO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">TELEFONO PROPIETARIO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># TARJETA OPERACION</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO T.O.</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EXPEDICION L.T.</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO SOAT</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO R.T.</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO R.P.</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">VENCIMIENTO POLIZAS</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EXPEDICION D.V.</th>

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
  