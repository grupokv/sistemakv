<?php
$filename = 'reporteVencimientos.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Contrato.php';
require_once '../Modelo/Cliente.php';
require_once '../Modelo/Vehiculo-Contrato.php';

$vehiculo = new Vehiculo();
$conductor = new Conductor();
$contrato = new Contrato();
$cliente = new Cliente();
$veh_con = new Vehiculo_Contrato();

$hoy = date('Y-m-d');

$fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
$notificarFecha = date('Y-m-d',$fecha);

$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$notificarFecha2 = date('Y-m-d',$fecha2);


/*Tarjeta de Operación*/
$listarToVencidos = $vehiculo->listarDocsToVencidos($notificarFecha);

/*Soat*/
$listarDocsSoatVencidos = $vehiculo->listarDocsSoatVencidos($notificarFecha);

/*Revision Tecnomecanica*/
$listarDocsRtVencidos = $vehiculo->listarDocsRtVencidos($notificarFecha);

/*Revision Preventiva*/
$listarDocsRpVencidos = $vehiculo->listarDocsRpVencidos($notificarFecha);

/*Contractual*/
$listarDocsPcVencidos = $vehiculo->listarDocsPcVencidos($notificarFecha);

/*Extra Contractual*/
$listarDocsPeVencidos = $vehiculo->listarDocspeVencidos($notificarFecha);

$listarDocsDpVencidos = $vehiculo->listarDisposVencidos($notificarFecha2);

/*Licencia*/
$listarDocsConductorLcVencidos = $conductor->listarDocsConductorLcVencidos($notificarFecha);

$to = count($listarToVencidos);
$soat = count($listarDocsSoatVencidos);
$rt = count($listarDocsRtVencidos);
$rp = count($listarDocsRpVencidos);
$pc = count($listarDocsPcVencidos);
$pe = count($listarDocsPeVencidos);
$dv = count($listarDocsDpVencidos);
$lc = count($listarDocsConductorLcVencidos);

$documentos = [$to, $soat, $rt, $rp, $pc, $pe, $dv, $lc];
?>
<body charset="iso-8859-1">
<table  id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="width:100%">
      		<thead>
      			<tr>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist">TIPO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PLACA - No. DOCUMENTO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MOVIL - NOMBRE CONDUCTOR</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">EMPRESA</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DOCUMENTO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">FECHA DE VENCIMIENTO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">ESTADO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">ESTADO VEH/COND</th>              
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CONTRATO BASE</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NO. INTERNO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">NO. OPERACION O CONTRATO</th>
              <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">ESTADO CONTRATO</th>
      			</tr>
      		</thead>
    		  <tbody>
            <!--TARJETA DE OPERACION-->
                        <?php foreach ($listarToVencidos as $ltv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $ltv['placa']; ?></td>
                              <td><?php echo $ltv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($ltv['numero_movil'] == 0){ 
                                    echo 'CONVENIO'; 
                                  } else if (($ltv['numero_movil'] >= 1)&&($ltv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($ltv['numero_movil'] >= 1000)&&($ltv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td><?php echo utf8_decode('TARJETA DE OPERACION');?></td>
                              <td><?php echo $ltv['fecha_vencimiento_to']; ?></td>
                              <td><?php if ($ltv['fecha_vencimiento_to'] <= date('Y-m-d')){echo "VENCIDO";}else if(($ltv['fecha_vencimiento_to'] <= $notificarFecha)&&($ltv['fecha_vencimiento_to'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($ltv['estado'] == 1) { echo 'ACTIVO'; } else if ($ltv['estado'] == 0) { echo 'INACTIVO'; } else if ($ltv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($ltv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>
    
                        <!-- SOAT-->
                        <?php foreach ($listarDocsSoatVencidos as $ldsv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $ldsv['placa']; ?></td>
                              <td><?php echo $ldsv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($ldsv['numero_movil'] == 0){ 
                                    echo 'CONVENIO'; 
                                  } else if (($ldsv['numero_movil'] >= 1)&&($ldsv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($ldsv['numero_movil'] >= 1000)&&($ldsv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>SOAT</td>
                              <td><?php echo $ldsv['fecha_vencimiento_soat']; ?></td>
                              <td><?php if ($ldsv['fecha_vencimiento_soat'] <= date('Y-m-d')){echo "VENCIDO";}else if(($ldsv['fecha_vencimiento_soat'] <= $notificarFecha)&&($ldsv['fecha_vencimiento_soat'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($ldsv['estado'] == 1) { echo 'ACTIVO'; } else if ($ldsv['estado'] == 0) { echo 'INACTIVO'; } else if ($ldsv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($ldsv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>
                     
                      <!-- REVISION TECNO -->
                        <?php foreach ($listarDocsRtVencidos as $lrtv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $lrtv['placa']; ?></td>
                              <td><?php echo $lrtv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($lrtv['numero_movil'] == 0){ echo 'CONVENIO'; 
                                  } else if (($lrtv['numero_movil'] >= 1)&&($lrtv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($lrtv['numero_movil'] >= 1000)&&($lrtv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>REVISIÓN TECNOMECANICA</td>
                              <td><?php echo $lrtv['fecha_vencimiento_rt']; ?></td>
                              <td><?php if ($lrtv['fecha_vencimiento_rt'] <= date('Y-m-d')){echo "VENCIDO";}else if(($lrtv['fecha_vencimiento_rt'] <= $notificarFecha)&&($lrtv['fecha_vencimiento_rt'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($lrtv['estado'] == 1) { echo 'ACTIVO'; } else if ($lrtv['estado'] == 0) { echo 'INACTIVO'; } else if ($lrtv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($lrtv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>

                      <!--REVISION PREVENTIVA-->
                        <?php foreach ($listarDocsRpVencidos as $lrpv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $lrpv['placa']; ?></td>
                              <td><?php echo $lrpv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($lrpv['numero_movil'] == 0){ echo 'CONVENIO'; 
                                  } else if (($lrpv['numero_movil'] >= 1)&&($lrpv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($lrpv['numero_movil'] >= 1000)&&($lrpv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>REVISIÓN PREVENTIVA</td>
                              <td><?php echo $lrpv['fecha_vencimiento_rp']; ?></td>
                              <td><?php if ($lrpv['fecha_vencimiento_rp'] <= date('Y-m-d')){echo "VENCIDO";}else if(($lrpv['fecha_vencimiento_rp'] <= $notificarFecha)&&($lrpv['fecha_vencimiento_rp'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($lrpv['estado'] == 1) { echo 'ACTIVO'; } else if ($lrpv['estado'] == 0) { echo 'INACTIVO'; } else if ($lrpv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($lrpv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>

                      <!--POLIZA CONTRA-->
                        <?php foreach ($listarDocsPcVencidos as $lpcv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $lpcv['placa']; ?></td>
                              <td><?php echo $lpcv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($lpcv['numero_movil'] == 0){ echo 'CONVENIO'; 
                                  } else if (($lpcv['numero_movil'] >= 1)&&($lpcv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($lpcv['numero_movil'] >= 1000)&&($lpcv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>POLIZA - CONTRACTUAL</td>
                              <td><?php echo $lpcv['fecha_vencimiento_contra']; ?></td>
                              <td><?php if ($lpcv['fecha_vencimiento_contra'] <= date('Y-m-d')){echo "VENCIDO";}else if(($lpcv['fecha_vencimiento_contra'] <= $notificarFecha)&&($lpcv['fecha_vencimiento_contra'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($lpcv['estado'] == 1) { echo 'ACTIVO'; } else if ($lpcv['estado'] == 0) { echo 'INACTIVO'; } else if ($lpcv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($lpcv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>

                      <!--POLIZA EXTRA-->
                        <?php foreach ($listarDocsPeVencidos as $lpev){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $lpev['placa']; ?></td>
                              <td><?php echo $lpev['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($lpev['numero_movil'] == 0){ echo 'CONVENIO'; 
                                  } else if (($lpev['numero_movil'] >= 1)&&($lpev['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($lpev['numero_movil'] >= 1000)&&($lpev['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>POLIZA - EXTRA CONTRACTUAL</td>
                              <td><?php echo $lpev['fecha_vencimiento_extra']; ?></td>
                              <td><?php if ($lpev['fecha_vencimiento_extra'] <= date('Y-m-d')){echo "VENCIDO";}else if(($lpev['fecha_vencimiento_extra'] <= $notificarFecha)&&($lpev['fecha_vencimiento_extra'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($lpev['estado'] == 1) { echo 'ACTIVO'; } else if ($lpev['estado'] == 0) { echo 'INACTIVO'; } else if ($lpev['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($lpev['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>

                        <!--DISPOSITIVO VELOCIDAD-->
                        <?php foreach ($listarDocsDpVencidos as $ldpv){ ?>
                          <tr class="text-center">
                              <td>VEHICULO</td>
                              <td><?php echo $ldpv['placa']; ?></td>
                              <td><?php echo $ldpv['numero_movil']; ?></td>
                              <td>
                                  <?php 
                                  if($ldpv['numero_movil'] == 0){ echo 'Convenio'; 
                                  } else if (($ldpv['numero_movil'] >= 1)&&($ldpv['numero_movil'] <= 999)){ echo 'ORT'; 
                                  } else if (($ldpv['numero_movil'] >= 1000)&&($ldpv['numero_movil'] <= 1999)){ echo 'LP';
                                  } 
                                  ?>
                              </td>
                              <td>DISPOSITIVO DE VELOCIDAD</td>
                              <td><?php echo $ldpv['fecha_exp_disp_velocidad']; ?></td>
                              <td><?php if ($ldpv['fecha_exp_disp_velocidad'] <= $notificarFecha2){echo "VENCIDO";}else if(($ldpv['fecha_exp_disp_velocidad'] <= $notificarFecha)&&($ldpv['fecha_exp_disp_velocidad'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($ldpv['estado'] == 1) { echo 'ACTIVO'; } else if ($ldpv['estado'] == 0) { echo 'INACTIVO'; } else if ($ldpv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td>
                                  <?php
                                  $base = $veh_con->listarContratosBase($ldpv['id_vehiculo']);
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                      if(count($datos_contrato) > 0){
                                          $datos_cliente = $cliente->listarClientePorId($datos_contrato[0]['id_cliente']);
                                          echo utf8_decode($datos_cliente[0]['razon_social']);
                                      } else {
                                          echo "CONTRATO NO ENCONTRADO";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      echo $base[0]['id_contrato'];
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      if(count($datos_contrato) > 0){
                                          if($datos_contrato[0]['numero_contrato'] != ''){
                                              echo $datos_contrato[0]['numero_contrato'];
                                          } else {
                                              echo "SIN # EXTERNO";
                                          }
                                      } else {
                                          echo "CONTRATO SIN DATOS";
                                      }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                              <td>
                                  <?php
                                  if(count($base) > 0){
                                      $datos_contrato = $contrato->listarId($base[0]['id_contrato']);
                                        if ($datos_contrato[0]['fecha_final_contrato'] < $hoy) { 
                                            echo 'VENCIDO'; 
                                        } else { 
                                            echo 'ACTIVO'; 
                                        }
                                  } else {
                                      echo 'SIN ASIGNACION';
                                  }
                                  ?>
                              </td>
                          </tr>
                        <?php } ?>

                      <!--LICENCIA DE CONDUCIR  -->
                        <?php foreach ($listarDocsConductorLcVencidos as $llcv){ ?>
                          <tr class="text-center">
                              <td>CONDUCTOR</td>
                              <td><?php echo $llcv['numero_documento_conductor']; ?></td>
                              <td><?php echo utf8_decode($llcv['nombre_conductor']); ?></td>
                              <td>N/A</td>
                              <td>LICENCIA DE CONDUCIR</td>
                              <td><?php echo $llcv['fecha_vencimiento_licencia']; ?></td>
                              <td><?php if ($llcv['fecha_vencimiento_licencia'] <= date('Y-m-d')){echo "VENCIDO";}else if(($llcv['fecha_vencimiento_licencia'] <= $notificarFecha)&&($llcv['fecha_vencimiento_licencia'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($llcv['estado'] == 1) { echo 'ACTIVO'; } else if ($llcv['estado'] == 0) { echo 'INACTIVO'; } ?></td>
                              <td>N/A</td>
                              <td>N/A</td>
                              <td>N/A</td>
                              <td>N/A</td>
                          </tr>
                        <?php } ?>
    
                      
    		  </tbody>
    	  </table>
    	  </body>
  