<?php 
include ('../Controlador/Sesion/autenticar.php');
require_once ('../Modelo/BitacoraTransaccion.php');
require_once ('../Modelo/contratoOcasional.php');
require_once ('../Modelo/ConceptosCobro.php');
require_once ('../Modelo/TipoVehiculo.php');
require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/Cartera.php');


$contratoOcasional = new ContratoOcasional();
$transacciones = new Transacciones();
$tipoVehiculo = new TipoVehiculo();
$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();
$cartera = new Cartera();

$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);
$listado_veh = '';
$i=1;

foreach($buscarVehiculoPorPropietario as $vp){
    
	if($i==count($buscarVehiculoPorPropietario)){
		$listado_veh .= $vp['id_vehiculo'];
	} else {
		$listado_veh .= $vp['id_vehiculo'] . ',';
	}	
	
$i++; 

}

//$vehiculosIDs = $vehiculo->listarVehiculosPorIDs($listado_veh);

$pagos_pendientes = $concepto->pagosPendientes($listado_veh);
//print_r($pagos_pendientes);

$conceptos = array();
foreach ($pagos_pendientes as $pp) {
    /*echo $pp['id_concepto'] . ', ';*/
    /*echo $pp['valor'] . ', ';*/
    array_push($conceptos, $pp['id_concepto']);
}

$conceptos = array_values(array_unique($conceptos));

//$cant_pp = count($pagos_pendientes);

$consultarPaquetesPlusActivos = $transacciones->validarPaquetesPlusPorUsuario($_SESSION['id_usuario']);

$consultarAvalIdVehiculo = $cartera->consultarAvalIdVehiculo($listado_veh);

$total = 0;
foreach($consultarAvalIdVehiculo as $caiv){ 
    $total += $caiv['valor'];
}


$historialTransaccionesPendientesPorUsuario = $transacciones->historialTransaccionesPendientesPorUsuario($_SESSION['id_usuario']);

$cantTPU = count($historialTransaccionesPendientesPorUsuario);

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

        <style type="text/css">
        
            @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');

            #card-events{
                height: 178px;
                background-color: #e9ecef;
            }

            .cards{
                border: 2px solid #ddd;
            }

            .cant-notificaciones{
                background-color: red; 
                width: 25px; 
                height: 25px; 
                position: absolute; 
                border-radius: 50%; 
                top: 12px; 
                left: 170px; 
                border: 3px solid #fff; 
                color: #fff; 
                font-size: .7rem; 
                line-height: 18px;
            }

            #alertBotones{
                height: 70px;
            }


            @media(max-width: 768px){
                #card-events{
                    height: auto;
                }

                .cards{
                    margin-left: 5px;
                    margin-right: 5px;
                }

                .cant-notificaciones{
                    position: absolute;
                    left: 185px;
                }

                .precio-col {
                    margin-bottom: 5%;
                }

                .modal-footer{
                    display: flex;
                    justify-content: center;
                }

                #botonCartera{
                    width: 100%;
                    margin-top: 5px;
                }

                #alertBotones{
                    height: 118px !important;
                }

            }

            #tabla-precios {
                display:inline-block;
                width:70%;
                margin-top:50px
            }

            /*Columnas*/

            .precio-col {
                display:inline-block;
                background-color:#fcfcfc;
                border:4px solid #f3f3f3;
                width:100%;
                max-width:500px;
                border-radius:10px;
            }

            @media screen and (min-width:768px) {

                .precio-col {
                    width:32%;
                    float:left;
                    margin-right:2%;
                }
     
                .precio-col:last-child {
                    margin-right:0
                }


                .modal-footer{
                    display: none;
                }

            }

            /*Headers*/

            .precio-col-header {
                background-color:#1b2d3b;
                padding:20px;
                border-top-left-radius:10px;
                border-top-right-radius:10px
            }

            .precio-col:nth-child(2) .precio-col-header {
                background-color:#dd9933;
            }

            .precio-col:nth-child(2) .precio-col-comprar {
                background-color:#5e99b1;
            }


            .precio-col:nth-child(2) .precio-col-comprar a:hover {
                color: #1b2d3b;
            }

            .precio-col:nth-child(2) .precio-col-comprar:hover {
                background-color: #e6e6e6;
            }

            .precio-col-header h4 {
                color:#f3f3f3;
                text-align:center;
                font-size:30px;
                font-weight:600;
                margin-bottom:0
            }

            .precio-col-header p {
                text-align:center;
                color:#f3f3f3;
                font-size:14px;
                margin-bottom:0
            }

            /*Características*/

            .precio-col-features {
                padding: 0 20px 20px 20px
            }

            .precio-col-features p {
                padding:20px 15px;
                margin:0;
                text-align:center;
                border-top:1px solid #ddd
            }

            .precio-col-features p:first-child,
            .precio-col-features p:last-child {
                border-top:none
            }

            /*Comprar*/

            .precio-col-comprar {
                padding:8px;
                max-width:200px;
                text-align:center;
                background-color:#5e99b1;
                color: #fff;            
                margin: 0 auto 20px;
                border-radius:5px;
                transition: all 0.3s
            }

            .precio-col-comprar a {
                color:#f3f3f3;
                padding:10px;
                font-size:12px;
                text-transform:uppercase;
                transition: all 0.3s
            }

            .precio-col-comprar:hover {
                background-color:#e6e6e6;
                transition: all 0.3s;
                cursor: pointer;

            }

            .precio-col-comprar:hover a {
                color:#1b2d3b;
                transition: all 0.3s
            }

            #titleAlertConfirm{
                font-family: 'Poppins', sans-serif;
                font-size: 1.1rem;
                color: #1b2d3b;
            }

            .ajs-button{
                border-radius: 5px;
                background-color: #5e99b1;
                color: #fff;
                box-shadow: none;
                border:0px;
            }

            .ajs-header{
                color: #1b2d3b !important;
            }

            #buttonsKV:hover{
                color: #fff !important;
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
                <li class="breadcrumb-item active" aria-current="page">Pagos Pendientes </li>
             </ol>
        </div>
    

        <div class="notice notice-sistemakv" style="background-color: #fff;">

            <button id="buttonsKV" class="btn btn-outline-info mb-1" data-toggle="modal" data-target="#myModal"> Paquetes Plus <i style="font-size: 1.3rem;" class="fa fa-shopping-cart ml-1"></i></button>

            <a id="buttonsKV" class="btn btn-outline-info mb-1" href="../Vista/historialTransaccionesPropietario.php" > Historial de Transacciones <i style="font-size: 1.3rem;" class="fa fa-history ml-1"></i></a>

        </div>

        <div id="cardsContent" class="col-12 d-flex justify-content-center" style="background-color: #fff;">
            <section class="row p-1 mt-2 mb-2" style=" width: 100%; background-color: #eeeeee">

                <?php if (count($consultarPaquetesPlusActivos) > 0) { ?>
                    <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                        <div class="box-part text-center">
                            <i class="fa fa-star fa-3x mb-3" aria-hidden="true"></i><?php if ($lsac != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsac;?></div><?php } ?>
                            <div class="title">
                                <h5 style="color: red;">Mis Paquetes Plus</h5>
                            </div>          
                            <div class="text">
                                <span style="font-size: 0.9rem;">Activos <strong style="color: red;"> <?php echo count($consultarPaquetesPlusActivos); ?></strong></span>
                            </div>
                            <a href="PaquetesPlusPropietario.php">Ver mas <span class="fa fa-search ml-1"></span></a>
                        </div>
                    </div>

                <?php } ?>
                
                <?php if (count($consultarAvalIdVehiculo) > 0) { ?>
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                            <div class="box-part text-center">
                                <i class="fa fa-money fa-3x mb-3" aria-hidden="true"></i><?php if ($lsac != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsac;?></div><?php } ?>
                                <div class="title">
                                    <h5 style="color: red;">Saldo Aval</h5>
                                </div>          
                                <div class="text">
                                        <span style="font-size: 0.9rem; color: #000;">TOTAL A PAGAR: <strong>$ <?php echo number_format($total); ?></strong></span>
                                </div>
                                <a href="avalVehiculosPropietarios.php">Ver mas <span class="fa fa-search ml-1"></span></a>
                            </div>
                        </div>
                <?php } ?>

                <?php   
                    for ($i=0; $i < count($conceptos); $i++) { 
                        $listarConceptosPorId = $concepto->listarPorId($conceptos[$i]);
                        $listarTotalPorConceptoYVehiculos = $concepto->listarTotalPorConceptoYVehiculos($conceptos[$i], $listado_veh);

                        ?>
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 p-3 mt-1 mb-1 cards mr-2 ml-2" style="background-color: #fff; border-radius: 4px;">
                            <div class="box-part text-center">
                                <i class="fa fa-automobile fa-3x mb-3" aria-hidden="true"></i><?php if ($lsac != 0){ ?><div class="text-center cant-notificaciones"><?php echo $lsac;?></div><?php } ?>
                                <div class="title">
                                    <h5 style="color: red;"><?php echo ucwords(strtolower($listarConceptosPorId[0]['detalle_concepto'])); ?></h5>
                                </div>          
                                <div class="text">
                                    <span style="font-size: 0.9rem; color: #000;">TOTAL A PAGAR: <strong>$ <?php echo number_format($listarTotalPorConceptoYVehiculos[0]['total']); ?></strong></span>
                                </div>           
                                <a href="detallePagosPendientesPorConcepto.php?id_concepto=<?php echo base64_encode($listarConceptosPorId[0]['id_concepto']); ?>">Ver mas <span class="fa fa-search ml-1"></span></a>
                            </div>
                        </div>

                    <?php }
                ?>

            </section>
        </div>
    </section>
    
    <!-- MODAL -->

    <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <section class="text-center mb-4">
                        <img width="100px" height="60px;" src="../Resources/img/kingvision_transparente.png">
                        <!-- <h5><strong> PAQUETES PLUS </strong></h5> -->
                    </section>
                    <div id="row tabla-precios">


                        <div class="precio-col">
                            <div class="precio-col-header">
                                <h4 class="mb-3">$50.000/mes</h4>
                                <p>PAQUETE PLUS</p>
                            </div>

                            <div class="precio-col-features  text-center">
                                <p>Van - Microbus - Campero - Camioneta</p>
                                <img width="60px" height="50px;" src="../Resources/img/camioneta.png">
                            </div>

                            <div class="precio-col-comprar">
                                <a onclick="abrirCompraPaquete(1, 50000, <?php echo $_SESSION['id_usuario']; ?>);"><strong>Comprar </strong><i class="fa fa-cart-plus" style="font-size: 1.2rem;"></i></a>
                            </div>
                        </div>

                        <!-- onclick="ComprarPaquete(); -->

                        <div class="precio-col">
                            <div class="precio-col-header">
                                <h4 class="mb-3">$60.000/mes</h4>
                                <p>PAQUETE PLUS</p>
                            </div>

                            <div class="precio-col-features text-center">
                                <p  class="mb-3">Buseta</p>
                                <img width="60px" height="50px;" src="../Resources/img/buseta.png">
                            </div>

                            <div class="precio-col-comprar">
                                <a onclick="abrirCompraPaquete(2, 60000, <?php echo $_SESSION['id_usuario']; ?>);">Comprar <i class="fa fa-cart-plus" style="font-size: 1.2rem;"></i></a>
                            </div>
                        </div>

                        <div class="precio-col">
                            <div class="precio-col-header">
                                <h4 class="mb-3">$70.000/mes</h4>
                                <p>PAQUETE PLUS</p>
                            </div>

                            <div class="precio-col-features text-center">
                                <p class="mb-3">Bus</p>
                                <img width="60px" height="50px;" src="../Resources/img/16784.png">
                            </div>

                            <div class="precio-col-comprar">
                                <a onclick="abrirCompraPaquete(3, 70000, <?php echo $_SESSION['id_usuario']; ?>);"><strong>Comprar </strong><i class="fa fa-cart-plus" style="font-size: 1.2rem;"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="col-xs-10 col-sm-10 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="ModalPaqPlusVehiculo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarCompraPaquete();">
                      <span aria-hidden="true" style="color: red;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <section id="confVehiculo"></section>

                </div>
            </div>
        </div>
    </div>

    <!-- FIN MODAL -->
     
    <!-- FIN CONTENIDO -->

    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->

    <script type="text/javascript">


        function random(min, max) {
            return min + Math.random() * (max - min);
        }

        function abrirCompraPaquete(value, costo, id_usuario){

            var parametros = {
                "num_paq" : value,
                "id_usuario": id_usuario
            };


            $.ajax({
                data:  parametros,
                url:   '../Controlador/validarTipoVehiculoPaquetePlus.php',
                type:  'POST',
                beforeSend: function () {
                    $("#confVehiculo").html("<div>Procesando, espere por favor...</div>");
                },
                success:  function (response) { 
                    $("#myModal").modal("hide");
                    $("#confVehiculo").html(response); 
                    $("#ModalPaqPlusVehiculo").modal("show"); 

                    var objFecha = new Date();
                    var Year = objFecha.getFullYear().toString();
                    var Month = "0" + (parseInt(objFecha.getMonth()) + parseInt(1));
                    var Day = objFecha.getDate();
                    var Hour = objFecha.getHours();
                    var Minute = objFecha.getMinutes();
                    var Second = objFecha.getSeconds();

                    var date = Year + Month + Day + Hour + Minute + Second;

                    var reference = parseInt(random(1000, 9999)) + date;
                    //alert(reference);

                    $("#myModal").modal("hide");
                    document.getElementById("descripcionPaquetePlus").innerHTML = '<input type="hidden" name="descripcion" id="descripcion" value="PAQUETE PLUS No ' + value +'">';
                    document.getElementById("costoPaquetePlus").innerHTML = '<input type="hidden" name="costo" id="costo" value="' + costo +'">';
                    document.getElementById("referenciaPagoPaquetePlus").innerHTML = '<input type="hidden" name="referencia" id="referencia" value="' + reference +'">';
 
                }
            });

            
        }

        function cerrarCompraPaquete(){
            $("#ModalPaqPlusVehiculo").modal("hide");   
            $("#myModal").modal("show");   
        }

        function validarForm(){
            if ($("#id_vehiculo").val() != 0) {
                if (<?php echo $cantTPU; ?> > 0) {
                    alertify.alert('TRANSACCIÓN EN CURSO', '¡Actualmente tiene una transaccion con estado pendiente, no podra avanzar hasta terminar el debido proceso de la transacción o intentarlo nuevamente mas tarde! \n \n Para validar el estado de la misma dirijirse a la sección de historial de transacciones.', function(){ alertify.error('Error'); });
                    return false;
                }
            }else{
                alertify.error('¡Error! No se ha seleccionado vehiculo para el paquete.'); 
                return false;
            }
            

        }


  </script>
</body>
</html>