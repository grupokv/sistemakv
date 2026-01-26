<?php 
include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/OrdenServicio.php");
require_once ("../Modelo/Vehiculo.php");
require_once ("../Modelo/ProveedorMantenimiento.php");

$orden = new OrdenServicio();
$listarE = $orden->listar(date('m'));
$vehiculo = new Vehiculo();
$proveedor = new ProveedorMantenimiento();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Ordenes Servicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- styles -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css"> 
    <!--fin  styles -->

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>

    <!--**************************--->
    
    <!-- CONTENIDO -->

    <section class="home_content">  
        
        <div aria-label="breadcrumb" class="mt-1">      
            <ol class="breadcrumb" style="background-color: #fff;">            
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ordenes Servicio</li>        
            </ol>    
        </div>    

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ORDENES DE SERVICIO</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a href="registrarOrdenServicio.php" class="btn btn-outline-info" id="buttonsKV">registrar orden servicio <i class="fa fa-plus"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #FFF;">
            <table  id="dataT" class="table table-hover display" style="width:100%">
                <thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
                    <tr>
                        <th>#</th>
                        <th>ID REGISTRO</th>
                        <th>PLACA</th>
                        <th>MOVIL</th>
                        <th>VALOR TOTAL</th>
                        <th>PROVEEDOR</th>
                        <th>ESTADO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $i = 1; ?>
                    <?php foreach ($listarE as $le){ ?>
                        <tr>
                            <?php $datos_v = $vehiculo->listarPorId($le['id_vehiculo']);?>
                            <?php $datos_p = $proveedor->listarPorId($le['id_proveedor']);?>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $le['id_orden']; ?></td>
                            <td><?php echo $datos_v[0]['placa']; ?></td>
                            <td><?php echo $datos_v[0]['numero_movil']; ?></td>
                            <td><?php echo '$ '.number_format($le['valor_total'],0); ?></td>
                            <td><?php echo $datos_p[0]['razon_social']; ?></td>
                            <td>
                                <?php
                                if ($le['estado'] == 'P') {
                                    echo "Pendiente";
                                } else if ($le['estado'] == 'R') {
                                    echo "Rechazada";
                                } else if ($le['estado'] == 'C') {
                                    echo "Cancelada";
                                } else if ($le['estado'] == 'F') {
                                    echo "Finalizada";
                                } else {
                                    echo "Aprobada";
                                }
                                ?>
                            </td>
                            <td>
                                
                                <?php if($le['estado'] == 'A'){ ?>

                                    <!-- FINALIZAR ORDEN-->
                                    <a href="subirOrden.php?id=<?php echo base64_encode($le['id_orden']); ?>" class="btn btn-outline-warning"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-download"></span></a>
                                    
                                    <a href="formato_orden.php?id=<?php echo base64_encode($le['id_orden']); ?>" target="_blank" class="btn btn-outline-success"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-print"></span></a>

                                    <button class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#cancelar" onclick="ObtenerIdOrdenC(<?php echo $le['id_orden']; ?>);"><span class="fa fa-close" data-toggle="modal" data-target="#cancelarOrden"></span></button>
                                <?php } ?>

                                <?php if($le['estado'] == 'C'){ ?>
                                    
                                    <button data-toggle="modal" data-target="#eliminarOrden" onclick="ObtenerIdOrdenE(<?php echo $le['id_orden']; ?>);" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash"></span></button>

                                <?php } ?>

                                <?php if($le['estado'] == 'R'){ ?>
                                    <button class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#eliminarOrdenR" onclick="ObtenerIdOrdenE2(<?php echo $le['id_orden']; ?>);" ><span class="fa fa-trash"></span></button>
                                  
                                <?php } ?>

                                <?php if($le['estado'] == 'P'){ ?>
                                    
                                    <a href="actualizarOrdenServicio.php?id_orden_servicio=<?php echo $le['id_orden']; ?>" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

                                    <button class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#eliminarOrdenP" onclick="ObtenerIdOrdenP(<?php echo $le['id_orden']; ?>);"><span class="fa fa-trash"></span></button>

                                <?php } ?>
                                    
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    
    </section>

    <!-- ************************************ -->
    <!-- ************************************ -->


    <!-- MODAL CANCELAR ORDEN -->

        <div class="modal fade" id="cancelarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                        <div class="modal-body">
                            <div class="notice notice-sistemakv">
                                <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CANCELAR ORDEN DE SERVICIO</b></strong>
                            </div>

                            <div class="alert alert-danger mt-2" role="alert">
                                <p class="text-center">¿Esta segur@ de cancelar esta orden de servicio?</p>
                            </div>
                            <div class="row m-3 p-2" style="border: 1px dashed #d1d1d1;">
                                <div class="col-12 mt-3">
                                    <label><strong>Motivo de Cancelación</strong></label>
                                </div>
                                <input type="hidden" name="id_orden_servicioC" id="id_orden_servicioC">
                                <input type="hidden" name="estado" value="C">

                                <div class="col-12 mt-3 mb-4">
                                    <textarea name="motivo" id="motivo" class="form-control" placeholder="Motivo Cancelación"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" style="color: #fff;">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- MODAL ELIMINAR ORDEN PENDIENTE -->
                                
        <div class="modal fade" id="eliminarOrdenP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                        <div class="modal-body">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><strong>ELIMINAR ORDEN DE SERVICIO</strong></h5>
                            <div class="alert alert-danger mt-2" role="alert">
                                <p class="text-center">¿Esta segur@ de eliminar esta orden de servicio?</p>
                            </div>
                            
                            <input type="hidden" name="id_orden_servicioP" id="id_orden_servicioP">
                            <input type="hidden" name="estado" value="P">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" style="color: #fff;">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    <!-- MODAL ELIMINAR ORDEN -->
                                
        <div class="modal fade" id="eliminarOrdenR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                        <div class="modal-body">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><strong>ELIMINAR ORDEN DE SERVICIO</strong></h5>
                            <div class="alert alert-danger mt-2" role="alert">
                                <p class="text-center">¿Esta segur@ de eliminar esta orden de servicio?</p>
                            </div>
                            
                            <input type="hidden" name="id_orden_servicioE2" id="id_orden_servicioE2">
                            <input type="hidden" name="estado" value="E1">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" style="color: #fff;">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- MODAL ELIMINAR ORDEN -->
                                
        <div class="modal fade" id="eliminarOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../Controlador/opcionesOrdenesPendientes.php" method="POST">
                        <div class="modal-body">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><strong>ELIMINAR ORDEN DE SERVICIO</strong></h5>
                            <div class="alert alert-danger mt-2" role="alert">
                                <p class="text-center">¿Esta segur@ de eliminar esta orden de servicio?</p>
                            </div>
                            
                            <input type="hidden" name="id_orden_servicioE" id="id_orden_servicioE">
                            <input type="hidden" name="estado" value="E">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" style="color: #fff;">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- ************************************ -->
    <!-- ************************************ -->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>
        <script type="text/javascript">
            function ObtenerIdOrdenE2(id_orden){
                document.getElementById('id_orden_servicioE2').value = id_orden;      
            }

            function ObtenerIdOrdenP(id_orden){
                document.getElementById('id_orden_servicioP').value = id_orden;      
            }

            function ObtenerIdOrdenC(id_orden){
                document.getElementById('id_orden_servicioC').value = id_orden;      
            }

            function ObtenerIdOrdenE(id_orden){
                document.getElementById('id_orden_servicioE').value = id_orden;      
            }
        </script>

    <!-- FIN SCRIPT-->


</body>
</html>