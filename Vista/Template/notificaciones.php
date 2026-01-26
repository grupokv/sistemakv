<?php 
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';

$fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
$notificarFecha = date('Y-m-d',$fecha);

$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$notificarFecha2 = date('Y-m-d',$fecha2);


$vehiculo = new Vehiculo();
$conductor = new Conductor();

/*Tarjeta de Operación*/
$listarToVencidos = $vehiculo->listarDocsToVencidos($notificarFecha);
$totalTo = count($listarToVencidos);
/*Soat*/
$listarDocsSoatVencidos = $vehiculo->listarDocsSoatVencidos($notificarFecha);
$totalSoat = count($listarDocsSoatVencidos);
/*Revision Tecnomecanica*/
$listarDocsRtVencidos = $vehiculo->listarDocsRtVencidos($notificarFecha);
$totalRt = count($listarDocsRtVencidos);
/*Revision Preventiva*/
$listarDocsRpVencidos = $vehiculo->listarDocsRpVencidos($notificarFecha);
$totalRp = count($listarDocsRpVencidos);
/*Revision Preventiva*/
$listarDocsPcVencidos = $vehiculo->listarDocspcVencidos($notificarFecha);
$totalPc = count($listarDocsPcVencidos);
/*Revision Preventiva*/
$listarDocsPeVencidos = $vehiculo->listarDocspeVencidos($notificarFecha);
$totalPe = count($listarDocsPeVencidos);
/*Dispositivos Velocidad*/
$listarDocsDpVencidos = $vehiculo->listarDisposVencidos($notificarFecha2);
$totalPe = count($listarDocsDpVencidos);

$listarDocsConductorLcVencidos = $conductor->listarDocsConductorLcVencidos($notificarFecha);
$totallC = count($listarDocsConductorLcVencidos);

 ?>

    <!-- CONTENIDO -->
    <div class="carta-notificaciones">
    <section class="banner" id="banner">
        <p class="titulo">Documentación Vencida</p>
        <i class="fa fa-bell campana-notificaciones"></i>
        <p class="definicion text-center"></p>
        <a class="redireccion-notificaciones" href="notificacionesDocsVencidos.php"><span class="fa fa-search ml-2"></span></a>
         <span class="num"><?php echo $res = $totalTo + $totalSoat + $totalRt + $totalRp + $totalPc + $totalPe + $totallC?></span>
        <ul class="notifications text-center" id="notifications">
                  <li class="docs">
                    <a class="redireccion" href="notificacionesDocsVencidos.php"><b><i>VER TODOS</i></b></a>
                  </li>
                  <?php foreach ($listarToVencidos as $ltov){ ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $ltov['id_vehiculo']  ?>"><?php echo $ltov['placa'] . ' | TAR OPERACIÓN '?></a>
                    </li>
                  <?php } ?>
                  <?php foreach ($listarDocsSoatVencidos as $lsv){ ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lsv['id_vehiculo']  ?>"><?php echo $lsv['placa'] . ' | SOAT '?></a>
                    </li>
                  <?php } ?>
                  
                  <?php foreach ($listarDocsRtVencidos as $lrtv) { ?>
                    <li class="docs">
                      <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrtv['id_vehiculo']  ?>"><?php echo $lrtv['placa'] . ' | REV TECNOMECANICA '?></a>
                    </li>
                  <?php } ?>
                  <?php foreach ($listarDocsRpVencidos as $lrpv) { ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrpv['id_vehiculo']  ?>"><?php echo $lrpv['placa'] . ' | REV PREVENTIVA '?></a>
                    </li>
                  <?php } ?> 
    
                  <?php  foreach ($listarDocsPcVencidos as $lpcv) { ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lpcv['id_vehiculo']  ?>"><?php echo $lpcv['placa'] . ' | CONTRACTUAL '?></a>
                    </li>
                  <?php } ?>
    
                  <?php foreach ($listarDocsPeVencidos as $lrpv) { ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrpv['id_vehiculo']  ?>"><?php echo $lrpv['placa'] . ' | EXTRA CONTRACTUAL'?></a>
                    </li>
                  <?php } ?>

                  <?php foreach ($listarDocsConductorLcVencidos as $llcv) { ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarConductores.php?id_conductor=<?php echo $llcv['id_conductor']  ?>"><?php echo $llcv['numero_documento_conductor'] . ' | LIC CONDUCIR'?></a>
                    </li>
                  <?php } ?>

                  <?php foreach ($listarDocsDpVencidos as $lldp) { ?>
                    <li class="docs">
                        <a class="redireccion" href="actualizarVehiculo.php?id_vehiculo=<?php echo $lldp['id_vehiculo']  ?>"><?php echo $lldp['placa'] . ' | DISP.VELOCIDAD'?></a>
                    </li>
                  <?php } ?>

            </ul> 
    </section>
    </div>

      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-2 mb-1 ml-2 mr-2 cards-nv" style="background-color: #fff; border-radius: 4px;">
          <div class="box-part text-center">
              <i class="fa fa-list-alt fa-3x" aria-hidden="true"></i>
              <div class="title">
                <h4 style="color: red;">Documentación Vencida</h4>
              </div>           
              <a href="../Vista/notificacionesDocsVencidos.php">Consultar <span class="fa fa-search ml-1"></span></a>
          </div>
      </div>