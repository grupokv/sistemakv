<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';

$vehiculo = new Vehiculo();
$conductor = new Conductor();

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
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Documentacion Vencida</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->

        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css">
            @media (max-width: 760px){
              .icono-principal{
                display: none;
              }

              .titulo-principal{
                  font-size: 1.6rem;
                  text-align: center;
              }
            }

            .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
                stroke: #5e99b1;
            }

            .ct-series-a .ct-area{
              fill: #5e99b1;
            }

            .ct-bar {
              stroke-width: 20px;
            }   
        </style>

    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--***************************-->
  
    <!-- CONTENIDO -->

        <section class="home_content">  

            <div aria-label="breadcrumb" class="mt-1"> 
              <ol class="breadcrumb" style="background-color: #fff;">
                  <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Documentación Vencida</li>
              </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-envelope mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">DOCUMENTACIÓN</b></strong>
            </div>

            <div class="row d-flex justify-content-around">

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ct-chart mt-3 mb-3 p-2" style="background-color: #fff; border-radius: 5px;">
                    <a href="exportar_reporte_vencimientos.php" target="_blank"><button class="btn btn-block btn-success">DESCARGAR EXCEL</button></a>
                </div>  

                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 mt-3 mb-3 p-4" style="background-color: #fff; border-radius: 5px;">
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Tarjeta de Operación: </b> <?php echo $to ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Soat: </b> <?php echo $soat ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Revisión Tecnomecanica:</b> <?php echo $rt ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Revisión Preventiva:</b> <?php echo $rp ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Poliza Contractual:</b> <?php echo $pc ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Poliza Extra Contractual:</b> <?php echo $pe ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Dispositivo de Velocidad:</b> <?php echo $dv ?> documentos vencidos o vacios.</p>
                    <p class="ml-3" style="color: #1b2d3b;"><i style="font-size: 1rem; color: #5e99b1;" class="fa fa-file-text mr-1"></i><b>Licencia de Conducir:</b> <?php echo $lc ?> documentos vencidos o vacios.</p>
                    
                </div>

            </div>

            <div class="col-12 mt-2 p-4 table-responsive" style="background-color: #fff;">  
                <table id="dataT" class="table table-hover table-sm display" style="width:100%">
                    <thead style="background-color: #1b2d3b; color: #fff;">
                        <tr class="text-center">
                            <th>TIPO</th>
                            <th>PLACA - No. DOCUMENTO</th>
                            <th>MOVIL - NOMBRE CONDUCTOR</th>
                            <th>EMPRESA</th>
                            <th>DOCUMENTO</th>
                            <th>FECHA DE VENCIMIENTO</th>                   
                            <th>ESTADO</th>
                            <th>ESTADO VEH/COND</th>
                            <th>OPCIONES</th>
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
                              <td>TARJETA DE OPERACIÓN</td>
                              <td><?php echo $ltv['fecha_vencimiento_to']; ?></td>
                              <td><?php if ($ltv['fecha_vencimiento_to'] <= date('Y-m-d')){echo "VENCIDO";}else if(($ltv['fecha_vencimiento_to'] <= $notificarFecha)&&($ltv['fecha_vencimiento_to'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($ltv['estado'] == 1) { echo 'ACTIVO'; } else if ($ltv['estado'] == 0) { echo 'INACTIVO'; } else if ($ltv['estado'] == 2) { echo 'DESVINCULADO'; } else { echo 'RETIRADO'; } ?></td>
                              <td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $ltv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $ldsv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrtv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrpv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $lpcv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $lpev['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
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
                              <td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $ldpv['id_vehiculo']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
                          </tr>
                        <?php } ?>

                      <!--LICENCIA DE CONDUCIR  -->
                        <?php foreach ($listarDocsConductorLcVencidos as $llcv){ ?>
                          <tr class="text-center">
                              <td>CONDUCTOR</td>
                              <td><?php echo $llcv['numero_documento_conductor']; ?></td>
                              <td><?php echo $llcv['nombre_conductor']; ?></td>
                              <td>N/A</td>
                              <td>LICENCIA DE CONDUCIR</td>
                              <td><?php echo $llcv['fecha_vencimiento_licencia']; ?></td>
                              <td><?php if ($llcv['fecha_vencimiento_licencia'] <= date('Y-m-d')){echo "VENCIDO";}else if(($llcv['fecha_vencimiento_licencia'] <= $notificarFecha)&&($llcv['fecha_vencimiento_licencia'] > date('Y-m-d'))){ echo "PROXIMO A VENCER";} ?>            
                              </td>
                              <td><?php if ($llcv['estado'] == 1) { echo 'ACTIVO'; } else if ($llcv['estado'] == 0) { echo 'INACTIVO'; } ?></td>
                              <td><a href="actualizarConductores.php?id_conductor=<?php echo $llcv['id_conductor']  ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>
                          </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>

        </section>
    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->

    <?php include("Template/scripts.php") ?>
    <script type="text/javascript">

      var chart = new Chartist.Line('.ct-chart', {
          labels: ['TO', 'SOAT', 'RTM', 'PR', 'RCC', 'RCE', 'DV', 'LC'], 
          series: [
            [<?php echo $to; ?>, <?php echo $soat; ?>, <?php echo $rt; ?>, <?php echo $rp; ?>, <?php echo $pc; ?>, <?php echo $pe; ?>, <?php echo $dv; ?>, <?php echo $lc; ?> ],
          ]
        }, {
          low: 0,
          showArea: true,
          options: chartOptions
      });


      /*chart.on('draw', function(data) {
          if(data.type == 'line') {
              data.element.animate({
                  x2: {
                      dur: '0.7s',
                      from: data.x1,
                      to: data.x2
                  }
              });
          }
      });*/

    </script>

  <!-- FIN SCRIPTS --<
</body>
</html>