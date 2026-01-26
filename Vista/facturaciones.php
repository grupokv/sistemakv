<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Facturacion.php");
require_once ("../Modelo/Vehiculo.php");

$facturacion = new Facturacion();
$listarTodos = $facturacion->listarTodos();

$vehiculo = new Vehiculo();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Facturacion</title>
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
            <li class="breadcrumb-item active" aria-current="page">Facturación</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff;"><span class="fa fa-building"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span> Facturaciones</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarFacturacion.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Registrar Facturación <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
    				<th>VEHICULO</th>
                    <th>MES</th>
    				<th>DIAS FACTURADOS</th>
    				<th>VALOR TOTAL FACTURADO</th>
                    <th>VALOR TOTAL A PAGAR A TERCEROS</th>
                    <th>FECHA FACTURA</th>
                    <th>FECHA RECIBO PAGO</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach ($listarTodos as $ltf){ ?>
    				<tr>
    					<td><?php $listarPorId = $vehiculo->listarPorId($ltf['id_vehiculo']); echo $listarPorId[0]['placa']; ?></td>
                        <td><?php echo $ltf['mes']; ?></td>
                        <td><?php echo $ltf['dias_facturados']; ?></td>
                        <td><?php echo $ltf['valor_total_facturado']; ?></td>
                        <td><?php echo $ltf['valor_total_pagar_terceros']; ?></td>
                        <td><?php echo $ltf['fecha_factura']; ?></td>
                        <td><?php echo $ltf['fecha_recibo_pago']; ?></td>
                        <td><?php if($ltf['estado'] == 0){ echo "Activa";}else{echo "Culminada";} ?></td>
    					<td>
                            <?php if ($_SESSION['id_perfil'] == 1){ ?>
                                  <a name="eliminar" class="btn btn-danger" style="color: #fff; margin: 0px; padding: 0px 4px 0px 4px;"  data-toggle="modal" data-target="#confirmar">
                                    <span class="fa fa-trash"></span>
                                  </a> 
                                  <!-- Modal -->
                                    <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <p style="font-size: 1rem;">¿Esta seguro de eliminar esta facturación?</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            <a href="../Controlador/eliminarFacturacion.php?id_facturacion=<?php echo $ltf['id_facturacion']; ?>" class="btn btn-primary">Confirmar eliminación</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            <?php } ?>
                            

                           
                          
                            <a href="../Vista/actualizarFacturacion.php?id_facturacion=<?php echo $ltf['id_facturacion']; ?>" name= "id_facturacion" class="btn btn-info" style="color: #fff; margin: 0px; padding: 0px 4px 0px 4px;">
                              <span class="fa fa-edit"></span>

                            <?php if ($ltf['estado'] == 0) {?>
                                <a href="../Vista/culminarFacturaciones.php?id_facturacion=<?php echo $ltf['id_facturacion']; ?>" name= "id_facturacion" class="btn btn-success" style="color: #fff; margin: 2px; padding: 0px 4px 0px 4px;" data-toggle="modal" data-target="#culminar">
                                    <span class="fa fa-check"></span>
                                </a>

                                <!-- Modal -->
                                    <div class="modal fade" id="culminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar culminación de facturación</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <p style="font-size: 1rem;">¿Esta seguro de culminar esta facturación?</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            <a href="../Controlador/culminarFacturaciones.php?id_facturacion=<?php echo $ltf['id_facturacion']; ?>" class="btn btn-primary">Confirmar</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
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


</body>
</html>