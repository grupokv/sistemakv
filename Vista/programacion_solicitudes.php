<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
require_once("../Modelo/Cliente.php");

$programacion = new Programacion();
$cliente = new Cliente();

//$fecha = "2021-03-01";
$fecha = "03";
//$fecha = date('m');

if(($_SESSION['id_usuario'] == 2)){
    $listar = $programacion->listar_solicitudes_fecha($fecha);
} else {
    $listar = $programacion->listar_solicitudes_usuario_fecha($_SESSION['id_usuario'], $fecha);
}


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
  function modal(id,cant1,cant2){
    $("#exampleModalLabel").html('DETALLE SOLICITUD No. '+id );
    $('#contenido_modal').load('contenido_modal.php?id='+id,function(){
      $('#exampleModal').modal({show:true});
    });
    document.getElementById('Agregar').value = id;
    if(cant1 >= cant2){
      document.getElementById('Agregar').style.display = "none";
    } else {
        document.getElementById('Agregar').style.display = "block";
    }
  }

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
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>
         </ol>
    </div>
    
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
        <div class="col-6">
            <h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-users" style="border: 1px solid #fff; border-radius: 50%; padding: 5px;"></span> Solicitudes</h2>
        </div>
        <div class="col-6 d-flex justify-content-end">
			<a href="filtroServicios.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Buscar Servicio <span class="fa fa-search"></span></a>
            <a href="registrarSolicitud.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Nueva solicitud <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
        <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
            <thead>
                <tr>
                    <th>Nº SOLICITUD</th>
                    <th>CLIENTE</th>
                    <th>IDAS</th>
                    <th>RETORNOS</th>
                    <th>FECHA SOLICITUD</th>
                    <th>DETALLE</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listar as $lc){ ?>
                    <tr>
                        <td><?php echo $lc['id_solicitud']; ?></td>
                        <td><?php $datos_cliente = $cliente->listarClientePorId($lc['id_cliente']); echo $datos_cliente[0]['razon_social']  ?></td>
                        <td><?php echo $lc['servicios_ida'] ?></td>
                        <td><?php echo $lc['servicios_retorno'] ?></td>
                        <td><?php echo $lc['fecha_solicitud'] ?></td>
                        <?php $servicios_sol = $programacion->serviciosPorIdSolicitud($lc['id_solicitud']); ?>
                        <?php $cant = count($servicios_sol); $cant_total = $lc['servicios_ida']+$lc['servicios_retorno']?>
                        <td>
                          <a href="" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#exampleModal" onclick="modal(<?php echo $lc['id_solicitud'].','.$cant.','.$cant_total;?>)">
                                    <span class="fa fa-search"></span>
                            </a>
                        </td>
                        <td>
                            
                            <?php if (($lc['estado'] != 'F')and($lc['estado'] != 'C')){ ?>

                              <a href="actualizarSolicitud.php?ids=<?php echo $lc['id_solicitud'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                    <span class="fa fa-edit"></span>
                              </a>
                              <?php if($cant == 0){ ?>
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#cerrar" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="cerrar(<?php echo $lc['id_solicitud'];?>)">
                                    <span class="fa fa-close"></span></a>
                              </a>
                              <?php } ?>
                            <?php }  ?>
                             
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content f-flex justify-content-center">
          <div class="modal-header" style="height: 60px; background-color: #5e99b1; color: #FFF " >
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="color:#FFF">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <section id="contenido_modal" name="contenido_modal"></section>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-outline-success" id="Agregar" value="" onclick="agregar(this.value)">Agregar</button>
          </div>
        </div>
      </div>
    </div>

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

    <!-- Modal -->
    <div class="modal fade" id="cerrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width:50%;margin:0 auto">
                <form method="POST" action="../Controlador/cambiarEstadoSolicitud.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo_cerrar"></h5>
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
                    
                    <input type="hidden" name="id_s" id="id_s" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Finalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cerrarServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width:50%;margin:0 auto">
                <form method="POST" action="../Controlador/cambiarEstadoServicio.php">
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
      function agregar(id){
        window.location.href = "registrarServicio.php?ids="+id;
      }
      function cerrar(id){
        document.getElementById('titulo_cerrar').innerHTML = 'Finalizar Solicitud No. '+id;
        document.getElementById('id_s').value = id;
      }
      function cerrarServicio(id,id_solicitud){
        document.getElementById('titulo_cerrar_servicio').innerHTML = 'Finalizar Servicio No. '+id+' de la Solicitud No. '+id_solicitud;
        document.getElementById('id_sol').value = id_solicitud;
        document.getElementById('id_serv').value = id;
      }
    </script>
</body>
</html>