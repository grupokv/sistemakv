<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Vehiculo.php");

$id_vehiculo = $_POST['id_vehiculo'];
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
  
    <!-- STYLES-->

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

            <form action="../Controlador/redireccionPago.php" method="POST" onsubmit="return validarForm()" class="mb-4">
                <div class="col-12 main d-flex justify-content-center" style="background-color: #fff;">
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
                                <h5 style="color: #1b2d3b;"><strong>CONFIRMACIÓN DE PAGO</strong></h5>
                                <section class="row d-flex justify-content-center">
                                    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-3 col-lg-3" style="background: #f9b434; width: 100%; height: 3px;"></div>
                                    <div id="barraInferiorTitulo" class="col-xs-6 col-sm-6 col-md-3 col-lg-3" style="background: #4c81a8; width: 100%; height: 3px;"></div>
                                </section>
                            </div>
                        <!-- FIN HEADER-->

                        <!-- ****************************-->
                            <section id="contConfirmacion" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center p-2" style="background-color: fff;">
                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mb-3" style="height: auto; border-top: 8px solid #f7f7f7; border-bottom: 8px solid #f0f0f0; color: #1b2d3b;">
                                        
                                        <p class="mt-3"><strong>RESUMEN DE LA TRANSACCIÓN</strong></p>
                                        
                                        <cite class="mb-2" style="font-size: .9rem;"><?php echo date('Y-m-d'); ?></cite>
                                    </div>

                                    <div id="contGeneral" class="col-12 mt-1 d-flex justify-content-center" style="height: auto; border-bottom: 8px solid #f0f0f0;">
                                        
                                        <input type="hidden" class="form-control" id="registroID" name="registroID" value="<?php echo $registroID; ?>">

                                        <input type="hidden" class="form-control" id="modulo" name="modulo" value="<?php echo $modulo; ?>">

                                        <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 p-1 mt-2 mb-2 mr-2" style="border: 2px solid #f0f0f0;">

                                            <div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                <label class="mt-2" for=""><strong>NOMBRES: </strong></label>
                                                <input type="text" class="form-control mb-2" name="nombres_buyer" value="<?php echo strtoupper($_POST['nombres_buyer']); ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-1 p-1">
                                                <label class="mt-2" for=""><strong>APELLIDOS: </strong></label>
                                                <input type="text" class="form-control" name="apellidos_buyer" value="<?php echo strtoupper($_POST['apellidos_buyer']); ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-1 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                <label class="mt-2" for=""><strong>TIPO DE DOCUMENTO: </strong></label>
                                                <input type="text" class="form-control mb-2" name="tipo_documento_buyer" value="<?php echo strtoupper($_POST['tipo_documento_buyer']); ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-1 p-1">
                                                <label class="mt-2" for=""><strong>NÚMERO DE DOCUMENTO: </strong></label>
                                                <input type="text" class="form-control" name="num_documento_buyer" value="<?php echo $_POST['num_documento_buyer']; ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-1 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                <label class="mt-2" for=""><strong>NÚMERO DE TÉLEFONO: </strong></label>
                                                <input type="text" class="form-control mb-2" name="num_celular_buyer" value="<?php echo $_POST['num_celular_buyer']; ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-1 p-1">
                                                <label class="mt-2" for=""><strong>CORREO ELÉCTRONICO: </strong></label>
                                                <input type="text" class="form-control" name="email_buyer" value="<?php echo $_POST['email_buyer']; ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center;  font-size: .9rem;">
                                            </div>

                                        </section>

                                        <section class="col-xs-12 col-sm-12 col-md-6 col-lg-6 p-1 mt-2 mb-2" style="border: 2px solid #f0f0f0;" >

                                            <div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                <label for=""><strong>DESCRIPCIÓN: </strong></label>
                                                <textarea class="form-control mb-2" name="descripcion" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;"><?php echo $_POST['descripcion']; ?></textarea>
                                            </div>

                                            <div class="col-12 text-center mt-4 p-1">
                                                <label for=""><strong>REFERENCIA: </strong></label>
                                                <input type="text" class="form-control" name="referencia" value="<?php echo $_POST['referencia']; ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
                                            </div>

                                            <div class="col-12 text-center mt-4 p-1" style="background: #fafafa; border-bottom: 2px solid #ebebeb;">
                                                <label for=""><strong>VALOR TOTAL: </strong></label>
                                                <input type="text" class="form-control mb-2" name="valor" id="valor" value="<?php echo $_POST['valor']; ?>" readonly style="border-style: dashed; background: #ffffff; text-align: center; font-size: .9rem;">
                                                <cite>COP: Pesos Colombianos</cite>
                                            </div>

                                        </section>
                                    </div>

                                    <section class="d-flex justify-content-center">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="" id="acepto_terminos_condiciones">
                                            <label class="form-check-label" for="acepto_terminos_condiciones">He leído y acepto los <a href="../Resources/Documentos/TERMINOS Y CONDICIONES.pdf" target="_blank"><strong>Términos y Condiciones.</strong></a></label>
                                        </div>
                                    </section>
                                    
                                </div>
                            </section>
                        <!-- ****************************-->

                        <!-- BOTON-->
                            <section class="main-boton row col-xs-12 col-sm-12 col-md-12 co-lg-12 d-flex justify-content-center mt-3 mb-3">
                                <div class="botones col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <button type="button"  id="boton_cancelar" class="btn btn-block" onclick="regresar();"><span style="font-size: 1.4rem;" class="fa fa-sign-out"></span><strong> Cancelar</strong></button>
                                </div>
                                <div class="botones col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <button type="submit" id="boton_pago" class="btn btn-block"><strong>Confirmar</strong> <img src="https://static.placetopay.com/placetopay-logo.svg" alt="Placetopay" width="105" height="27" style="margin-left: 5px;"></button>
                                </div>
                            </section>
                        <!-- FIN BOTON-->

                    </section>
                </div>

            </form>

        </section>

    <!-- FIN CONTENIDO -->

    <!-- ************************************** -->

    <!-- SCRIPT -->

        <?php include("Template/scripts.php"); ?>

        <script type="text/javascript">

            function validarForm(){
                if(document.getElementById('acepto_terminos_condiciones').checked == false){
                    alertify.error('Se requiere aceptar los Términos y Condiciones para continuar.');
                    return false;
                }

            }


            function regresar(){
                window.history.back();
            }
        </script>

    <!-- FIN SCRIPT -->


</body>
</html>