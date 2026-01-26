<?php 

    include("../Controlador/Sesion/autenticar.php");
    require_once '../Modelo/Vehiculo.php';
    require_once '../Modelo/Conductor.php';
    require_once '../Modelo/Vehiculo-Conductor.php';
    require_once '../Modelo/SeguimientoActualizacion.php';
    require_once '../Modelo/Programacion.php';
    require_once '../Modelo/Salud.php';
    require_once '../Modelo/Pre-operacionales.php';
    require_once '../Modelo/Usuario.php';

    $hoy = date('Y-m-d');
    $fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
    $notificarFecha = date('Y-m-d',$fecha);

    $seguimiento = new Seguimiento_Actualizacion();
    $vehiculoConductor = new Vehiculo_Conductor();
    $preoperacionales = new PreOperacionales();
    $programacion = new Programacion();
    $conductor = new Conductor();
    $vehiculo = new Vehiculo();
    $usuario = new Usuario();
    $salud = new Salud();
	
    $id_usuario = $_SESSION['id_usuario'];
    $listarUsuarioID = $usuario->listarUsuarioPorId($id_usuario);

  	$busqueda = $salud->buscarPorUsuario($_SESSION['id_usuario'],$hoy);
  	$cant = count($busqueda);

    if($_SESSION['id_usuario'] != 2272){
      	if($cant < 0){

      	  echo "<script>window.location.href = '../Vista/encuesta_salud.php';</script>";
          exit;

      	}
    }

    $id_modulo = 11;
    $listarPorUsuarioSolicitante = $seguimiento->listarPorUsuarioSolicitante($_SESSION['id_usuario'], $id_modulo);
    $lus = count($listarPorUsuarioSolicitante);
    /*echo $contar = count($listarPorUsuarioSolicitante);*/
    $listarConductorPorId = $conductor->buscarConductorPorDocumento($_SESSION['sesion']);
    //print_r($listarConductorPorId);
    $listarVehiculosPorConductor = $vehiculoConductor->listarPorId($listarConductorPorId[0]['id_conductor']);
    $contarVehiculos = count($listarVehiculosPorConductor);

    /*Servicios de Conductores*/
    $listarServiciosFinalizados = $programacion->serviciosPorConductor($listarConductorPorId[0]['id_conductor']);
    $lsfc = count($listarServiciosFinalizados);    
    $listarServiciosAsignados = $programacion->serviciosAsignadosPorConductor($listarConductorPorId[0]['id_conductor']);
    $lsac = count($listarServiciosAsignados);

    if ($listarConductorPorId[0]['fecha_vencimiento_licencia'] <= date('Y-m-d')) {
        $iconoNotificaciones = 'fa fa-exclamation-circle';
    }else{

    }
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Inicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css">

          #card-events{
            height: 178px;
            background-color: #e9ecef;
          }

          .cards{
            border: 2px solid #ddd;
          }

          .cant-notificaciones{
              background-color: red; 
              width: 25px; 
              height: 25px; 
              position: absolute; 
              border-radius: 50%; 
              top: 12px; 
              left: 170px; 
              border: 3px solid #fff; 
              color: #fff; 
              font-size: .7rem; 
              line-height: 18px;
          }


          @media(max-width: 768px){
            #card-events{
              height: auto;
            }

            .cards{
              margin-left: 5px;
              margin-right: 5px;
            }

            .cant-notificaciones{
                position: absolute;
                left: 150px;
            }

            .boton-cerrar{
                width: 100%;
            }


          }
        </style>
    <!-- FIN STYLES -->

</head>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

      <section class="home_content">

          <div class="notice notice-warning">
            <strong>Bienvenid@ <?php echo ucfirst(mb_strtolower($listarUsuarioID[0]['nombre'])); ?></strong> al sistemakv - desde aqui podra administrar las opciones segun su perfil.
          </div>
          
          <div id="card-events">
            <section class="row" style="margin: 0;">

              <!-- VEHICULOS -->
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                  <div class="box-part text-center">
                      <i class="fa fa-car fa-3x" aria-hidden="true"></i><?php if ($contarVehiculos != 0){ ?><div class="text-center cant-notificaciones"><?php echo $contarVehiculos;?></div><?php } ?>
                      <div class="title">
                        <h4 style="color: red;">Vehiculos</h4>
                      </div>          
                      <div class="text">
                        <span style="font-size: 0.9rem;">Mis vehiculos asignados</span>
                      </div>           
                      <a href="#" data-toggle="modal" data-target="#modalVehiculos">Consultar <span class="fa fa-search ml-1"></span></a>
                  </div>
                </div>  

              <!-- SERVICIOS -->

                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                    <div class="box-part text-center">
                        <i class="fa fa-tasks fa-3x" aria-hidden="true"></i><?php if ($lsac != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsac;?></div><?php } ?>
                        <div class="title">
                          <h4 style="color: red;">Mis Servicios Asignados</h4>
                        </div>          
                        <div class="text">
                          <span style="font-size: 0.9rem;">Mis servicios</span>
                        </div>           
                        <a href="serviciosAsignadosConductor.php">Ver mas <span class="fa fa-search ml-1"></span></a>
                    </div>
                  </div>

              <!-- NOTIFICACIONES -->
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                  <div class="box-part text-center">
                    <i class="fa fa-envelope fa-3x" aria-hidden="true"></i><?php if ($lus != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lus;?></div><?php } ?>
                    <div class="title">
                      <h4 style="color: red;">Notificaciones</h4>
                    </div>          
                    <div class="text">
                      <span style="font-size: 0.9rem;">Mis notificaciones</span>
                    </div>           
                    <a href="#" data-toggle="modal" data-target="#modalNotificaciones">Consultar <span class="fa fa-search ml-1"></span></a>
                  </div>
                </div>

              <!-- PRE-OPERACIONALES -->
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                  <div class="box-part text-center">
                    <i class="fa fa-envelope fa-3x" aria-hidden="true"></i><?php if ($lus != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lus;?></div><?php } ?>
                    <div class="title">
                      <h4 style="color: red;">Pre-operacionales</h4>
                    </div>          
                    <div class="text">
                      <span style="font-size: 0.9rem;">Mis Preoperacionales</span>
                    </div>           
                    <a href="historialPreoperacionalesConductor.php">Consultar <span class="fa fa-search ml-1"></span></a>
                  </div>
                </div>

            </section>
          </div>

      </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

    <!-- MODALES -->

      <!-- PREOPERACIONALES -->
        <div class="modal fade" id="modalVehiculosAsignados" name="modalVehiculosAsignados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            
            <div clas="col-12" style="heigth:30px; background-color:#1b2d3b; width: 100%; "></div>

                <section class="mt-2 mr-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </section>  

                <p class="text-center" style="color:#1b2d3b; font-size: 1.3rem;"><b>VALIDACIÓN DE PREOPERACIONAL<i class="fa fa-file-text-o ml-2"></i></b></p>   
                
                <div class="d-flex justify-content-center">
                  <hr class="col-10">
                </div>

                <div class="modal-body">
                    <div class="row w-100">

                      <?php foreach ($listarVehiculosPorConductor as $lvpc) { 
                        $listarPorIdVehiculoConductorYDia = $preoperacionales->listarPorIdVehiculoConductorYDia($lvpc['id_vehiculo'], $listarConductorPorId[0]['id_conductor'], date('Y-m-d')); 
                      ?>

                        <?php if (count($listarPorIdVehiculoConductorYDia) == 0){ ?>
                          <div class="col-sm-4 col-md-12 col-lg-4 p-2" style="cursor: pointer;">
                            <a href="../Controlador/validarVehiculo.php?id_vehiculo=<?php echo $lvpc['id_vehiculo'] ?>" class="card mx-sm-4 p-3" style="border: 2px solid #1b2d3b; list-style: none; text-decoration: none; color: #1b2d3b;">
                                <h4 class="text-center"><b><?php echo $lvpc['placa'] ?></b></h4>
                                <p class="text-center" style="color: green;"><i class="fa fa-check-circle mr-1"></i>Disponible</p>
                            </a>
                          </div>
                        <?php }else{ ?>
                          <div class="col-sm-4 col-md-12 col-lg-4 p-2" style="cursor: pointer;">
                            <a href="javascript:void(0)" class="card mx-sm-4 p-3" style="border: 2px solid #1b2d3b; list-style: none; text-decoration: none; color: #1b2d3b;">
                                <h4 class="text-center"><?php echo $lvpc['placa'] ?></h4>
                                <p class="text-center" style="color: red;"><i class="fa fa-check-circle mr-1"></i>Registrado</p>
                            </a>
                          </div>
                        <?php } ?>
                        
                      <?php } ?>

                    </div>
                </div>

            </div>
          </div>
        </div>
      
      <!-- VEHICULOS -->
        <div class="modal fade" id="modalVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                  <h5 class="modal-title text-center" id="exampleModalLabel">VEHICULOS ASIGNADOS - DOCUMENTACIÓN VENCIDA</h5>
                </div>
                <div class="modal-body">
                    <div class="row w-100">
                      <?php foreach ($listarVehiculosPorConductor as $lvpc) { ?>
                        <div class="col-sm-4 col-md-12 col-lg-4 p-2" style="cursor: pointer;">
                          <a href="actualizarDocsVehiculo.php?id_vehiculo=<?php echo $lvpc['id_vehiculo'] ?>" class="card mx-sm-4 p-3" style="border: 2px solid #1b2d3b; list-style: none; text-decoration: none; color: #1b2d3b;">
                              <?php 
                                  $listarToVencidosPorId = $vehiculo->listarDocsToVencidosPorVehiculo($lvpc['id_vehiculo'], $notificarFecha);
                                  $ltovi = count($listarToVencidosPorId);
                  
                                  $listarSoatVencidosPorId = $vehiculo->listarDocsSoatVencidosPorVehiculo($lvpc['id_vehiculo'], $notificarFecha);
                                  $lsoatvi = count($listarSoatVencidosPorId);

                                  $listarRtVencidosPorId = $vehiculo->listarDocsRtVencidosPorId($lvpc['id_vehiculo'], $notificarFecha);
                                  $lrtvi = count($listarRtVencidosPorId);

                                  $listarRpVencidosPorId = $vehiculo->listarDocsRpVencidosPorId($lvpc['id_vehiculo'], $notificarFecha);
                                  $lrpvi = count($listarRpVencidosPorId);

                                  $listarPcVencidosPorId = $vehiculo->listarDocspcVencidosPorId($lvpc['id_vehiculo'], $notificarFecha);
                                  $lpcvi = count($listarPcVencidosPorId);

                                  $listarPecVencidosPorId = $vehiculo->listarDocspeVencidosPorId($lvpc['id_vehiculo'], $notificarFecha);
                                  $lpecvi = count($listarPecVencidosPorId);

                                  $validarDocLt = $vehiculo->validarDocLt($lvpc['id_vehiculo']);
                                  $vlt = count($validarDocLt);
                  
                                  $resultado = $ltovi + $lsoatvi + $lrtvi + $lrpvi + $lpcvi + $lpecvi + $vlt;
                              ?>
                              <span style="position: absolute; border-radius: 50%; background-color: red; width: 25px; height: 25px; border: 2px solid #fff; left: 160px; top: -13px; text-align: center; line-height: 20px; font-size: .7rem; color: #fff;"><?php echo $resultado ?></span>
                              <h4 class="text-center"><?php echo $lvpc['placa'] ?></h4>
                          </a>
                        </div>
                      <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger boton-cerrar" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
        </div>

      <!-- Modal -->
        <div class="modal fade" id="modalNotificaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                  <h5 class="modal-title" id="exampleModalLabel">NOTIFICACIONES</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                      <table id="dataT" class="table tabla_notificaciones" value="tabla_notificaciones">
                          <thead>
                            <tr class="text-center">
                              <th>COMUNICADO</th>
                              <th>DOCUMENTO</th>
                              <th>OPCIONES</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($listarPorUsuarioSolicitante as $lus){ ?>
                                  <?php if ($lus['estado'] == 'P'){ ?>
                                      <tr class="text-center">
                                          <td><i style="font-size: 1.3rem; color: royalblue;" class="fa fa-clock-o fa-spin"></i><?php echo " PENDIENTE POR REVISIÓN" ?></td>
                                          <td>
                                            <?php 
                                                $datos = explode("|", $lus['columnas']); 
                                                $documento = $datos[0]; 
                                                $fecha_vencimiento_documento = $datos[1]; 

                                                $doc = explode("_", $documento);
                                                $partDoc1 = $doc[0];
                                                $partDoc2 = $doc[1];

                                                echo strtoupper($partDoc1 .' ' . $partDoc2) ;
                                            ?>
                                          </td>
                                          <td></td>
                                      </tr>
                                  <?php } ?>
                                  
                                  <?php if ($lus['novedad_rechazo'] != ''){ ?>
                                      <tr class="text-center">
                                          <?php if ($lus['estado'] == 'A'){ ?>
                                              <td><i style="color: green;" class="fa fa-check-circle-o"></i><?php echo " SE HA ACEPTADO LA SOLICITUD DE ACTUALIZACIÓN DEL DOCUMENTO." ?></td>
                                          <?php } else { ?>
                                              <td><i style="color: red;" class="fa fa-exclamation-circle"></i><?php echo " SE HA RECHAZADO LA SOLICITUD DE ACTUALIZACIÓN DEL DOCUMENTO. - <strong>MOTIVO:</strong> " . $lus['novedad_rechazo'] ?></td>
                                          <?php }?>
                                          <td>
                                              <?php 
                                                  $datos = explode("|", $lus['columnas']); 
                                                  $documento = $datos[0]; 
                                                  $fecha_vencimiento_documento = $datos[1]; 

                                                  $doc = explode("_", $documento);
                                                  $partDoc1 = $doc[0];
                                                  $partDoc2 = $doc[1];

                                                  echo strtoupper($partDoc1 .' ' . $partDoc2) ;
                                              ?>
                                          </td>
                                          <td>
                                              <?php if ($lus['estado'] == 'R'){ ?>  
                                                  <a href="actualizarDocsVehiculo.php?id_vehiculo=<?php echo $lus['id_registro'] ?>" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
                                                  <a href="../Controlador/eliminarNotificacionActDocsVehiculos.php?id_seguimiento=<?php echo $lus['id_seguimiento'] ?>" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></a>
                                              <?php }else if($lus['estado'] == 'A'){ ?>
                                                  <a href="../Controlador/eliminarNotificacionActDocsVehiculos.php?id_seguimiento=<?php echo $lus['id_seguimiento'] ?>" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></a>
                                              <?php } ?>
                                          </td>
                                      </tr>
                                  <?php } ?>
                              <?php } ?>
                              
                              <?php foreach($listarNotificacionesComprobante As $lnc){ ?>
                                  <tr class="text-center">
                                      <?php if ($lnc['estado'] == 'R'){ ?>
                                          <td><?php echo "SE HA RECHAZADO EL REGISTRO DEL COMPROBANTE - <strong>MOTIVO: </strong>" . strtoupper($lnc['comunicado']) . "."; ?></td>
                                      <?php } else { ?>
                                          <td><?php echo $lnc['comunicado']; ?></td>
                                      <?php }?>
                                      
                                      <td>COMPROBANTE DE PAGO</td>
                                      
                                      <td>  
                                          <a href="../Controlador/borrarNotificacionComprobante.php?id_notificacion_comprobante=<?php echo $lnc['id_notificacion_comprobante'] ?>" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></a>
                                      </td>
                                  </tr>
                              <?php } ?>
                          </tbody>
                      </table>
                    </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
        </div>

    <!-- FIN MODALES -->                 
    
  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
  <?php
  if($_SESSION['idv'] == ''){
  ?>
    <script>
    $(document).ready(function(){
        $("#modalVehiculosAsignados").modal(
          {
            backdrop: 'static', 
            keyboard: false
          }
        );
    });
    </script>
  <?php  
  } else {
  ?>
    
  <?php 
  }
  ?>
</body>
</html>
