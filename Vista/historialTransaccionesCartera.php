<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Usuario.php';

$transacciones = new Transacciones();
$vehiculo = new Vehiculo();
$usuario = new Usuario();

$listarHistorialTransacciones = $transacciones->listarHistorialTransacciones();
//print_r($listarHistorialTransacciones);

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

            #loading{
                background-image:url('../Resources/images/renderLoader.gif');
                background-position: 0px -150px;
                height: 55px;
                width: 100%;
            
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
                    <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Conceptos Cobro</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Historial de Transacciones</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">HISTORIAL DE TRANSACCIONES</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a onclick="refrescarEstadoTransacciones();" id="buttonsKV" class="btn btn-outline-info">Actualizar estado de transacciones <i style="font-size: 1.3rem;" class="fa fa-refresh ml-1"></i></a>
            </div>

            <div class="mt-2 p-3 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>ID</th>
                            <th>FECHA</th>
            				<th>MODULO</th>
                            <th>NUMERO DE REFERENCIA</th>
                            <th width="400">DESCRIPCIÓN</th>
                            <th>VALOR</th>
            				<th>ESTADO</th>
                            <th>USUARIO</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listarHistorialTransacciones as $lht) {
                            $result = json_decode(utf8_encode($lht['resultado']));
                            $data = json_decode(utf8_encode($lht['data']));
                            //print_r($data);
                            
                            $extraGeneralInfo = json_decode(utf8_encode($lht['extraGeneralInfo']));
                            ?>
            				<tr class="text-center" style="font-size: 1rem;">
            					<td><?php echo $lht['id_transaccion']; ?></td>
                                <td><?php echo $lht['fecha']; ?></td>
                                <td>
                                    <?php if ($extraGeneralInfo->{'modulo'} == 1){ ?>
                                        <p>CARTERA</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 2){ ?>
                                        <p>EXTRACTOS OCASIONALES</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 3){ ?>
                                        <p>EXTRACTOS FIJOS</p>
                                    <?php } else if ($extraGeneralInfo->{'modulo'} == 4){ ?>
                                        <p>PAQUETE PLUS</p>
                                    <?php } ?>
                                </td>
                                <td><?php echo $lht['referencia']; ?></td>
                                <td><?php echo $data->{'payment'}->{'description'} ?></td>
                                <td><?php echo "$ " . number_format($data->{'payment'}->{'amount'}->{'total'}) . ' ' . '<strong style="font-size:.8rem">' . $data->{'payment'}->{'amount'}->{'currency'} . '</strong>' ?></td>
                                <td>
                                    <?php if ($lht['estado'] == 'REJECTED') { ?>
                                        <p><?php echo "RECHAZADA - CANCELADA"; ?><span class="fa fa-times-circle-o ml-2 " style="color: firebrick; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lht['estado'] == 'APPROVED') { ?>
                                       <p><?php echo "APROBADA"; ?><span class="fa fa-check-circle-o ml-2 " style="color: green; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lht['estado'] == 'SUSPENDED') { ?>
                                       <p><?php echo "SUSPENDIDA POR TIEMPO"; ?><span class="fa fa-ban ml-2 " style="color: firebrick; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lht['estado'] == 'PENDING') { ?>
                                        <p><?php echo "PENDIENTE"; ?><span class="fa fa-clock-o ml-2 " style="color: aquamarine; font-size: 1.4rem;"></span></p>
                                    <?php } else if ($lht['estado'] == 'FAILED') { ?>
                                        <p><?php echo "FALLIDO"; ?><i class="fa fa-times-circle-o ml-2 " style="color: firebrick; font-size: 1.4rem;"></i></p>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php 
                                        $listarUsuarioPorId = $usuario->listarUsuarioPorId($lht['id_usuario']); 
                                        echo $listarUsuarioPorId[0]['nombre'];
                                    ?>
                                </td>
            				</tr>

            			<?php } ?>
            		</tbody>
            	</table>
            </div>
            
        </section>
    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <!-- MODAL RECARGAR TRANSACCIÓN -->
        <div class="modal fade" id="estadoTransacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    
                    <div class="modal-body" id="modal-body" >
                        
                    </div>
                </div>
            </div>
        </div>

    <!--**************************--->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>

        <script>
            function refrescarEstadoTransacciones(){
                $.ajax({
                    url:   '../Controlador/programmedDailyFunction_BitacoraTransacciones.php',
                    beforeSend: function () {

                        $("#estadoTransacciones").modal("show");     
                        document.getElementById('modal-body').style.display = 'block';      
                        document.getElementById('modal-body').innerHTML = " <section class='loading' id='loading'></section>";

                        setTimeout(function() {  
                        });
                    },
                    success:  function (response) {

                        $(".fade").fadeOut(300);
                        alertify.success('Se han refrescado los estados de las transacciones');
                        location.reload();
                    }
                });
            }
        </script>
    <!--FIN SCRIPT-->
    
</body>
</html>