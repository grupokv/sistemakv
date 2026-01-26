<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/OrdenServicio.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/ProveedorMantenimiento.php");
require_once ("../Modelo/TipoServicioMantenimiento.php");
require_once ("../Modelo/Subcategoria_Mantenimiento.php");
require_once ("../Modelo/Categoria_Mantenimiento.php");

$orden = new OrdenServicio();
$listarOrdenesPendientes = $orden->listarOrdenesPendientes(date('m'));


$vehiculo = new Vehiculo();
$tipoServicioMantenimiento = new TipoServicioMantenimiento();
$proveedor = new ProveedorMantenimiento();
$subcategoria = new Subcategoria_Mantenimiento();
$categoria = new Categoria_Mantenimiento();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Ordenes Pendientes</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->

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
            <li class="breadcrumb-item active" aria-current="page">Ordenes Pendientes</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
        <div class="col-6">
            <h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-wrench" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Ordenes de Servicio Pendientes</h2>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
        <table  id="dataT" class="table table-hover table-sm display" style="width:100%">
            <thead>
                <tr>
                    <th>ID ORDEN</th>
                    <th>PLACA</th>
                    <th>MOVIL</th>
                    <th>VALOR TOTAL</th>
                    <th>PROVEEDOR</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listarOrdenesPendientes as $le){ ?>
                    <tr>
                        <?php $datos_v = $vehiculo->listarPorId($le['id_vehiculo']);?>
                        <?php $datos_p = $proveedor->listarPorId($le['id_proveedor']);?>
                        <td><?php echo $le['id_orden']; ?></td>
                        <td><?php echo $datos_v[0]['placa']; ?></td>
                        <td><?php echo $datos_v[0]['numero_movil']; ?></td>
                        <td><?php echo '$ '.number_format($le['valor_total'],0); ?></td>
                        <td><?php echo $datos_p[0]['razon_social']; ?></td>
                        <td>
                            <?php
                            if ($le['estado'] == 'P') {
                                echo "PENDIENTE";
                            }
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#visualizarOrden" onclick="consultarDetalleOrden(<?php echo $le['id_orden']; ?>);"><span class="fa fa-search"></span></button>



                            <!-- MODAL VIZUALIZAR ORDEN -->
                                <div class="modal fade" id="visualizarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body" id="modal-body">
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <button class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#aprobarOrden" onclick="ObtenerIdOrdenA(<?php echo $le['id_orden']; ?>);"><span class="fa fa-check"></span></button>

                            <button class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#rechazarOrden" onclick="ObtenerIdOrdenR(<?php echo $le['id_orden']; ?>);"><span class="fa fa-ban"></span></button>    


                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- MODAL APROBAR ORDEN -->
    
        <div class="modal fade" id="aprobarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><strong>APROBAR ORDEN DE SERVICIO</strong></h5>

                            <p class="text-center mt-3">¿Esta segur@ de aprobar esta orden de servicio?</p>
                            
                            <input type="hidden" name="id_orden_servicioA" id="id_orden_servicioA">
                            <input type="hidden" name="estado" value="A">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" style="color: #fff;"> Aprobar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    <!-- MODAL RECHAZAR ORDEN -->    

        <div class="modal fade" id="rechazarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                    <div class="modal-body">
                        <h5 class="modal-title text-center" id="exampleModalLabel"><strong>RECHAZAR ORDEN DE SERVICIO</strong></h5>
                        <div class="alert alert-danger mt-2" role="alert">
                            <p class="text-center">¿Esta segur@ de rechazar esta orden de servicio?</p>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="col-12">
                                <label><strong>Motivo de Rechazo</strong></label>
                            </div>
                            <input type="hidden" name="id_orden_servicioR" id="id_orden_servicioR">
                            <input type="hidden" name="estado" value="R">

                            <div class="col-12">
                                <textarea name="motivo" id="motivo" class="form-control" placeholder="Motivo rechazo"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" style="color: #fff;">Rechazar</button>
            </div>
            </div>
        </div>


    <!-- FIN CONTENIDO -->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    function consultarDetalleOrden(id_orden){
        
        var parametros = {
                "id_orden" : id_orden
        };
        
        $.ajax({
            data:  parametros, //datos que se envian a traves de ajax
            url:   '../Controlador/consultarDetalleOrdenServicio.php', //archivo que recibe la peticion
            type:  'POST', //método de envio
            beforeSend: function () {
                    $("#modal-body").html("Procesando, espere por favor...");
            },
            success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
                    $("#modal-body").html(response);
            }
        });
    }


    function ObtenerIdOrdenR(id_orden){
        document.getElementById('id_orden_servicioR').value = id_orden;      
    }

    function ObtenerIdOrdenA(id_orden){
        document.getElementById('id_orden_servicioA').value = id_orden;      
    }

    
    </script>


</body>
</html>