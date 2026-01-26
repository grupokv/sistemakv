<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();
$listarServiciosVariables = $programacion->listarServiciosVariables();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Servicios Variables</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  <style>
      table {
        border-collapse: collapse;
        border-radius: .4em;
        overflow: hidden;
      }

      #cargarExcel:hover{
        color: #fff;
      }
  </style>

</head>
<body>

    
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <section class="home_content">

        <div class="notice notice-warning">
          <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">SOLICITUD SERVICIOS VARIABLES</b></strong>
        </div>

        <div class="notice notice-warning">
          <a href="registrarSolicitudVariables.php" class="btn btn-outline-info"> Nueva Solicitud <i class="fa fa-plus-circle ml-2"></i></a>

          <button class="btn btn-outline-info" data-toggle="modal" data-target="#modalCargarExcel"> Subir Excel <i class="fa fa-file-excel-o ml-2"></i></button>
        </div>

        <div class="mt-2 table-responsive p-4" style="background-color: #fff; border-radius: 5px; width: 100%;">
            <table id="dataTable" class="table table-hover table-striped display text-center" style="width:100%; ">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr>
                      <th style="vertical-align: top;"></th>
                      <th style="vertical-align: top;">ID</th>
                      <th style="vertical-align: top;">UNIDAD OPERATIVA</th>
                      <th style="vertical-align: top;">FECHAS</th>
                      <th style="vertical-align: top;">DÍAS SERVICIO</th>
                      <th style="vertical-align: top; width: 500px !important;">PUNTO RECOGIDA</th>
                      <th style="vertical-align: top;">DESTINO</th>
                      <th style="vertical-align: top;">HORA DE ENCUENTRO</th>
                      <th style="vertical-align: top;">HORA DE REGRESO</th>
                      <th style="vertical-align: top;">CAPACIDAD SERVICIO</th>
                      <th style="vertical-align: top;">CANTIDAD DE PAX</th>
                      <th style="vertical-align: top;">OBSERVACIONES</th>
                      <th style="vertical-align: top;">TIPO DE SERVICIO</th>
                      <th style="vertical-align: top;">N° DE VEHICULOS</th>
                      <th style="vertical-align: top;">SOLICITANTE</th>
                      <th style="vertical-align: top;">ESTADO</th>
                      <th style="vertical-align: top;">OPCIONES</th>
                    </tr>
                </thead>
                <tbody style="font-size: .9rem;">
                    <?php foreach ($listarServiciosVariables as $lsv){ 
                      $listarTiposServiciosVariablesID = $programacion->listarTiposServiciosVariablesID($lsv['tipo_servicio']);

                      ?>

                      <tr>      
                          <?php if($lsv['estado'] == 'V'){ ?>                        
                              <td><a href="" class="btn btn-outline-warning" style="border-radius: 50%;"><i class="fa fa-thumb-tack"></i></a></td>  
                          <?php } else if ($lsv['estado'] == 'M'){ ?> 
                              <td style="color: #de1d1d; cursor: pointer;" onclick="validarNovedad(<?php echo $lsv['id_servicio']; ?>); ">
                                  <i class="fa fa-search-plus mr-1" style="font-size: 1.5rem;"></i> <strong>OBS</strong>
                              </td>
                          <?php } else{ ?>
                            <td>-</td>
                          <?php } ?>
                          <td><?php echo str_pad($lsv['id_servicio'], 4, "0", STR_PAD_LEFT); ?></td>  
                          <!-- <td><strong><?php $listarUnidadOperativaId = $programacion->listarUnidadOperativaId($lsv['unidad_operativa']); echo utf8_encode($listarUnidadOperativaId[0]['unidad_operativa']); ?></strong></td>  --> 
                          <td><strong><?php echo $lsv['unidad_operativa']; ?></strong></td> 
                          <td>
                              <?php 
                                  if ($lsv['fecha_inicial'] == $lsv['fecha_final']) {
                                      echo $lsv['fecha_inicial'];
                                  }else{
                                      echo '<strong>DEL</strong> ' . $lsv['fecha_inicial'] . ' <strong>AL</strong> ' . $lsv['fecha_final']; 
                                  }
                              ?>
                          </td>  
                          <td>
                              <?php
                                  $firstDate = date('Y-m-d', strtotime($lsv['fecha_inicial']));
                                  $secondDate = date('Y-m-d', strtotime($lsv['fecha_final']));

                                  $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

                                  $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                                  $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                  $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

                                  echo "<strong>" . ($days + 1) . " DÍAS</strong>";
                                  
                              ?>
                          </td>
                          <td style="width: 500px !important;"><?php echo $lsv['direccion'] ?></td>  
                          <td><?php echo $lsv['lugar_destino'] ?></td>  
                          <td><?php echo date('h:i A', strtotime($lsv['hora_encuentro'])); ?></td>  
                          <td><?php echo date('h:i A', strtotime($lsv['hora_regreso'])); ?></td>  
                          <td><?php echo $lsv['capacidad']; ?></td>  
                          <td><?php echo $lsv['cant_pax'] . ' PAX'; ?></td>  
                          <td><?php echo $lsv['observaciones'] ?></td>  
                          <td>
                              <strong style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="<?php echo $listarTiposServiciosVariablesID[0]['tipo_servicio'] ?>">
                                  <?php  echo $listarTiposServiciosVariablesID[0]['codigo']; ?>
                              </strong>
                          </td>  
                          <td><?php echo $lsv['num_buses']; ?></td>  
                          <td><?php echo $lsv['id_solicitante']; ?></td>  
                          
                          <?php if ($lsv['estado'] == 'P'){ ?>
                              <td style="color: #de1d1d; cursor: pointer;" data-toggle="modal" onclick="validarID(<?php echo $lsv['id_servicio']; ?>);" data-target="#modalEstados">
                                    <i class="fa fa-clock-o" style="font-size: 1.5rem; cursor: pointer;"></i> <strong>PENDIENTE</strong>
                              </td>
                          <?php } else if($lsv['estado'] == 'V'){ ?>
                              <td style="color: #38a31d;">
                                  <i class="fa fa-check-circle-o" style="font-size: 1.5rem;"></i> <strong>VERIFICADO</strong>
                              </td>                          
                            <?php } else if($lsv['estado'] == 'M'){ ?>
                              <td style="color: #de1d1d; cursor: pointer;" data-toggle="modal" onclick="validarID(<?php echo $lsv['id_servicio']; ?>);" data-target="#modalEstados">
                                    <i class="fa fa-clock-o" style="font-size: 1.5rem; cursor: pointer;"></i> <strong>PENDIENTE</strong>
                              </td>
                          <?php } ?>
                          <td>
                            <a href="actualizarSolicitudVariables.php?id_servicio=<?php echo $lsv['id_servicio']; ?>" class="btn btn-info" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-pencil-square-o" ></i></a>
                          </td>
  
                      </tr>
                    <?php } ?>

                    
                </tbody>
            </table>
        </div>

     
    </section>

    <!-- MODAL ESTADOS SOLICITUDES -->

      <div class="modal fade" id="modalEstados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

                <div class="notice notice-info mb-3">
                  <strong style="font-size: 1.1rem;">MODIFICAR ESTADO</strong>
                </div>

                <section class="text-center">
                  <p>¿ Desea cambiar el estado de la solicitud ?</p>
                </section>

                <div class="col-12 d-flex justify-content-center">
                    <form action="../Controlador/cambiarEstadoSolicitudVariable.php" id="formVerificar" method="POST">

                        <input type="hidden" value="V" id="estado" name="estado" class="form-control">
                        <input type="hidden"  id="id_servicio" name="id_servicio" class="form-control">

                        <button type="submit" class="btn btn-xs btn-outline-success col-12 mr-2" id="verificar">
                            <i style="font-size: 1.2rem;" class="fa fa-check" aria-hidden="true"></i> VERIFICAR 
                        </button>

                    </form>

                     <button class="btn btn-xs btn-outline-danger col-4 ml-2" onclick="validarOpcionCancelar();">
                        <i style="font-size: 1.2rem;" class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>

                <form action="../Controlador/cambiarEstadoSolicitudVariable.php" id="formObs" method="POST" class="p-2 mt-4" style="display: none;">

                  <input type="hidden" value="M" id="estado" name="estado" class="form-control">
                  <input type="hidden" id="id_servicio1" name="id_servicio1" class="form-control">

                  <div>
                    <label for="">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" required="true"></textarea>
                  </div>

                  <div class="d-flex justify-content-center mt-2">
                    <button type="submit" class="btn btn-outline-success">Guardar</button>
                  </div>

                </form>

              </div>
            </div>
          </div>
      </div>

    <!-- MODAL NOVEDADES -->

      <div class="modal fade" id="modalNovedades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                  <div class="notice notice-warning mb-3">
                    <strong style="font-size: 1.1rem;">OBSERVACIÓN DE LA SOLICITUD</strong>
                  </div>

                  <section class="col-12 p-3" id="contentObs"></section> 

              </div>
            </div>
          </div>
      </div>

    <!-- MODAL CARGAR MASIVAMENTE EXCEL -->

      <div class="modal fade" id="modalCargarExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                  <div class="notice notice-warning mb-3 mt-1">
                    <strong style="font-size: .9rem;"><i class="fa fa-upload mr-2" style="font-size: 1.6rem;"></i> CARGAR EXCEL</strong>
                  </div>

                  <form action="../Controlador/importarExcelServiciosVariables.php" method="POST" enctype="multipart/form-data">
                      <section class="mt-3 mb-3" style="border: 2px dashed #d1d1d1; padding: 10px;">
                        <label for=""><strong>EXCEL</strong></label>
                        <div>
                            <input type="file" id="excel" name="excel" class="form-control" style="text-transform: lowercase !important;">
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                        <button type="submit" id="cargarExcel" class="btn btn-outline-warning col-3 mt-4"><strong>Subir <i class="fa fa-file-excel-o"></i></strong></button>
                        </div>

                      </section>  
                  </form>
              </div>
            </div>
          </div>
      </div>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>

  <script>

      $(document).ready(function() {
          $('#dataTable').DataTable({
              "scrollX": true, 
              "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
              },
          });
      });

      $(document).ready(function() {
        document.getElementById("excel").value = "";
      });

      function validarOpcionCancelar(){
          document.getElementById('formObs').style.display = 'block';
      }

      function validarID(val){
        document.getElementById("id_servicio").value = val;
        document.getElementById("id_servicio1").value = val;
      }

      function validarNovedad(val){
        var parametros = {
            "id_servicio" : val
        };

        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '../Controlador/consultarObservacionSolicitudVariable.php', //archivo que recibe la peticion
            type:  'POST', //método de envio
            beforeSend: function () {
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                //alert(response);
                $("#contentObs").html(response);
                $("#modalNovedades").modal("show");

            }
        })
      }
  </script>

</body>
</html>