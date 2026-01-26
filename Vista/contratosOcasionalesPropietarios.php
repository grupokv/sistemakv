<?php 

include "../Controlador/Sesion/autenticar.php";

require_once "../Modelo/BitacoraTransaccion.php";
require_once "../Modelo/contratoOcasional.php";
require_once "../Modelo/ConceptosCobro.php";
require_once "../Modelo/EmpresaEnt.php";
require_once "../Modelo/Vehiculo.php";
require_once "../Modelo/Cliente.php";
require_once "../Modelo/Usuario.php";
require_once "../Modelo/Ciudad.php";
require_once "../Modelo/Fuec.php";

$id_usuario = $_SESSION['id_usuario'];

$contratoOcasional = new ContratoOcasional();
$transacciones = new Transacciones();
$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$empresa = new Empresa();
$cliente = new Cliente();
$usuario = new Usuario();
$ciudad = new Ciudad();
$fuec = new Fuec();

$listarContratosOcasionalesPorEmisor = $contratoOcasional->listarContratosOcasionalesPorEmisor($id_usuario);

$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);
$listado_veh = '';
$i=1;

foreach($buscarVehiculoPorPropietario as $vp){
    
    if($i==count($buscarVehiculoPorPropietario)){
        $listado_veh .= $vp['id_vehiculo'];
    } else {
        $listado_veh .= $vp['id_vehiculo'].',';
    }   
    
$i++; 

}

$pagos_pendientes = $concepto->pagosPendientes($listado_veh);
$cant_carteraPendiente = count($pagos_pendientes);

$vehiculos_pagos_pendientes = array();
foreach ($pagos_pendientes as $pp) {
    array_push($vehiculos_pagos_pendientes, $pp['id_vehiculo']);
}

$vehiculos_pp = array_values(array_unique($vehiculos_pagos_pendientes));

$cant = 1;
$placa_vehiculos = '';

for ($i=0; $i < count($vehiculos_pp); $i++) { 

    $listarVehiculosPorId = $vehiculo->listarPorId($vehiculos_pp[$i]);
    
    if ($cant > 1) {
        $placa_vehiculos .= $listarVehiculosPorId[0]['placa'] . ' - '; 
    }

    $cant++;
}

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>SistemaKV | Contratos Ocasionales</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
        <!-- STYLES -->
            <?php include("Template/styles.php") ?>
            <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

            <style type="text/css">
            
                #loading{
                    background-image:url('../Resources/images/renderLoader.gif');
                    background-position: 0px -150px;
                    height: 55px;
                    width: 100%;
                }

                .barra-principal{
                  background-color: #5e99b1;
                  width: auto;
                }

                .botones_principal{
                  display: flex;
                  justify-content: flex-end;
                }

                .boton-registro{
                  background-color: #fff; 
                  height: 40px; 
                  margin-top: 10px; 
                  margin-bottom: 10px; 
                  color: #00a0df;
                }

                @media (max-width: 760px){
                  
                    .fa-plus{
                       display: none;
                    }

                    .titulo_principal{
                      text-align: center;
                    }

                    .botones_principal{
                      display: flex;
                      justify-content: center;
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

    <!-- ************************** --->
    <!-- ************************** --->
    
        <!-- CONTENIDO -->  

            <section class="home_content"> 

                <div aria-label="breadcrumb" class="mt-1"> 
                     <ol class="breadcrumb" style="background-color: #fff;">
                        <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contratos Ocasionales</li>
                     </ol>
                </div>

                <div class="notice notice-sistemakv">
                    <strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">PLANILLAS OCASIONALES</b></strong>
                </div>

                <div class="notice notice-sistemakv">
                    <a href="registrarContratosOcasionalesPropietarios.php" id="buttonsKV" class="btn">Generar Planilla Ocasional <i class="fa fa-plus"></i></a>
                </div>

                <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
                	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
                		<thead style="background-color: #1b2d3b; color: #fff;">
                			<tr class="text-center">
                                <th>N°</th>
                                <th>CONTRATISTA</th>
                				<th>CONTRATANTE</th>
                                <th>TIEMPO VALIDEZ</th>
                                <th>EMISOR</th>
                                <th>ESTADO</th>
                				<th>OPCIONES</th>
                			</tr>
                		</thead>
                		<tbody>
                			<?php foreach ($listarContratosOcasionalesPorEmisor as $lcoe){ 

                                    $listarFuecPorId = $fuec->listarFuecPorIdContratoOcasional($lcoe['id_contrato_ocasional']);
                                    //print_r($listarFuecPorId);
                                    $listarTransaccionPorIdRegistro = $transacciones->listarTransaccionPorIdRegistro($listarFuecPorId[0]['id_fuec']);
                                    //print_r($listarTransaccionPorIdRegistro);
                                ?>

                				<tr class="text-center">                
                                    <td style="width: 50px;"><?php echo  str_pad($lcoe['id_contrato_ocasional'], 5, '0', STR_PAD_LEFT)?></td>
                                    <td>
                                        <?php 
                                            $listarEmpresaID = $empresa->listarPorId($lcoe['id_empresa']);
                                            echo $listarEmpresaID[0]['nombre_empresa'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $listarClienteID = $cliente->cliente_ID($lcoe['id_cliente']);
                                            echo $listarClienteID[0]['razon_social'];
                                        ?>
                                    </td>                                   
                                    <td>
                                        <?php 
                                            $datetime1 = date_create($lcoe['fecha_inicial_contrato_ocasional']); 
                                            $datetime2 = date_create($lcoe['fecha_final_contrato_ocasional']); 
                                            $diferencia = date_diff($datetime1, $datetime2);
                                            echo $diferencia->format('%R%a Dias validos.') . " | " . $lcoe['fecha_inicial_contrato_ocasional'] . " - " . $lcoe['fecha_final_contrato_ocasional']; 
                                        
                                        ?>
                                    </td>    

                                    <td>
                                        <?php 
                                            $listarUId = $usuario->listarUsuarioPorId($lcoe['id_responsable']);
                                            echo $listarUId[0]['nombre'];
                                        ?>        
                                    </td>
                                    <td>
                                        <?php 
                                            $fecha_actual = date('Y-m-d');
                                            if (($fecha_actual >= $lcoe['fecha_inicial_contrato_ocasional']) && ($fecha_actual <= $lcoe['fecha_final_contrato_ocasional']) && ($lcoe['estado'] == 'F')){ ?>
                                            <p><strong style="color: orange;">VIGENTE</strong> <i style="color: darkgreen; font-size: 1.7rem;" class="fa fa-check-circle-o"></i></p>
                                        <?php }else if($fecha_actual > $lcoe['fecha_final_contrato_ocasional']){ ?>
                                            <p><strong style="color: orange;">VENCIDO</strong> <i style="color: orange; font-size: 1.7rem;" data-toggle="tooltip" data-placement="bottom" title="El extracto está vencido" class="fa fa-minus-circle"></i></p>
                                        <?php }else if($lcoe['estado'] == 'P'){ ?>
                                            <p><strong style="color: orange;">PENDIENTE</strong> <i style="color: darkcyan; font-size: 1.7rem;" data-toggle="tooltip" data-placement="bottom" title="En espera para confirmación de la transaccion." class="fa fa-clock-o fa-spin"></i></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ((date('Y-m-d') >= $lcoe['fecha_inicial_contrato_ocasional']) && (date('Y-m-d') <= $lcoe['fecha_final_contrato_ocasional']) && ($lcoe['estado'] == 'F')){ ?>
                                            
                                            <!-- Ver Contrato Ocasional -->
                                            <a href="PDF/contratoOcasional.php?id_contrato_ocasional=<?php echo $lcoe['id_contrato_ocasional']; ?>" target="_blank" style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-outline-success"><span class="fa fa-search"></span></a>

                                            <!-- Ver Extracto -->
                                            <a style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;  font-family: 'Arial', sans-serif;"   class="btn btn-primary" data-toggle="modal" data-target="#fuecOcasional"  onclick="cargando_fuec(<?php echo $lcoe['id_contrato_ocasional'];?>)"><span class="fa fa-file-text-o"> FUEC</span></a>

                                            <?php if($lcoe['estado'] == 'P'){ ?>

                                                <!-- Continuar Proceso Pago -->
                                                <a style="margin: 0px; padding: 0px 4px 0px 4px; color: #fff;  font-family: 'Arial', sans-serif;"   class="btn btn-primary" data-toggle="modal" data-target="#fuecOcasional"  onclick="cargando_fuec(<?php echo $lcoe['id_contrato_ocasional'];?>)"><span class="fa fa-file-text-o"> FUEC</span></a>

                                            <?php } ?>

                                        <?php } ?>
                                    </td>    				
                                </tr>
                			<?php } ?>
                		</tbody>
                	</table>
                </div>

            </section>

        <!-- FIN CONTENIDO -->

    <!-- ************************** --->
    <!-- ************************** --->
    
        <!-- MODAL FUEC OCASIONAL -->
            <div class="modal fade" id="fuecOcasional" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgb(0,0,0,.8);">
                <div class="modal-dialog" role="document" >
                    <div class="modal-content">
                        
                        <div class="modal-body" id="modal-body" >
                            
                        </div>
                    </div>
                </div>
            </div>

        <!-- REINTENTAR PAGO -->
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

        <!-- MODAL CARTERA -->

            <?php if (($cant_carteraPendiente > 0) ){ ?>
                
                    <div class="modal fade" id="carteraPendiente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" >
                            <div class="modal-content">
                                <div class="modal-body text-center" id="modal-body" >
                                    <div class="col-12" style="height: auto;">
                                        <i style="color: #d62d2d; font-size: 6rem;" class="fa fa-exclamation-circle"></i>
                                        <h4 class="modal-title" style="color: #a1a1a1; "><strong>CARTERA PENDIENTE</strong></h4>
                                    </div> 
                                    <div class="col-12 mt-3">
                                        <p>El/los vehículo/s <strong><?php echo $placa_vehiculos ?></strong> anclado/s a su usuario tiene/n cartera pendiente, por favor póngase al día con los pagos para poder emitir extractos ocasionales con el vehiculo. </p>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <a type="button" href="inicioPropietarios.php" class="btn btn-outline-danger btn-block col-4" data-dismiss="modal"><strong>Cerrar</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php } ?>


    <!-- ************************** --->
    <!-- ************************** --->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script>

            function cargando_fuec(id_contrato_ocasional){
             
                document.getElementById('modal-body').style.display = 'block';      
                document.getElementById('modal-body').innerHTML = " <section class='loading' id='loading'></section>";
                setTimeout(function() {                     
                    window.location.href = "PDF/fuecContratoOcasional.php?id=" + window.btoa(id_contrato_ocasional) + "";
                    $(".fade").fadeOut(300);
                },3000);

            }

            function modalAviso(){

                $("#carteraPendiente").modal("show");   
            }

            $(window).on("load", modalAviso());
        </script>

    <!-- FIN SCRIPT -->

</body>
</html>