<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Programacion.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Cliente.php';

$programacion = new Programacion();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();
$cliente = new Cliente();

$listarNovedades = $programacion->listarNovedades();

//echo $_SESSION['sesion'];
$listarConductorPorId = $conductor->buscarConductorPorDocumento($_SESSION['sesion']);
//$listarConductorPorId[0]['id_conductor'];

$fecha_inicial = date("Y-m-d", strtotime('monday this week'));
$fecha_final = date("Y-m-d",strtotime($fecha_inicial . "+ 1 week")); 

$serviciosAsignadosPorConductor = $programacion->serviciosAsignadosPorConductor($listarConductorPorId[0]['id_conductor'], $fecha_inicial, $fecha_final);

//print_r($serviciosAsignadosPorConductor);

$contarServicios = count($serviciosAsignadosPorConductor);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Mis Servicios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
      
      ::placeholder {
        font-size: .9em;
      }

      .form-group-stars label{
        font-size: 2.4rem;
        color: #444;
        padding: 10px;  
        float: right;
        transition: all 0.4s ease;
        cursor: pointer;
      }

      input:not(:checked) ~ #ratingStars:hover, input:not(:checked) ~ #ratingStars:hover ~ #ratingStars{
        color: #fd4;
      }

      input:checked ~ #ratingStars{
        color: #fd4;
      }

      @media(max-width: 768px){
        .icono_inicio{
          display: none;
        }

        #ratingStars{
          font-size: 1.6rem;
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
          <li class="breadcrumb-item active" aria-current="page">Mis Servicios Asignados</li>
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
              <tr class="text-center">
                  <th>N° SERVICIO</th>
                  <th>VEHICULO</th>
                  <th>FECHA PRESTACIÓN DEL SERVICIO</th>
                  <th>CLIENTE</th>
                  <th>ORIGEN</th>
                  <th>DESTINO</th>
                  <th>ESTADO</th>
                  <th>OPCIONES</th>
              </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($serviciosAsignadosPorConductor as $sapc){ 

              $listarVehiculo = $vehiculo->listarPorId($sapc['id_vehiculo']);
              //print_r($listarVehiculo);
              $listarDetallesServiciosPorId = $programacion->listarDetallesServiciosPorId($sapc['id_servicio']);
              $listarClientePorId = $cliente->listarClientePorId($listarDetallesServiciosPorId[0]['id_cliente'])
              ?>

              <tr class="text-center">
                  <td><?php echo $sapc['id_servicio'] ?></td>
                  <td><?php echo $listarVehiculo[0]['placa'] ?></td>
                  <td>
                    <?php echo $listarDetallesServiciosPorId[0]['fecha_servicio'] . '<strong> A LAS </strong>' . strtoupper(date("g:i a",strtotime($listarDetallesServiciosPorId[0]['hora_servicio']))); ?>
                  </td>
                  <td><?php echo $listarClientePorId[0]['razon_social'] ?></td>
                  <td><?php echo strtoupper($listarDetallesServiciosPorId[0]['origen']); ?></td>
                  <td><?php echo strtoupper($listarDetallesServiciosPorId[0]['destino']); ?></td>
                  <td>
                    <?php

                      if ($sapc['estado'] == 'A') {
                          echo "ASIGNADO"; 
                      }elseif ($sapc['estado'] == 'I') {
                          echo "INICIADO";
                      }elseif ($sapc['estado'] == 'C') {
                          echo "CANCELADO";
                      }elseif ($sapc['estado'] == 'F'){
                          echo "FINALIZADO";
                      } 

                    ?> 
                  </td>
                  <td>

                    <!--CONSULTAR-->
                      <button class="btn btn-info" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#exampleModal" onclick="modalServicio(<?php echo $sapc['id_servicio'];?>)" title="DETALLE SERVICIO"><i class="fa fa-search"></i></button>

                      <a href="registrarGerenciamientoViajes.php?id_servicio=<?php echo $sapc['id_servicio'] ?>" class="btn" style="background: darkcyan; color: #fff; margin: 0px; padding: 0px 4px 0px 4px;" title="GERENCIAMIENTO DE VIAJES"><i class="fa fa-file-text"></i></a>

                    <?php if ($sapc['estado'] == 'A') { ?>

                        <!-- INFORME DEL SERVICIO - ADICIONALES -->
                          <button class="btn btn-success" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#adicionalesServicio" onclick="modalAdicionales(<?php echo $sapc['id_asignacion'];?>)" title="ADICIONALES DEL SERVICIO"><i class="fa fa-clipboard" style="color: #fff;"></i></button>

                        <!--ENCUESTA SATISFACCIÓN-->
                          <button class="btn btn-warning" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#encuestaSatisfaccion" onclick="encuestaSatisfaccion(<?php echo $sapc['id_servicio'];?>)" title="ENCUESTA DE SATISFACCIÓN"><i class="fa fa-star" style="color: #fff;"></i></button>

                    <?php } ?>

                  </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </section>

    <!---------------------------------------------------------------->
    <!------------------------ FIN CONTENIDO ------------------------->
    <!---------------------------------------------------------------->


    <!---------------------------------------------------------------->
    <!--------------------------- MODALES ---------------------------->
    <!---------------------------------------------------------------->

    <!-- MODAL CONSULTAR DETALLE SERVICIO -->
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
            <div class="modal-footer d-flec justify-content-center">
              <button type="button" class="btn btn-outline-danger btn-block col-3" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

    <!-- MODAL ENCUESTA SATISFACCIÓN -->
      <div class="modal fade" id="encuestaSatisfaccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form action="../Controlador/finalizarServicio.php" method="post">

                <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.3rem;">ENCUESTA DE SATISFACCIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>

             
                <div class="modal-body">

                    <!--ID Servicio -->
                    <input type="hidden" name="id_servicio_satisfaccion" id="id_servicio_satisfaccion" value="">


                    <section class="row m-2" style="border: 2px dashed #d9d9d9;">
                      <div class="col-12 text-center mt-2 mb-3" id="Title-stars">
                          
                          <h5 style="font-size: 1.4rem; color: #333333;"><b>SATISFACCIÓN GENERAL DEL SERVICIO</b></h5>

                          <hr>

                          <p>¿Cúan de satisfecho/a está con el servicio?</p>

                          <section class="col-12 text-center mt-2 mb-2">

                            <input type="radio" id="satisfaccionSer1" name="satisfaccionServicio" value="S">
                            <label for="satisfaccionSer1"> Satisfecho/a</label><br>

                            <input type="radio" id="satisfaccionSer2" name="satisfaccionServicio" value="S-I">
                            <label for="satisfaccionSer2"> Ni satisfecho/a ni insatisfecho/a</label><br>

                            <input type="radio" id="satisfaccionSer3" name="satisfaccionServicio" value="I">
                            <label for="satisfaccionSer3"> Insatisfecho/a</label><br>

                          </section>

                      </div>
                    </section>


                    <section class="row m-2" style="border: 2px dashed #d9d9d9;">
                        <div class="col-12 text-center mt-2 mb-3" id="Title-stars">
                          
                            <h5 style="font-size: 1.4rem; color: #333333;"><b>ATENCIÓN BRINDADA</b></h5>

                            <hr>

                            <p>¿Qué tan satisfecho/a o insatisfecho/a está con la atención brindada en el servicio?</p>

                            <section class="col-12 text-center mt-2 mb-2">


                              <input type="radio" id="satisfaccion1" name="satisfaccion" value="Bike">
                              <label for="satisfaccion1"> Muy satisfecho/a</label><br>

                              <input type="radio" id="satisfaccion2" name="satisfaccion" value="Car">
                              <label for="satisfaccion2"> Algo satisfecho/a</label><br>

                              <input type="radio" id="satisfaccion3" name="satisfaccion" value="Boat">
                              <label for="satisfaccion3"> Ni satisfecho/a ni insatisfecho/a</label><br>

                              <input type="radio" id="satisfaccion4" name="satisfaccion" value="Boat">
                              <label for="satisfaccion4"> Algo insatisfecho/a</label><br>

                              <input type="radio" id="satisfaccion5" name="satisfaccion" value="Boat">
                              <label for="satisfaccion5"> Muy insatisfecho/a</label><br>

                            </section>

                        </div>
                    </section>

                    <section class="row m-2" id="calification" style="border: 2px dashed #d9d9d9;">

                        <div class="col-12 text-center mt-2 mb-3" id="Title-stars">
                          <h5 style="font-size: 1.4rem; color: #333333;"><b>VALORACIÓN DEL SERVICIO</b></h5>

                          <hr>

                          <p>En un rango del <strong>1</strong> al <strong>5</strong>, siendo <strong>1</strong> la calificación <strong>Mas Baja</strong> y <strong>5</strong> la <strong>Mas Alta.</strong> ¿Cómo calificaría la calidad de su experiencia con el servicio prestado?</p>
                        </div>
                      
                        <section class="col-12" style="display: flex; justify-content: center;">
                            <div class="form-group-stars">
                                <input style="display: none;" type="radio" name="rate" id="rate-1">
                                <label for="rate-1" class="fa fa-star" id="ratingStars"></label>
                                <input style="display: none;" type="radio" name="rate" id="rate-2">
                                <label for="rate-2" class="fa fa-star" id="ratingStars"></label>
                                <input style="display: none;" type="radio" name="rate" id="rate-3">
                                <label for="rate-3" class="fa fa-star" id="ratingStars"></label> 
                                <input style="display: none;" type="radio" name="rate" id="rate-4">
                                <label for="rate-4" class="fa fa-star" id="ratingStars"></label>
                                <input style="display: none;" type="radio" name="rate" id="rate-5">
                                <label for="rate-5" class="fa fa-star" id="ratingStars"></label>
                            </div>
                        </section>
                    </section>

                    <section class="row m-2" style="border: 2px dashed #d9d9d9;">
                      <div class="col-12 text-center mt-2 mb-3" id="Title-stars">
                          
                          <h5 style="font-size: 1.4rem; color: #333333;"><b>MEJORA DEL SERVICIO</b></h5>

                          <hr>

                          <p>Si pudiera mejorar nuestro servicio, ¿cómo lo haría?</p>

                          <section class="col-12 text-center mt-2 mb-2">

                            <textarea class="form-control" id="opinion_mejora" id="opinion_mejora"></textarea>

                          </section>

                      </div>
                    </section>


                    <section class="row m-2" style="border: 2px dashed #d9d9d9;">
                      <div class="col-12 text-center mt-2 mb-3" id="Title-stars">
                          
                          <p><b>Codigo de Verificación Funcionario</b></p>

                          <section class="col-12 text-center mt-2 mb-2">

                            <input class="form-control" id="codigo_verificacion" id="codigo_verificacion" />

                          </section>

                      </div>
                    </section>


                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-primary">Finalizar Encuesta</button>
                </div>

            </form>
          </div>
        </div>
      </div>

    <!-- MODAL ADICIONALES-->
      <div class="modal fade" id="adicionalesServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form action="../Controlador/registrarAdicionalesServicioConductor.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background-color: #5e99b1; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.3rem;">INFORME DEL SERVICIO - ADICIONALES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" color: #fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row modal-body d-flex justify-content-center p-5">
                   
                  <!-- ID SERVICIO-->
                    
                    <input type="hidden" name="id_servicio_adicional" id="id_servicio_adicional" class="form-control" value=""/>

                  <!-- SECCIÓN PRINCIPAL-->
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">

                      <!-- HORA INICIAL-->
                        <div class="col-12 mb-2 mt-1">
                            <label style="font-size: .9rem;"><b>FECHA DEL SERVICIO</b></label>   
                            <input type="text" name="fecha_servicio" id="datepicker" class="form-control"  required="required" readonly="readonly">
                        </div>
                      
                      <!-- KILOMETRAJE INICIAL-->
                        <div class="col-12 mb-2">
                          <label class="mt-3" for="tipo_novedad" style="color: #363636; font-size: .9rem;"><b>KILOMETRAJE INICIAL</b></label>

                          <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text" style="background-color: #5e99b1; color: #fff; border-top-left-radius: .40rem; border-bottom-left-radius: .40rem;"><i class="fa fa-car"></i></div>
                              </div>

                              <input type="text" class="form-control" id="kms_inicial" name="kms_inicial" required="required" placeholder="Kilometraje inicial">
                          </div>
                        </div>

                      <!-- HORA INICIAL-->
                        <div class="col-12 mb-2 mt-1">
                            <label style="font-size: .9rem;"><b>HORA INICIO DE SERVICIO</b></label>   
                            <input type="text" name="hora_inicial" id="clockpicker" class="form-control" required="required">
                        </div>

                      <!-- KILOMETRAJE FINAL-->
                        <div class="col-12 mb-2">
                          <label class="mt-3" for="tipo_novedad" style="color: #363636; font-size: .9rem;"><b>KILOMETRAJE FINAL</b></label>

                          <div class="input-group mb-2">

                            <div class="input-group-prepend">
                              <div class="input-group-text" style="background-color: #5e99b1; color: #fff; border-top-left-radius: .40rem; border-bottom-left-radius: .40rem;"><i class="fa fa-car"></i></div>
                            </div>

                            <input type="text" class="form-control" id="kms_final" name="kms_final" required="required" placeholder="Kilometraje final">

                          </div>
                        </div>

                      <!-- HORA FINAL-->
                        <div class="col-12 mb-2 mt-1">
                            <label style="font-size: .9rem;"><b>HORA FIN DE SERVICIO</b></label>   
                            <input type="text" name="hora_final" id="clockpicker1" class="form-control" required="required">
                        </div>

                    </section>
                  
                  <!-- COMBUSTIBLE-->  
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">

                        <!-- Combustible --> 
                          <div class="col-12 mb-2">
                              <label style="font-size: .9rem;"><b>COMBUSTIBLE</b></label>   
                              <select id="combustible" name="combustible" class="form-control col-12" onchange="validarCombustible(this.value)" required="required" >
                                  <option value="">SELECCIONAR</option>
                                  <option value="S">SI</option>
                                  <option value="N">NO</option>
                              </select>
                          </div>  
                          
                          <div class="col-12 mt-2 mb-3" id="galonesCombustible" style="display:none;">     
                            <label  style="font-size: .9rem;"><b>GALONES RECARGADOS</b></label>
                            <input type="text" id="galones_gasolina" name="galones_gasolina" class="form-control" placeholder="GALONES" />

                          </div>
                          
                          <div class="col-12 mt-2 mb-3" id="valorTotalCombustible" style="display:none;">     
                            <label  style="font-size: .9rem;"><b>VALOR TOTAL</b></label>
                            <input type="text" id="valor_total_combustible" name="valor_total_combustible" class="form-control" placeholder="$ TOTAL" />
                            
                          </div>
                          
                    </section>  
                  
                  <!-- PEAJES -->  
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">
                        
                        <!-- Peajes -->
                            <div class="col-12 mt-2 mb-3">  
                                <label  style="font-size: .9rem;"><b>PEAJES</b></label>
                              
                                <select id="peajes" name="peajes" class="form-control" onchange="validarPeajes(this.value);" required="required">
                                  <option value="">SELECCIONAR</option>
                                  <option value="S">SI</option>
                                  <option value="N">NO</option>
                                </select>
                            </div>
                          
                          
                            <div class="col-12 mt-2 mb-3" id="cantPeajes" style="display:none;">     
                                <label  style="font-size: .9rem;"><b>CANTIDAD DE PEAJES</b></label>
                                <input type="text" id="cant_peajes" name="cant_peajes" class="form-control" placeholder="CANTIDAD PEAJES" />
                            </div>

                          
                            <div class="col-12 mt-2 mb-3" id="totalPeajes" style="display:none;">     
                                <label  style="font-size: .9rem;"><b>VALOR TOTAL DE PEAJES</b></label>
                                <input type="number" id="valor_total_peajes" name="valor_total_peajes" class="form-control" placeholder="$ TOTAL PEAJES" />
                            </div>
                            
                            
                            <div class="col-12 mt-2 mb-3" id="soportePeajes" style="display:none;">     
                                <label  style="font-size: .9rem;"><b>SOPORTE DE PEAJES (FOTOGRAFIAS)</b></label>
                                <input type="file" id="soporte_peajes" name="soporte_peajes" class="form-control" multiple=""/>
                            </div>

                    </section>  
                   
                  <!-- PARQUEADERO--> 
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">
                        
                        <!-- Parqueadero -->
                            <div class="col-12 mt-2 mb-3">  
                                <label  style="font-size: .9rem;"><b>PARQUEADERO</b></label>
                            
                                <select id="parqueadero" name="parqueadero" class="form-control" onchange="validarParqueadero(this.value);" required="required">
                                  <option value="">SELECCIONAR</option>
                                  <option value="S">SI</option>
                                  <option value="N">NO</option>
                                </select>
                            </div>
                          
                            <div class="col-12 mt-2 mb-3" id="totalParqueadero" style="display:none;">     
                                <label  style="font-size: .9rem;"><b>VALOR TOTAL DE PARQUEADERO</b></label>
                                <input type="number" id="valor_total_parqueadero" name="valor_total_parqueadero" class="form-control" placeholder="TOTAL PARQUEADERO" />
                            </div>
                      
                    </section>  

                  <!-- PERNOCTADA-->
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">
                        
                        <!-- Pernoctada -->
                          <div class="col-12 mt-2 mb-3">     
                            <label  style="font-size: .9rem;"><b>PERNOCTADA</b></label>
                            <select id="pernoctada" name="pernoctada" class="form-control" onchange="validarPernoctada(this.value);" required="required">
                                  <option value="">SELECCIONAR</option>
                                  <option value="S">SI</option>
                                  <option value="N">NO</option>
                                </select>
                          </div>

                          <div class="col-12 mt-2 mb-3" id="totalPernoctada" style="display:none;">     
                            <label  style="font-size: .9rem;"><b>VALOR TOTAL</b></label>
                            <input type="number" id="valor_total_pernoctada" name="valor_total_pernoctada" class="form-control" placeholder="$ TOTAL" />
                          </div>

                    </section> 

                  <!-- FUNCIONARIO TRANSPORTADO-->
                    <section class="col-12 mb-2" style="border: 1px dashed #333333; width: 100%; height: auto; padding: 15px;">
                        
                        <!-- Funcionario Transportado -->
                          <div class="col-12 mt-2 mb-3">     
                            <label  style="font-size: .9rem;"><b>FUNCIONARIO TRANSPORTADO</b></label>
                            <input type="text" id="funcionario_transportado" name="funcionario_transportado" class="form-control" required="required" placeholder="NOMBRE FUNCIONARIO" />
                          </div>

                    </section>          
                  
                </div> 

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-info">Registrar</button>
                </div>

            </form>
          </div>
        </div>
      </div>

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

        $('#datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            language: 'es',
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        });

        $('#clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
        });


        $('#clockpicker1').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
        });


        function modalIniciar(id){
            document.getElementById('servicio_i').value = id;
        }
        function modalFinalizar(id){
            document.getElementById('servicio_f').value = id;
        }
        function encuestaSatisfaccion(id){
            document.getElementById('id_servicio_satisfaccion').value = id;
        }
        function modalAdicionales(id){
            document.getElementById('id_servicio_adicional').value = id;
        }
        
        function validarCombustible(val){
            if(val == 'S'){
                document.getElementById('galonesCombustible').style.display = 'block';
                document.getElementById('valorTotalCombustible').style.display = 'block';
            }else{
                document.getElementById('galonesCombustible').style.display = 'none';
                document.getElementById('valorTotalCombustible').style.display = 'none';
            }
        }
        
        
        function validarPernoctada(val){
            if(val == 'S'){
                document.getElementById('totalPernoctada').style.display = 'block';
            }else{
                document.getElementById('totalPernoctada').style.display = 'none';
            }
        }
        
        function validarPeajes(val){
            
            if(val == 'S'){
                document.getElementById('cantPeajes').style.display = 'block';
                document.getElementById('totalPeajes').style.display = 'block';
                document.getElementById('soportePeajes').style.display = 'block';
            }else{
                
                document.getElementById('cantPeajes').style.display = 'none';
                document.getElementById('totalPeajes').style.display = 'none';
                document.getElementById('soportePeajes').style.display = 'none';
            }
        }
        
        function validarParqueadero(val){
            
            if(val == 'S'){
                document.getElementById('totalParqueadero').style.display = 'block';
            }else{
                document.getElementById('totalParqueadero').style.display = 'none';
            }
        }



  </script>
</body>
</html>