<?php 

include ("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Programacion.php");

require_once("../Modelo/Cliente.php");

require_once("../Modelo/Usuario.php");

require_once("../Modelo/Vehiculo.php");

$programacion = new Programacion();

$date = date("Y-m-d");
$fecha = date("Y-m-d", strtotime("-1 day", strtotime($date)));

$listar = $programacion->serviciosPorClienteFecha($_SESSION['id_cliente'],$fecha);

$usuario = new Usuario();

$cliente = new Cliente();

$modVehiculo = new Vehiculo();

?>



<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <title>SistemaKV | Programación</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- styles-->

  <?php include("Template/styles.php") ?>

  <!--fin  styles -->

  <style>

    .modal-dialog{

      max-width: 90% !important;

    }

  </style>

  <script>



  function modal_servicio(id){

    $("#titulo_servicio").html('DETALLE SERVICIO No. '+id );

    $('#contenido_modal_servicio').load('contenido_modal_servicio.php?ids='+id,function(){

    });

  }

  </script>

</head>

<body>

    <!--MENU-->

       <?php include("Template/menu.php"); ?>

    <!--FIN MENU-->



    <!--**************************--->

    

    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 

         <ol class="breadcrumb">

            <li class="breadcrumb-item " aria-current="page"><a href="inicioCliente.php">Inicio</a></li>

            <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>

         </ol>

    </div>

    

    <hr style="background-color:#5e99b1; ">

    <div class="row" style="height: 60px; background-color: #5e99b1; ">

        <div class="col-6">

            <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-bus" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Servicios</h2>

        </div>

        <div class="col-6 d-flex justify-content-end">
	    <a href="agregarServicioCliente.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Agregar <span class="fa fa-plus"></span></a>

            <a href="reporteServiciosCliente.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Consultar Reporte <span class="fa fa-file"></span></a>

        </div>

    </div>

    <hr style="background-color:#5e99b1;">

    <div class="mt-2 p-4 table-responsive">

        <table  id="dataAsignaciones" class="table table-hover table-sm display table-not-ordered" style="width:100%">

            <thead>

                <tr>

                    <th>Nº SERVICIO</th>

                    <th>FECHA</th>

                    <th>HORA</th>

                    <th>CANTIDAD PAX</th>

                    <th>ORIGEN</th>

                    <th>DESTINO</th>

		    <th>CONTACTO</th>

                    <th>ESTADO</th>

                    <th>OPCIONES</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($listar as $lc){ ?>

                    <tr>

                        <td><?php echo $lc['id_detalle']; ?></td>

                        <td><?php echo $lc['fecha_servicio'] ?></td>

                        <td><?php echo $lc['hora_servicio'] ?></td>

                        <td><?php echo $lc['cantidad'] ?></td>

                        <td><?php echo strtr(strtoupper($lc['origen']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") ?></td>

                        <td><?php echo strtr(strtoupper($lc['destino']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") ?></td>

			<td><?php echo $lc['contacto']; ?></td>

                        <td>

                            <?php if($lc['estado'] == 'A'){ ?>

			      <?php

				$datos_asignacion = $programacion->asignadoActivoPorServicio($lc['id_detalle']);

				$datos_vehiculo = $modVehiculo->listarPorId($datos_asignacion[0]['id_vehiculo']);

			      ?>		

                              <a href="javascript:void(0)" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;" title="<?php echo $datos_vehiculo[0]['placa'];?>"><span class="fa fa-thumbs-o-up"></span></a>

                            <?php } else if($lc['estado'] == 'P') { ?>

                              <?php if($lc['fecha_servicio'] <= date('Y-m-d')){ ?>

                              <a href="javascript:void(0)" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-exclamation-triangle"></span></a>

                              <?php }  else if($lc['fecha_servicio'] <= (date('Y-m-d', strtotime('+1 day')))) { ?>

                              <a href="javascript:void(0)" class="btn btn-outline-primary" style="margin: 0px; padding: 0px 8px 0px 8px;"><span class="fa fa-exclamation"></span></a>

                              <?php } ?>

                            <?php } else if($lc['estado'] == 'F') {?>

			      <?php

				$datos_asignacion = $programacion->asignadoFinalizadoPorServicio($lc['id_detalle']);

				$datos_vehiculo = $modVehiculo->listarPorId($datos_asignacion[0]['id_vehiculo']);

			      ?>

                              <a href="javascript:void(0)" class="btn btn-outline-secondary" style="margin: 0px; padding: 0px 4px 0px 4px;" title="<?php echo $datos_vehiculo[0]['placa'];?>"><span class="fa fa-star"></span></a>

                            <?php } ?>

                        </td>

                        <td>

                            <!-- Consultar-->

                              <a href="javascript:void(0)" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#modal_servicio" onclick="modal_servicio(<?php echo $lc['id_detalle'];?>)"><span class="fa fa-search"></span></a>

                              <?php if (($lc['estado'] == 'P')){ ?>

                                      <!-- Actualizar-->

                                      <!--<a href="actualizarServicio.php?ids=<?php echo $lc['id_detalle'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>-->

                                      <!-- Cancelar-->

                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#cerrarServicio" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="cerrarServicio(<?php echo $lc['id_detalle'];?>,<?php echo $lc['id_solicitud'];?>)"><span class="fa fa-close"></span></a>

                              <?php } ?>

                        </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    

    <!-- FIN CONTENIDO -->





    <!-- script -->

    <?php include("Template/scripts.php"); ?>

    <!-- script-->

    <!--INICIO DETALLE SERVICIO-->

    <div class="modal fade" id="modal_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">

        <div class="modal-content f-flex justify-content-center">

          <div class="modal-header" style="height: 60px; background-color: #1b2d3b; color: #FFF " >

            <h5 class="modal-title" id="titulo_servicio"></h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true" style="color:#FFF">&times;</span>

            </button>

          </div>

          <div class="modal-body">

             <section id="contenido_modal_servicio" name="contenido_modal_servicio"></section>

          </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>

          </div>

        </div>

      </div>

    </div>

    <!--FIN DETALLE SERVICIO-->



    <div class="modal fade" id="cerrarServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >

        <div class="modal-dialog" role="document">

            <div class="modal-content" style="max-width:50%;margin:0 auto">

                <form method="POST" action="../Controlador/cambiarEstadoServicioCliente.php">

                    <div class="modal-header">

                        <h5 class="modal-title" id="titulo_cerrar_servicio"></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <section id="contenido_modal2">

                            <div class="col-12">

                              <textarea type="text" class="form-control" aria-label="Novedad de finalización" aria-describedby="basic-addon1" name="novedad_finalizacion" id="novedad_finalizacion" required="true" placeholder="Novedad de finalización"></textarea>

                            </div>

                        </section>

                    </div>

                    

                    <input type="hidden" name="id_sol" id="id_sol" value="">

                    <input type="hidden" name="id_serv" id="id_serv" value="">

                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                        <button type="submit" class="btn btn-primary">Finalizar</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

      function cerrarServicio(id,id_solicitud){

        document.getElementById('titulo_cerrar_servicio').innerHTML = 'Finalizar Servicio No. '+id;

        document.getElementById('id_sol').value = id_solicitud;

        document.getElementById('id_serv').value = id;

      }

    </script>

</body>

</html>