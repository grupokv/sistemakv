<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once '../Modelo/Vehiculo.php';

$transacciones = new Transacciones();
$vehiculo = new Vehiculo();

$listarHistorialTransaccionesUsuario = $transacciones->historialTransaccionesUsuario($_SESSION['id_usuario']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Pagos Pendientes</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->

        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style>
          
            .barra-principal{
              background-color: #5e99b1;
              width: auto;
            }

            @media (max-width: 760px){
              
                .fa-plus{
                   display: none;
                }

                .titulo_principal{
                  text-align: center;
                  padding: 5px;
                  margin-bottom: 8px;
                }
            }
        </style>

  <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
        <section class="home_content"> 

            <div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="pagos_pendientes_propietario.php">Pagos pendientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Historial de Transacciones</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-list-alt mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">HISTORIAL DE TRANSACCIONES</b></strong>
            </div>

    	<!-- <div class="col-6 d-flex justify-content-end">
            <a href="reportarPago.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Enviar Comprobante Pago <span class="fa fa-file"></span></a>

            <a href="realizarPagoConceptoCarteraPropietario.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Realizar Pago <span class="fa fa-dollar"></span></a>
        </div> -->

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr class="text-center">
            				<th><strong>#</strong></th>
                            <th>FECHA</th>
            				<th>MODULO</th>
                            <th>NUMERO DE REFERENCIA</th>
                            <th width="400">DESCRIPCIÓN</th>
                            <th>VALOR</th>
            				<th>ESTADO</th>
                            <th>OPCIÓN</th>
            			</tr>
            		</thead>
            		<tbody>
                        <?php $i = 1; ?>
            			<?php foreach ($listarHistorialTransaccionesUsuario as $lhtu) {
                            $result = json_decode(utf8_encode($lhtu['resultado']));
                            $dataEnviada = json_decode(utf8_encode($lhtu['data']));
                            $extraGeneralInfo = json_decode(utf8_encode($lhtu['extraGeneralInfo']));
                            ?>
            				<tr class="text-center" style="font-size: 1rem;">
            					<td><?php echo $i; ?></td>
                                <td><?php echo $lhtu['fecha']; ?></td>
                                <td>
                                    <?php if ($extraGeneralInfo->{'modulo'} == 1){ ?>
                                        <p>CARTERA</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 2){ ?>
                                        <p>EXTRACTOS OCASIONALES</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 3){ ?>
                                        <p>EXTRACTOS FIJOS - AVAL</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 4){ ?>
                                        <p>PAQUETE PLUS</p>
                                    <?php } ?>
                                </td>
                                <td><?php echo $lhtu['referencia']; ?></td>
                                <td><?php echo $dataEnviada->{'payment'}->{'description'} ?></td>
                                <td><?php echo "$ " . number_format($dataEnviada->{'payment'}->{'amount'}->{'total'}) . ' ' . '<strong style="font-size:.8rem">' . $dataEnviada->{'payment'}->{'amount'}->{'currency'} . '</strong>' ?></td>
                                <td>
                                    <?php if ($lhtu['estado'] == 'REJECTED') { ?>
                                        <p><?php echo "RECHAZADA - CANCELADA"; ?><span class="fa fa-times-circle-o ml-2 " style="color: firebrick; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lhtu['estado'] == 'APPROVED') { ?>
                                       <p><?php echo "APROBADA"; ?><span class="fa fa-check-circle-o ml-2 " style="color: green; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lhtu['estado'] == 'PENDING') { ?>
                                        <p><?php echo "PENDIENTE"; ?><span class="fa fa-clock-o ml-2 " style="color: aquamarine; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lhtu['estado'] == 'FAILED') { ?>
                                        <p><?php echo "FALLIDO"; ?><i class="fa fa-times-circle-o ml-2 " style="color: firebrick; font-size: 1.4rem;"></i></p>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if(($lhtu['estado'] == 'FAILED') || ($lhtu['estado'] == 'REJECTED') || (($lhtu['estado'] == 'PENDING') && ($lhtu['resultado'] == ''))){ ?>

                                        <a onclick="validarIdTransaccion(<?php echo $lhtu['id_transaccion']; ?>);" data-toggle="modal" data-target="#reintentarPago" style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff; cursor: pointer;" class="btn btn-success"><i class="fa fa-refresh"></i></a>

                                    <?php } else if ($lhtu['estado'] == 'APPROVED') { ?>
                                        <?php if ($extraGeneralInfo->{'modulo'} == 1){ ?>
                                            <a href="PDF/reciboCaja.php?num_id_comprobante=<?php echo $extraGeneralInfo->{'num_id_comprobante'}?>" target="_blank" class="btn btn-info" style="margin: 0px; padding: 0px 4px 0px 3px;" data-toggle="tooltip" data-placement="bottom" title="Ver recibo de caja"><span class="fa fa-list-alt"></span></a>
                                        <?php } ?>
                                        
                                    <?php } ?>
                                </td>
            				</tr>

                            <?php $i++; ?>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>

        </section>
    <!-- FIN CONTENIDO -->


    <!-- Modal -->
        <div class="modal fade" id="reintentarPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <form action="../Controlador/reintentarPago.php" method="POST">
                        <div class="modal-body text-center" id="modal-body">
                            <i style="color: darkcyan; font-size: 4rem;" class="fa fa-refresh fa-spin mt-4"></i>
                            <p style="color: darkcyan;" class="mt-3">¿Deséa reintentar el pago?</p>
                        </div>

                        <!-- ID TRANSACCION -->
                        <input type="hidden" name="id_transaccion" id="id_transaccion" class="form-control">
                        

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-info">Reintentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>

    <script>
        
        function validarIdTransaccion(id){
            
            document.getElementById('id_transaccion').value = id;

        }
    </script>
    <!--FIN SCRIPT-->
</body>
</html>