<?php
/*$filename = 'informe.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);*/

require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once '../Modelo/Contrato.php';
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");

$contrato = new Contrato();
$vehiculoContrato = new Vehiculo_Contrato();
$cliente = new Cliente();
$empresa = new Empresa();

$vehiculo = new vehiculo();
$listarV = $vehiculo->listarVehiculoActivos();
//$listarV = $vehiculo->listarVehiculoInactivos();

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
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CONTRATO BASE</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CONTRATO APOYO</th>
      			</tr>
      		</thead>
    		  <tbody>
            <?php foreach ($listarV as $lv){ 

                    $tipo_contrato_apoyo = "APOYO";
                    $listarContratosApoyo = $vehiculoContrato->listarContratosApoyo($lva['id_vehiculo'], $tipo_contrato_apoyo);

                    $tipo_contrato_base = "BASE";
                    $listarContratosBase = $vehiculoContrato->listarContratosBase($lva['id_vehiculo'], $tipo_contrato_base);

                    $cant_v = $vehiculo->listarConductoresPorId($lv['id_vehiculo']);
                    $c = count($cant_v); if($c < 1){ $c = 1; } 
                  ?>
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
                  <td>
                      <?php 
                          
                          $listarContratosIdBase = $contrato->listarId($listarContratosBase[0]['id_contrato']);
                          $emp = $empresa->listarPorId($listarContratosIdBase[0]['id_empresa']);
                          $cli = $cliente->listarClientePorId($listarContratosIdBase[0]['id_cliente']);

                          if (count($listarContratosBase) > 0) {
                              
                              echo "No. INTERNO ". $listarContratosBase[0]['id_contrato']." - CONTRATO No.° " . $ltc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'];
                          }else{
                              echo "SIN CONTRATO BASE ANCLADO";
                          }
                      ?>
                  </td>      
                  <td>
                      <?php  

                          $listarContratosIdApoyo = $contrato->listarId($listarContratosApoyo[0]['id_contrato']);
                          $emp = $empresa->listarPorId($listarContratosIdApoyo[0]['id_empresa']);
                          $cli = $cliente->listarClientePorId($listarContratosIdApoyo[0]['id_cliente']);

                          if (count($listarContratosApoyo) > 0) {
                              
                              foreach ($listarContratosApoyo as $lca) {
                                  echo "No. INTERNO ". $lca['id_contrato']." - CONTRATO No. " . $ltc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa'] . ' | - | ';
                              }
                          }else{
                              echo "SIN CONTRATO APOYO ANCLADO";
                          }
                      ?>
                  </td>
              </tr>

            <?php } ?>
    		  </tbody>
    	  </table>
  