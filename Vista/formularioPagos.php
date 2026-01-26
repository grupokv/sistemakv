<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Vehiculo.php");

$id_vehiculo = $_POST['id_vehiculo'];
$descripcion = $_POST['descripcion'];
$referencia = $_POST['referencia'];
$costo = $_POST['costo'];
$registroID = $_POST['registroID'];
$modulo = $_POST['modulo'];

/*
$id_cobro_propietario = $_GET['id_cobro'];*/

$ciudad = new Ciudad();
$conceptosCobro = new ConceptoCobro();
$usuario = new Usuario();
$vehiculo = new Vehiculo();

$listarVehiculoID = $vehiculo->listarPorId($id_vehiculo);
$ListarPropietario = $usuario->listarUsuarioPorId($listarVehiculoID[0]['id_propietario']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Confirmación de pago</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->

        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        <link rel="stylesheet" href="../Resources/css/stylesFormPagos.css">

        <style>

            .card{
                border: none;
            }

            .accordion{
                border: none;
            }

            .card-header{
                background-color: #fff
            }

            .card-header .title {
                font-size: 17px;
                color: #000;
                line-height: 0px
            }
            .card-header .accicon {
                float: right;
                font-size: 20px;  
                width: 1.2em;
            }
            .card-header{
                cursor: pointer;
                border: none;
                height: 50px;
                border-bottom: 2px solid #ddd;
            }
            .card-body{
                border-top: 1px solid #ddd;
            }
            .card-header:not(.collapsed) .rotate-icon {
                transform: rotate(180deg);
            }


            @media(max-width: 768px){
               
                #logoKV{
                    display: flex;
                    justify-content: center;
                }

                #logoPLACETOPAY{
                    display: flex;
                    justify-content: center;
                    margin-bottom:10px;
                }

                #contGeneral{
                    display: block !important;
                }

                #informacion_usuario{
                    margin-left: 0px !important;
                }

                #contLogos{
                    display: block !important;
                }

                .header_pagos{
                    height: auto;
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

    <!-- ************************************** -->

    <!-- CONTENIDO -->
        <section class="home_content"> 
            <form action="../Vista/confirmacionInfoTransaccion.php" class="mb-4" style="background-color: #fff;" method="POST" onsubmit="return validarForm()">
                <div class="col-12 main d-flex justify-content-center">
                    <section class="row content d-flex justify-content-between">

                        <!-- HEADER-->

                            <section id="contLogos" class="col-12 header_pagos d-flex justify-content-around">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <a id="logoKV" target="_blank" href="https://www.intranetgroupkv.com/"><img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="140" height="90" style="display: block; margin-top: 10px;"></a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <a id="Placetopay" target="_blank" href="https://www.placetopay.com/web/"><img src="https://static.placetopay.com/placetopay-logo.svg" alt="Placetopay" width="250" height="80" style="display: block; margin-top: 10px; margin-left: 30px;"></a>
                                </div>
                            </section>

                            <section class="col-12 titulo_pagos" style="margin-top: 0.5px;"></section>


                            <div class="col-12 text-center mt-3 mb-3">
                                <h5 style="color: #1b2d3b;"><strong>INFORMACIÓN DE PAGO</strong></h5>
                                <section class="row d-flex justify-content-center">
                                    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-3 col-lg-3" style="background: #f9b434; width: 100%; height: 3px;"></div>
                                    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-3 col-lg-3" style="background: #4c81a8; width: 100%; height: 3px;"></div>
                                </section>
                            </div>

                        <!-- FIN HEADER-->

                        <!-- ****************************-->

                            <!-- FORMS-->
                                <section id="contGeneral" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 mt-4 mb-4 mr-3" id="informacion_usuario">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 header_form_usu text-center">
                                            <p class="title_usuarios"><span class="fa fa-credit-card mt-1 "></span> <strong class="ml-2"> DATOS DEL PAGADOR </strong></p>
                                        </div>

                                        <input type="hidden" class="form-control" id="registroID" name="registroID" value="<?php echo $registroID; ?>">
                                        <input type="hidden" class="form-control" id="modulo" name="modulo" value="<?php echo $modulo; ?>">

                                        <section class="p-2">
                                            <div class="col-12 mt-4 p-2" style="background: #fafafa;">
                                                <label >
                                                    <strong>NOMBRES : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <input type="text" class="form-control" name="nombres_buyer" onkeypress="return sololetras(event);" onpaste="return false" placeholder="NOMBRES" style="border-style: dashed; background: #ffffff; font-size: .9rem;">
                                            </div>
                                            <div class="col-12 mt-1 p-2">
                                                <label>
                                                    <strong>APELLIDOS : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <input type="text" class="form-control" name="apellidos_buyer" placeholder="APELLIDOS" onkeypress="return sololetras(event);" onpaste="return false" style="border-style: dashed; background: #ffffff; font-size: .9rem;">
                                            </div>
                                            <div class="col-12 mt-4 p-2" style="background: #fafafa;">
                                                <label>
                                                    <strong>CORREO ELECTRÓNICO : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <input type="email" class="form-control"  name="email_buyer" onblur="validate(this.value);" id="email_buyer" placeholder="CORREO ELECTRÓNICO" style="border-style: dashed; background: #ffffff; font-size: .9rem;">
                                            </div>
                                            <div class="col-12 mt-1 p-2">
                                                <label>
                                                    <strong>TIPO DE DOCUMENTO : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <select class="form-control" data-live-search="true" name="tipo_documento_buyer"  placeholder="TIPO DE DOCUMENTO" style="border-style: dashed;  background: #ffffff; font-size: .9rem;">
                                                    <option value="0">SELECCIONAR</option>
                                                    <option value="CC">CEDULA DE CIUDADANIA</option>
                                                    <option value="CE">CEDULA DE EXTRANJERIA</option>
                                                    <option>SELECCIONAR</option>
                                                    <option>SELECCIONAR</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-4 p-2" style="background: #fafafa;">
                                                <label>
                                                    <strong>N° DE DOCUMENTO : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <input type="number" class="form-control" name="num_documento_buyer" id="num_documento_buyer" onkeyup="solo_numeros(this.value);" placeholder="NUMERO DE DOCUMENTO" style="border-style: dashed; background: #ffffff; font-size: .9rem;">
                                            </div>

                                            <div class="col-12 mt-4 p-2" style="background: #fafafa;">
                                                <label>
                                                    <strong>NUMERO CELULAR : </strong>
                                                    <strong style="color: #4c81a8;">*</strong>
                                                </label>
                                                <input type="number" class="form-control" name="num_celular_buyer" id="num_celular_buyer" onkeyup="solo_numeros(this.value);" placeholder="NUMERO CELULAR" style="border-style: dashed; background: #ffffff; font-size: .9rem;">
                                            </div>
                                        </section>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mt-4 mb-4" id="producto_pagar">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 header_form_serv text-center">
                                            <p class="title_usuarios"><span class="fa fa-credit-card mt-1 "></span> <strong class="ml-2"> DATOS DE LA OPERACIÓN</strong></p>
                                        </div>

                                        <section>
                                                <div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                    <label><strong>REFERENCIA: </strong></label>
                                                    <input type="text" class="form-control" name="referencia" value="<?php echo $referencia ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
                                                </div>

                                                <div class="col-12 text-center mt-1 p-1" style="border-bottom: 2px solid #ebebeb;">
                                                    <label><strong>DESCRIPCIÓN: </strong></label>
                                                    <textarea class="form-control" name="descripcion" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;"><?php echo $descripcion . ' - ' . $listarVehiculoID[0]['placa'] ?></textarea>
                                                </div>

                                                <div class="col-12 text-center mt-1 p-1" style="background: #fafafa;">
                                                    <label><strong>TOTAL A PAGAR: </strong></label>
                                                    <input type="text" class="form-control" name="valor" id="valor" value="<?php echo "COP $" . number_format($costo); ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
                                                    <cite>COP: Pesos Colombianos</cite>
                                                </div>
                                        </section>
                                    </div>

                                </section>
                            <!--FIN FORMS-->

                            <!-- ****************************-->

                            <!-- BOTON-->
                                <section class="main-boton row col-xs-12 col-sm-12 col-md-12 co-lg-12 d-flex justify-content-center mt-3 mb-3">
                                    <?php if($modulo =! 2){ ?>
                                        <div class="botones col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <button type="button"  id="boton_cancelar" class="btn btn-block" onclick="regresar();"><span style="font-size: 1.4rem;" class="fa fa-sign-out"></span><strong> Cancelar</strong></button>
                                        </div>
                                    <?php } ?>
                                    <div class="botones col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <button type="submit" id="boton_pago" class="btn btn-block"><strong>Continuar</strong> <img src="https://static.placetopay.com/placetopay-logo.svg" alt="Placetopay" width="105" height="27" style="margin-left: 5px;"></button>
                                    </div>
                                </section>
                            <!-- FIN BOTON-->

                    </section>
                </div>

            </form>
        </section>
    <!--FIN CONTENIDO -->

    <!-- ************************************** -->

    <!-- MODAL FAQ-->
        <div class="modal" id="ModalFaq" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
              
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>

                        <div class="row mt-3">
                            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-content-end">
                                <a id="sistemaKV" target="_blank" href="https://www.intranetgroupkv.com/"><img src="https://sistemakv.com/Resources/img/kingvision_transparente.png" alt="Logo_King_Vision" width="101" height="65" style="display: block; margin-top: 10px;"></a>
                            </section>
                            <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 d-flex justify-content-start">
                                <a id="Placetopay" target="_blank" href="https://www.placetopay.com/web/
                                "><img src="https://static.placetopay.com/placetopay-logo.svg" alt="Placetopay" width="158" height="55" style="display: block; margin-top: 10px; margin-left: 30px;">
                                </a>
                            </section>
                        </div>
                        
                        <h3 class="text-center text-uppercase mt-5" style="color: #4c81a8 !important;">
                            <strong>FAQ - </strong> <span class="text-muted" style="color: #1b2d3b !important;"><strong>Preguntas frecuentes</strong></span>
                        </h3>
                        
                        <div class="container p-4 mb-5 mt-4">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">     
                                        <span class="title">1. ¿Qué es Placetopay?</span>
                                        <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            Placetopay es la plataforma de pagos electrónicos que usa el SistemaKV para procesar en línea las transacciones generadas en la tienda virtual con las formas de pago habilitadas para tal fin.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">     
                                        <span class="title">2. ¿Es seguro ingresar mis datos bancarios en este sitio web? </span>
                                        <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            Para proteger tus datos el SistemaKV delega en Placetopay la captura de la información sensible. Nuestra plataforma de pagos cumple con los más altos estándares exigidos por la norma internacional PCI DSS de seguridad en transacciones con tarjeta de crédito. Además tiene certificado de seguridad SSL expedido por GeoTrust una compañía Verisign, el cual garantiza comunicaciones seguras mediante la encriptación de todos los datos hacia y desde el sitio; de esta manera te podrás sentir seguro a la hora de ingresar la información de su tarjeta.
                                            <br>
                                            Durante el proceso de pago, en el navegador se muestra el nombre de la organización autenticada, la autoridad que lo certifica y la barra de dirección cambia a color verde. Estas características son visibles de inmediato y dan garantía y confianza para completar la transacción en Placetopay.
                                            <br>
                                            Placetopay también cuenta con el monitoreo constante de McAfee Secure y la firma de mensajes electrónicos con Certicámara.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false">
                                        <span class="title">3. ¿Puedo realizar una transacción cualquier día y a cualquier hora?</span>
                                        <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            Sí, en el SistemaKV podrás realizar tus compras en línea los 7 días de la semana, las 24 horas del día a sólo un clic de distancia. 
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false">
                                        <span class="title">4. ¿Pagar electrónicamente tiene algún valor para mí como comprador? </span>
                                        <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                    </div>
                                    <div id="collapseFour" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            No, los pagos electrónicos realizados a través de Placetopay no generan costos adicionales para el comprador. 
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false">
                                        <span class="title">5. ¿Qué debo hacer si mi transacción no concluyó? </span>
                                        <span class="accicon"><i class="fa fa-angle-down rotate-icon"></i></span>
                                    </div>
                                    <div id="collapseFive" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            En primera instancia, revisar si llegó un email de confirmación de la transacción a la cuenta de correo electrónico inscrita en el momento de realizar el pago, en caso de no haberlo recibido, deberás contactar con desarrollo@ortsas.com para confirmar el estado de la transacción.  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
              
                </div>
            </div>
        </div>
    <!-- FIN MODAL FAQ-->


    

    

    <!-- script -->
        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">

            $('#num_celular_buyer').keypress(function (tecla) {
                if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });

            $('#num_documento_buyer').keypress(function (tecla) {
                if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });

            function sololetras(e) {

                key = e.keyCode || e.which;
                teclado=String.fromCharCode(key).toLowerCase();
                letras="qwertyuiopasdfghjklñzxcvbnmáéíóú ";
                especiales="8-37-38-46-164";
                teclado_especial=false;

                for(var i in especiales){
                    if(key==especiales[i]){
                        teclado_especial=true;
                        break;
                    }
                }

                if(letras.indexOf(teclado)==-1 && !teclado_especial){
                    return false;
                }

            }

            function validateEmail(email) {
              var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              return re.test(email);
            }

            function validate(email) {

                if (validateEmail(email)) {
                    alertify.success('Formato Correcto');
                } else {
                    alertify.error('Formato incorrecto de Correo Electrónico');
                }
                  return false;
            }

            function validarForm(){
                if (($('#nombres_buyer').val() == '') || ($('#apellidos_buyer').val() == '') || ($('#email_buyer').val() == '') || ($('#tipo_documento_buyer').val() == '') || ($('#num_documento_buyer').val() == '') || ($('#num_celular_buyer').val() == '')) {

                    alertify.error('Faltan diligenciar campos obligatorios en el formulario.');
                    return false;
                }

            }


            function modalAviso(){
                $("#ModalFaq").modal("show");   
            }

            $(window).on("load", modalAviso());

            function regresar(){
                window.history.back();
            }
        </script>
    <!-- script-->


</body>
</html>