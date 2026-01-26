<?php 
    session_start();

    include("../Controlador/Sesion/autenticar.php");
    require_once '../Modelo/SeguimientoActualizacion.php';
    require_once '../Modelo/Vehiculo-Conductor.php';
    require_once '../Modelo/ConceptosCobro.php';
    require_once '../Modelo/Programacion.php';
    require_once '../Modelo/Conductor.php';
    require_once '../Modelo/Vehiculo.php';
    require_once '../Modelo/Usuario.php';

    $fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
    $notificarFecha = date('Y-m-d',$fecha);

    $seguimiento = new Seguimiento_Actualizacion();
    $vehiculoConductor = new Vehiculo_Conductor();
    $programacion = new Programacion();
    $concepto = new ConceptoCobro();
    $conductor = new Conductor();
    $vehiculo = new Vehiculo();
    $usuario = new Usuario();

    $id_usuario = $_SESSION['id_usuario'];
    $listarUsuarioID = $usuario->listarUsuarioPorId($id_usuario);

    $buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);
    
    $listarNotificacionesComprobante = $concepto->listarNotificacionesComprobante($_SESSION['id_usuario']);
    $totalNotificacionesComprobante = count($listarNotificacionesComprobante);

    $id_modulo = "11, 12";
   
    $listarPorUsuarioSolicitante = $seguimiento->listarPorUsuarioSolicitante($_SESSION['id_usuario'], $id_modulo);

    $totalNotSeguimientoActualizaciones = count($listarPorUsuarioSolicitante);

    $totalNotificaciones = ($totalNotSeguimientoActualizaciones + $totalNotificacionesComprobante);

   
    $listado_veh = '';

    $i=1;

    foreach($buscarVehiculoPorPropietario as $vp){
    	
      if($i==count($buscarVehiculoPorPropietario)){
    		$listado_veh .= $vp['id_vehiculo'];
    	} else {
    		$listado_veh .= $vp['id_vehiculo'] . ',';
    	}	

      $i++; 

    }

    $numero_movil = array();
    foreach ($buscarVehiculoPorPropietario as $bvp) {
        array_push($numero_movil, $bvp['numero_movil']);
    }

    $buscarConductoresPorVehiculo = $vehiculoConductor->listarConductoresPorVehiculos($listado_veh);
    $cant_conductores = count($buscarConductoresPorVehiculo);

    $pagos_pendientes = $concepto->pagosPendientes($listado_veh);
    $cant_pp = count($pagos_pendientes);

    /**/

    $consultarMensajePorUsuario = $usuario->consultarMensajePorUsuario($_SESSION['id_usuario']);
    $cantMensajes = count($consultarMensajePorUsuario);

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio Propietario</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->

      <?php include("Template/styles.php") ?>
      <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

      <style>

        #card-events{
          height: auto;
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
                left: 185px;
            }

            .notification-dropdown-menu {
              min-width: 420px;
            }
        }

        /*------------*/

        .dropdown-notification{
          height: auto !important;
          padding: 10px !important;
          border-bottom: 2px solid #e3e3e3; 
        }

        .dropdown-notification:active {
          color: #1d1e1f;
          text-decoration: none;
          background-color: #f7f7f9;
        }

        .dropdown-notification:hover .notification-read {
          color: #34495E;
        }

        .dropdown-notification-all {
          text-align: center;
          padding-top: 5px;
          padding-bottom: 5px;
          font-style: oblique;
          background-color: #1b2d3b;
          color: white;
        }

        .dropdown-notification-all:hover {
          background-color: #34495E;
          color: white;
        }

        .notifications-container {
          max-height: 300px;
          overflow: auto;
        }

        .notification-dropdown-menu {
          padding-bottom: 0;
          min-width: 528px;
        }

        .notification-img {
          width: 48px;
          display: inline-block;
          vertical-align: top;
        }

        .notifications-body {
          display: inline-block;
        }

        .notification-texte {
          text-align: left;
          margin: 0;
        }

        .notification-read {
          margin: 0;
          height: 48px;
          vertical-align: top;
          line-height: 48px;
          padding-left: 15px;
          color: white;
          float: right;
        }

        .dropdown-toggle::after{
          font-size: 1.2rem;
          color: #1b2d3b;
        }

        .notification-date {
          text-align: left;
          color: #2980b9;
          margin: 0;
        }

        .notification-unread {
          text-decoration: none;
          background-color: #f7f7f9;
        }

        #notifications-dropdown{
                            background-color: #eeeeee;
            height: auto;
        }

        .dropdown-item{
          white-space: normal;
        }
      </style>

  <!-- FIN STYLES -->

</head>
<body>

  <!-- MENU -->
      <?php include("Template/header.php"); ?>
      <?php include("Template/newMenu.php"); ?>
  <!-- FIN MENU -->

<!--***************************-->
  
<!-- CONTENIDO -->

  <section class="home_content"> 
      <div class="p-2">

          <div class="notice notice-warning mt-2">
              <strong>Bienvenid@ <?php echo ucfirst(mb_strtolower($listarUsuarioID[0]['nombre'])); ?></strong> al sistemakv - desde aqui podra administrar las opciones segun su perfil.
          </div>

          <!-- SECCIÓN MENSAJES DIRECTOS DEL USUARIO  -->
            <div class="col-12 p-0 m-0" style="background-color: #fff; border-radius: 10px;" role="alert">
                
                <!-- NAVBAR -->
                  <nav class="navbar">

                      <!-- ICON -->
                      <div class="dropdown nav-button notifications-button hidden-sm-down">

                          <a class="btn dropdown-toggle" href="#" id="notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i id="notificationsIcon" class="fa fa-comments-o" style="color: #5e99b1" aria-hidden="true"></i>
                                <span id="notificationsBadge" style="background: #5e99b1 !important;" class="badge badge-danger">
                                    <?php echo $cantMensajes; ?>
                                </span>
                          </a>

                          <!-- NOTIFICATIONS -->
                          <div class="col-12 dropdown-menu notification-dropdown-menu" aria-labelledby="notifications-dropdown">
                              <h6 class="dropdown-header">Mensajes</h6>

                              <!-- CHARGEMENT -->
                              <!--  -->

                              <div style="margin-bottom: 20px;" id="notificationsContainer" class="col-12 notifications-container">
                                
                                <?php if ($cantMensajes > 0){ ?>
                                    <?php foreach ($consultarMensajePorUsuario as $cmpu){ 

                                      $listarUsuarioPorId = $usuario->listarUsuarioPorId($cmpu['id_usuario_remitente']);  ?>
                                      
                                        <!-- NOTIFICATION -->
                                        <a class="col-12 dropdown-item dropdown-notification" href="#">
                                          <div class="col-12 notifications-body p-3" style="background-color: #fafafa; ">
                                              <i style="color: #5e99b1;" class="fa fa-commenting-o mr-2"></i><strong style="color: #5e99b1;"><?php echo date($cmpu['fecha']); ?> | </strong><cite style="color: #5e99b1;">Enviado por: <?php echo ucwords(strtolower($listarUsuarioPorId[0]['nombre'])); ?></cite>
                                              <br>
                                              <td style="color: #6e6e6e; font-size: .9rem;"><?php echo ucfirst(strtolower($cmpu['mensaje'])) . '.'; ?></td>
                                          </div>
                                        </a>

                                    <?php } ?>

                                <?php } else { ?>
                                    <a id="notificationsLoader" class="col-12 dropdown-item dropdown-notification" href="#">
                                        <p class="notification-solo text-center"><i id="notificationsIcon" class="fa fa-times fa-spin fa-fw" aria-hidden="true"></i> No se encontraron mensajes o notificaciones.</p>
                                    </a>
                                <?php } ?>
                              </div>

                            
                              <!-- TOUTES -->
                              <a class="col-12 dropdown-item dropdown-notification-all" href="#">
                                Mensajes directos del usuario
                              </a>

                          </div>

                      </div>
                  </nav>
                
            </div>


          <!-- CARTAS MODULOS DEL USUARIO  -->
            <div class="content-cards mt-3 mb-5 p-2" style="background-color: #fff;">
                <section class="row d-flex justify-content-start" style="margin: 0; padding: 5px; background: #eeeeee;">

                    <!-- VEHICULOS -->
                      <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                        <div class="box-part text-center">
                            <i class="fa fa-car fa-3x" aria-hidden="true"></i><?php if ($contarVehiculos != 0){ ?><div class="text-center cant-notificaciones"><?php echo $contarVehiculos;?></div><?php } ?>
                            <div class="title">
                              <h4 style="color: red;">Vehículos</h4>
                            </div>          
                            <div class="text">
                              <span style="font-size: 0.9rem;">Mis vehículos asignados</span>
                            </div>           
                            <a href="#" data-toggle="modal" data-target="#modalVehiculos">Consultar <span class="fa fa-search ml-1"></span></a>
                        </div>
                      </div> 

                    <!-- CONDUCTORES -->
                      <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                        <div class="box-part text-center">
                            <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                            <div class="title">
                              <h4 style="color: red;">Conductores</h4>
                            </div>          
                            <div class="text">
                              <span style="font-size: 0.9rem;">Mis conductores anclados</span>
                            </div>           
                            <a href="#" data-toggle="modal" data-target="#modalConductores">Consultar <span class="fa fa-search ml-1"></span></a>
                        </div>
                      </div> 

                    <!-- NOTIFICACIONES -->
                      <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 mr-2 ml-2 cards" style="background-color: #fff; border-radius: 4px;">
                        <div class="box-part text-center">
                          <i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
                            <?php if ($totalNotificaciones != 0){ ?>
                                <div class="text-center cant-notificaciones">
                                    <?php echo $totalNotificaciones ?>
                                </div>
                            <?php } ?>
                          <div class="title">
                            <h4 style="color: red;">Notificaciones</h4>
                          </div>          
                          <div class="text">
                            <span style="font-size: 0.9rem;">Mis Notificaciones</span>
                          </div>           
                          <a href="#" data-toggle="modal" data-target="#modalNotification">Consultar <span class="fa fa-search ml-1"></span></a>
                        </div>
                      </div>

                    <?php if ($_SESSION['id_perfil'] == 8) { ?>
                     
                        <!-- SERVICIOS -->
                          <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                            <div class="box-part text-center">
                                <i class="fa fa-tasks fa-3x" aria-hidden="true"></i><?php if ($lsfc != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsfc;?></div><?php } ?>
                                <div class="title">
                                  <h4 style="color: red;">Servicios Finalizados</h4>
                                </div>          
                                <div class="text">
                                  <span style="font-size: 0.9rem;">Mis servicios</span>
                                </div>           
                                <a href="serviciosConductor.php">Ver mas <span class="fa fa-search ml-1"></span></a>
                            </div>
                          </div>

                    
                          <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                            <div class="box-part text-center">
                                <i class="fa fa-tasks fa-3x" aria-hidden="true"></i><?php if ($lsac != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsac;?></div><?php } ?>
                                <div class="title">
                                  <h4 style="color: red;">Servicios Asignados</h4>
                                </div>          
                                <div class="text">
                                  <span style="font-size: 0.9rem;">Mis servicios</span>
                                </div>           
                                <a href="serviciosAsignadosConductor.php">Ver mas <span class="fa fa-search ml-1"></span></a>
                            </div>
                          </div>

                    <?php } ?>

                    <?php for ($i=0; $i < count($numero_movil); $i++) { ?>
                        <?php if ($numero_movil[$i] != 0){ ?>

                          <!-- CARTERA -->
                  	        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                              <div class="box-part text-center">
                                <i class="fa fa-dollar fa-3x" aria-hidden="true"></i><?php if ($cant_pp != 0){ ?><div class="text-center cant-notificaciones"><?php echo $cant_pp;?></div><?php } ?>
                                <div class="title">
                                  <h4 style="color: red;">Cartera Pendiente</h4>
                                </div>          
                                <div class="text">
                                  <span style="font-size: 0.9rem;">Mis pagos pendientes</span>
                                </div>           
                                <a href="pagos_pendientes_propietario.php">Consultar <span class="fa fa-search ml-1"></span></a>
                              </div>
                            </div>
                    
                          <!-- CERTIFICADOS -->
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                                <div class="box-part text-center">
                                    <i class="fa fa-print fa-3x" aria-hidden="true"></i>
                                    <div class="title">
                                        <h4 style="color: red;">Certificados <!-- - Paz y Salvos --></h4>
                                    </div>          
                                    <div class="text">
                                        <i style="font-size: 0.9rem;">Consulte y descargue certificados <!-- y paz y salvos --> de sus vehiculos</i>
                                    </div>           
                                    <a href="#" data-toggle="modal" data-target="#modalCertificados">Consultar <span class="fa fa-search ml-1"></span></a>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } ?>

                </section>
            </div>
          <!--FIN CARTAS MODULOS DEL USUARIO  -->

      </div>
  </section>

<!-- FIN CONTENIDO -->


<!--***************************-->
<!--******** MODALES **********-->
<!--***************************-->

<!-- MODAL NOTIFICACION HORARIO -->
  <div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body text-center">
            <div class="col-12" style="height: auto;">
              <i style="color: #d62d2d; font-size: 4rem;" class="fa fa-info-circle"></i>
              <h4 class="modal-title" style="color: #474747; "><b>ANEXO INFORMÁTIVO</b></h4>
            </div>
            <div class="col-12 mt-3">
                <p class="mb-3" style="font-size: .9rem;">Estimado afiliado recuerde que el horario de validación de documentos de vehículos y conductores para ser actualizados en el sistema es el siguiente: </p>
                
                <p style="font-size: .9rem;"><strong style="color: #a1a1a1; font-size: .9rem;">HORARIO DE OFICINA</strong></p>
                <p style="font-size: .9rem;"><strong style="color: #474747; font-size: .9rem;">LUNES A VIERNES</strong><p> 7:00 AM A 12:00 PM - 2:00 PM A 4:30 PM</p></p>
                <p style="font-size: .9rem;"><strong style="color: #474747; font-size: .9rem;">SABADOS</strong><p> 9:00 AM A 12:00 PM </p>
                <p style="font-size: .9rem;"><b>NOTA: </b>Tenga en cuenta que los documentos cargados antes de las 12:00 PM serán revisados el mismo día y los documentos cargados despues de las 2:00 PM serán revisados al dia siguiente.</p>


                <p style="font-size: .9rem;">Si su(s) vehículos cuentan con documentación vencida al momento de emitir el FUEC, cargue los documentos con anticipación para su debida validación.</p>
            </div>
          </div>
          <div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
            <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>

<!-- MODAL NOTIFICACIONES -->
    <div class="modal fade" id="modalNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
              <div class="notice notice-sistemakv mb-3">
                <strong>NOTIFICACIONES</strong>
              </div>

              <div class="table-responsive">
                <table id="dataT" class="table tabla_notificaciones" value="tabla_notificaciones">
                    <thead style='background-color: #1b2d3b; color: #fff;'>
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
          <div class="modal-footer d-flex justify-content-center">
              <button type="button" class="btn btn-outline-danger col-3" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

<!-- MODAL CONDUCTORES -->
    <div class="modal fade" id="modalConductores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
              <div class="notice notice-sistemakv mb-3">
                <strong><b style="font-size: 1.2rem;">CONDUCTORES ANCLADOS - DOCUMENTACIÓN VENCIDA</b></strong>
              </div>

              <div class="row">
                <?php foreach ($buscarConductoresPorVehiculo as $bcpv){ 
                    $listarPorId = $conductor->listarPorId($bcpv['id_conductor']);
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-4" style="cursor: pointer;">
                      <a href="actualizarConductores.php?id_conductor=<?php echo $listarPorId[0]['id_conductor']; ?>" class="card mx-sm-4 p-3" style="border: 2px solid #1b2d3b; list-style: none; text-decoration: none; color: #1b2d3b;">
                          <?php 
                              $listarDocsConductorLcVencidosPorId = $conductor->listarDocsConductorLcVencidosPorId($listarPorId[0]['id_conductor'], $notificarFecha);

                              $ltovi = count($listarDocsConductorLcVencidosPorId);
              
                              $resultado = $ltovi;
                          ?>
                          <span style="position: absolute; border-radius: 50%; background-color: red; width: 25px; height: 25px; border: 2px solid #fff; left: 160px; top: -13px; text-align: center; line-height: 20px; font-size: .7rem; color: #fff;"><?php echo $resultado ?></span>
                          <p class="text-center" style="font-size: .9rem;"><?php echo $listarPorId[0]['nombre_conductor'] ?></p>
                      </a>
                    </div>
              <?php } ?>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

<!-- MODAL VEHICULOS -->
      <div class="modal fade" id="modalVehiculos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="notice notice-sistemakv mb-3">
                <strong>VEHÍCULOS ASIGNADOS - DOCUMENTACIÓN VENCIDA</strong>
              </div>
              
                <div class="row">
                  <?php foreach ($buscarVehiculoPorPropietario as $bvp){ ?>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-3" style="cursor: pointer;">
                      <a href="actualizarDocsVehiculo.php?id_vehiculo=<?php echo $bvp['id_vehiculo'] ?>" class="card mx-sm-4 p-3" style="border: 2px solid #1b2d3b; list-style: none; text-decoration: none; color: #1b2d3b;">
                          <?php 
                              $listarToVencidosPorId = $vehiculo->listarDocsToVencidosPorVehiculo($bvp['id_vehiculo'], $notificarFecha);
                              $ltovi = count($listarToVencidosPorId);
              
                              $listarSoatVencidosPorId = $vehiculo->listarDocsSoatVencidosPorVehiculo($bvp['id_vehiculo'], $notificarFecha);
                              $lsoatvi = count($listarSoatVencidosPorId);

                              $listarRtVencidosPorId = $vehiculo->listarDocsRtVencidosPorId($bvp['id_vehiculo'], $notificarFecha);
                              $lrtvi = count($listarRtVencidosPorId);

                              $listarRpVencidosPorId = $vehiculo->listarDocsRpVencidosPorId($bvp['id_vehiculo'], $notificarFecha);
                              $lrpvi = count($listarRpVencidosPorId);

                              $listarPcVencidosPorId = $vehiculo->listarDocspcVencidosPorId($bvp['id_vehiculo'], $notificarFecha);
                              $lpcvi = count($listarPcVencidosPorId);

                              $listarPecVencidosPorId = $vehiculo->listarDocspeVencidosPorId($bvp['id_vehiculo'], $notificarFecha);
                              $lpecvi = count($listarPecVencidosPorId);

                              $validarLt = $vehiculo->validarDocLt($bvp['id_vehiculo']);
                              $vlt = count($validarLt);
              
                              $resultado = $ltovi + $lsoatvi + $lrtvi + $lrpvi + $lpcvi + $lpecvi + $vlt;
                          ?>

                          <?php if($resultado != 0){?>
                              <span style="position: absolute; border-radius: 50%; background-color: red; width: 25px; height: 25px; border: 2px solid #fff; left: 160px; top: -13px; text-align: center; line-height: 20px; font-size: .7rem; color: #fff;"><?php echo $resultado ?></span>
                          <?php } ?>
                          
                          <h4 class="text-center"><b><?php echo $bvp['placa'] ?></b></h4>
                      </a>
                    </div>
                <?php } ?>
                  </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div> -->
          </div>
        </div>
      </div>

<!-- MODAL CERTIFICADOS -->
  <div class="modal fade" id="modalCertificados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="notice notice-sistemakv mb-3">
                      <strong><i class="fa fa-file-text mr-3"  style="font-size: 1.8rem;"></i><b style="font-size: 1.2rem;">DESCARGAR CERTIFICADOS</b></strong>
                  </div>
                  
                  <div class="table-responsive">
                      <table id="dataT2" class="table table-sm mt-2 text-center" width="100%">

                        <thead>
                          <tr>
                              <th colspan="4" class="p-3 text-center" style="font-size: 1.2rem; color: #575757; border-bottom: none !important;"><strong class="mt-4">ESTADOS DE CUENTA</strong></th>
                          </tr>
                          <tr>
                            <th scope="col" style="border-top: 0px; "><strong>#</strong></th>
                            <th scope="col" style="font-size: .9rem; color: #474747; border-top: 0px; "><strong>PLACA</strong></th>
                            <th scope="col" style="font-size: .9rem; color: #474747; border-top: 0px; "><strong>DESCARGAR PDF</strong></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1; ?>
                          <?php foreach ($buscarVehiculoPorPropietario as $vp){ ?>
                              <tr>
                                <th scope="row"><?php echo $i ?></th>
                                <td><?php echo $vp['placa'] . ' <strong> | N° Móvil ' . $vp['numero_movil'] ?></strong></td>
                                <td>
                                    <form action="PDF/estadoCuenta.php" method="POST" target="_blank">
                                        <input type="hidden" name="vehiculo" id="vehiculo" value="<?php echo $vp['id_vehiculo'] ?>">
                                        <input type="hidden" name="tipoReporte" id="tipoReporte" value="V">
                                        <?php if ($vp['numero_movil'] != 0){ ?>
                                          <button class="btn" style="background-color: #5e99b1;margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-download" style="font-size: 1.1rem; color: #fff;"></i></button>
                                        <?php } ?>
                                        
                                    </form>
                                </td>
                              </tr>
                              <?php $i++; ?>
                          <?php } ?>
                        </tbody>
                      </table>
                  </div>

              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button type="button" class="btn btn-outline-danger btn-block col-3" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
  </div>

<!--***************************-->
<!--*******FIN MODALES ********-->
<!--***************************-->

<!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>

  <script type="text/javascript">
      function modalAviso(){
          $("#myModal").modal("show");   
      }

      $(window).on("load", modalAviso());
  </script>
<!-- SCRIPTS -->


</body>
</html>