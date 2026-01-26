<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once ("../Modelo/General.php");
require_once '../Modelo/Vehiculo.php';

$transacciones = new Transacciones();
$vehiculo = new Vehiculo();

$validarPaquetesPlusPorUsuario = $transacciones->validarPaquetesPlusPorUsuario($_SESSION['id_usuario']);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Pagos Pendientes</title>
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
            <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="pagos_pendientes_propietario.php">Pagos pendientes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mis Paquetes Plus</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-list-alt" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Mis paquetes Plus</h2>
    	</div>
    	<!-- <div class="col-6 d-flex justify-content-end">
            <a href="reportarPago.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Enviar Comprobante Pago <span class="fa fa-file"></span></a>

            <a href="realizarPagoConceptoCarteraPropietario.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">Realizar Pago <span class="fa fa-dollar"></span></a>
        </div> -->
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr class="text-center">
    				<th>VEHICULO</th>
    				<th>DESCRIPCIÓN</th>
                    <th>FECHA INICIAL VALIDEZ</th>
                    <th>FECHA FINAL VALIDEZ</th>
                    <th>DIAS DE VALIDEZ</th>
                    <th></th>
    				<th>ESTADO</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach ($validarPaquetesPlusPorUsuario as $vppu) {
                    
                    $listarBitacoraTransaccionID = $transacciones->listarBitacoraTransaccionID($vppu['id_transaccion']);
                    $data = json_decode(utf8_encode($listarBitacoraTransaccionID[0]['data']));
                    //print_r($data);
                    ?>
    				<tr class="text-center" style="font-size: 1rem;">
    					<td>
                            <?php  
                                $listarVehiculosPorId = $vehiculo->listarPorId($vppu['id_vehiculo']);
                                echo $listarVehiculosPorId[0]['placa'] . ' - Mo N° ' . $listarVehiculosPorId[0]['numero_movil'];
                            ?>               
                        </td>
                        <td><?php echo $data->{'payment'}->{'description'} ?></td>
                        <td>
                            <?php 
                                $fecha_inicial = explode("-", $vppu['fecha_inicial']);
                                $anio = $fecha_inicial[0];
                                $mes = mes($fecha_inicial[1]);
                                $dia = $fecha_inicial[2];

                                echo $dia . ' DE ' . strtoupper($mes) . ' DE ' . $anio;
                            ?>
                        </td>
                        <td>
                            <?php 
                                $fecha_final = explode("-", $vppu['fecha_final']);
                                $anio = $fecha_final[0];
                                $mes = mes($fecha_final[1]);
                                $dia = $fecha_final[2];

                                echo $dia . ' DE ' . strtoupper($mes) . ' DE ' . $anio;
                            ?>
                        </td>
                        <td>
                            <?php
                                $datetime1 = date_create($vppu['fecha_inicial']); 
                                $datetime2 = date_create($vppu['fecha_final']);  
                                $hoy = date_create(date('Y-m-d'));  
                                $diferencia = date_diff($datetime1, $datetime2);
                                $diasRestantes =  date_diff($datetime2, $hoy);

                                if ($vppu['fecha_final'] < date('Y-m-d')) {
                                    
                                    echo $diferencia->format('%a Dias validos.');

                                }else{

                                    echo $diferencia->format('%a Dias validos.') . ' - Dias restantes para invalidez ' . $diasRestantes->format('%a');
                                }
                            ?>
                        </td>
                        <td><i class="fa fa-check-circle-o" style="font-size: 2rem; color: darkgreen;"></i></td>
                        <td>
                            <strong><?php echo $vppu['estado']; ?></strong>
                        </td>
                        
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->


    <!-- Modal -->
        <div class="modal fade" id="reintentarPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    
                    <div class="modal-body text-center" id="modal-body">
                        <i style="color: darkcyan; font-size: 4rem;" class="fa fa-refresh fa-spin mt-4"></i>
                        <p style="color: darkcyan;" class="mt-3">¿Deséa reintentar el pago para este extracto?</p>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <a href="../Controlador/reintentarPago.php?id=<?php echo $lcoe['id_contrato_ocasional']; ?>" class="btn btn-info">Reintentar</a>
                    </div>
                </div>
            </div>
        </div>


    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->
</body>
</html>