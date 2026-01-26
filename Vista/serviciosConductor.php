<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Programacion.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Cliente.php';

$programacion = new Programacion();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$usuario = new Usuario();
$cliente = new Cliente();


$listarConductorPorId = $conductor->buscarConductorPorDocumento($_SESSION['sesion']);

$listarServiciosPorConductor = $programacion->serviciosFinalizadosPorConductor($listarConductorPorId[0]['id_conductor']);
$contarServicios = count($listarServiciosPorConductor);

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
      
      @media(max-width: 768px){
        .icono_inicio{
          display: none;
        }
      }
  </style>
</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--***************************-->
  
    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 
      <ol class="breadcrumb">
          <li class="breadcrumb-item " aria-current="page"><a href="inicioConductores.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Mis Servicios Finalizados</li>
      </ol>
    </div>

    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2 class="ml-4 mt-2 titulo_inicio" style="color: #fff;"><span class="fa fa-tasks mr-2 icono_inicio"></span>Mis Servicios</h2>
      </div>
    </div>
    <hr style="background-color:#5e99b1; ">


    <section class="">
      <div class="col-12 mt-2 p-4 table-responsive">  
        <table id="dataT" class="table">
          <thead>
              <tr>
                  <th>VEHICULO</th>
                  <th>FECHA SOLICITUD DEL SERVICIO</th>
                  <th>FECHA PRESTACIÓN DEL SERVICIO</th>
                  <th>CLIENTE</th>
                  <th>ESTADO</th>
                  <th>OPCIONES</th>
              </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($listarServiciosPorConductor as $lsc){ 

              $listarVehiculoPorId = $vehiculo->listarPorId($lsc['id_vehiculo']);
              $listarDetallesServiciosPorId = $programacion->listarDetallesServiciosPorId($lsc['id_servicio']);
              $listarClientePorId = $cliente->listarClientePorId($listarDetallesServiciosPorId[0]['id_cliente'])
              ?>
              <tr>
                  <td><?php echo $listarVehiculoPorId[0]['placa'] ?></td>
                  <td><?php echo $listarDetallesServiciosPorId[0]['fecha_solicitud'] ?></td>
                  <td>
                    <?php echo $listarDetallesServiciosPorId[0]['fecha_servicio'] . ' ' . $listarDetallesServiciosPorId[0]['hora_servicio']?>
                  </td>
                  <td><?php echo $listarClientePorId[0]['razon_social'] ?></td>
                  <td><?php 
                          if ($lsc['estado'] == 'A') {
                              echo "ASIGNADO"; 
                          }elseif ($lsc['estado'] == 'P') {
                              echo "PENDIENTE";
                          }elseif ($lsc['estado'] == 'C') {
                              echo "CANCELADO";
                          }elseif ($lsc['estado'] == 'F'){
                              echo "FINALIZADO";
                          } 
                      ?>     
                  </td>
                  <td>
                     <a href="" class="btn btn-info"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#exampleModal" onclick="modalServicio(<?php echo $lsc['id_servicio'];?>)"><span class="fa fa-search"></span></a>

                      <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.3rem;">DETALLE DEL SERVICIO</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" color: #fff;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <section id="contendio_modal">

                                    </section>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                  </td>
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
      function modalServicio(id_servicio){
          /*alert(id_servicio);*/
           var parametros = {
                        "id_servicio" : id_servicio
                };
                $.ajax({
                        data:  parametros, //datos que se envian a traves de ajax
                        url:   '../Controlador/listarInfoServicio.php', //archivo que recibe la peticion
                        type:  'post', //método de envio
                        beforeSend: function () {
                                $("#contenido_modal").html("Procesando, espere por favor...");
                        },
                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                /*alert(response);*/
                                $("#contendio_modal").html(response);
                        }
                });
        }


  </script>
</body>
</html>