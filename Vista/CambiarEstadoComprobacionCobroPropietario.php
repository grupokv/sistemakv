<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Actas.php");
require_once ("../Modelo/Usuario.php");

$acta = new Acta();
$listarActa = $acta->listarActas();

$id_comprobante = $_GET['id_comprobante'];

$usuario = new Usuario();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Estado Comprobante Cobros</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        
  
        <style type="text/css" media="screen">
        	@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@300&display=swap');

        	body{    	
        		font-family: 'Rajdhani', sans-serif;
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
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Confirmación Comprobante Pago</li>
                 </ol>
            </div>

            <div class="col-12 p-4" style="background-color: #fff; width: 100%; height: auto;">

                <section class="row" style="margin-top: 20px;">
                    <div class="col-3" style="width: auto; height: 5px; background-color: #fff; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #335689; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #f7a60f; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #335689; "></div>
                    <div class="col-4" style="width: auto; height: 5px; background-color: #fff; "></div>
                </section>

                <form method="POST" action="../Controlador/cambiarEstadoComprobanteCobro.php">
                
                    <div style="display: flex; justify-content: center;">
                        <div class="row" style="background-color: #fff; width: 50%; height: 80px; border-radius: 2px; ">
                            <section class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
                                    <img src="../Resources/images/logoKV.png" style="margin-top: 15px; width: 100px; height: 60px;">
                            </section>
                        </div>
                    </div>
                
                    <div style="display: flex; justify-content: center;">
                        <div class="row d-flex justify-content-center" style="width: 50%; height: auto; border-radius: 2px;">
                            
                            <?php 
                            $estadoBoton = $_GET['estadoBoton'];
                            
                            if($estadoBoton == "R"){?>
                                <h5 class="mt-4 mb-2"><strong>¿Está de acuerdo en rechazar el comprobante de pago?</strong></h5>
                                
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 text-center">
                                    <label>Novedad de Rechazo</label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <textarea class="form-control" name="novedad_rechazo" id="novedad_rechazo" require="require"></textarea>
                                    <input type="hidden" class="form-control" name="estado" id="estado" value="<?php echo $estadoBoton; ?>"/>
                                    <input type="hidden" class="form-control" name="id_comprobante" id="id_comprobante" value="<?php echo $id_comprobante; ?>"/>
                                </div>
                                  
                                
                            <?php } else if($estadoBoton == "A"){ ?>
                                <h5 class="mt-4"><strong>¿Esta de acuerdo en aprobar el comprobante de pago?</strong></h5>
                                <input type="hidden" class="form-control" name="estado" id="estado" value="<?php echo $estadoBoton; ?>"/>
                                <input type="hidden" class="form-control" name="id_comprobante" id="id_comprobante" value="<?php echo $id_comprobante; ?>"/>
                            <?php } ?>
                            
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: center;">
                        <?php if($estadoBoton == "R"){?>
                            <div class="col-xs-8 col-sm-8 col-md-3 col-lg-3">
                                <button type="submit" class="btn btn-outline-danger btn-block mt-5" id="rechazar" style="border-radius: 18px;">Rechazar</button>
                            </div>
                        <?php } else if($estadoBoton == "A"){ ?>    
                            <div class="col-xs-8 col-sm-8 col-md-3 col-lg-3">
                                <button type="submit" class="btn btn-outline-success btn-block mt-5" id="Aprobar" style="border-radius: 18px;">Aprobar</button>
                            </div>
                        <?php } ?>
                    </div>
                
                    <div style="display: flex; justify-content: center;" class="mt-4">
                        <div class="row" style="border-top: 4px solid #f7f7f7; width: 50%; height: 4px; border-radius: 2px;"></div>
                    </div>
                </form>

                <section class="row" style="margin-top: 10px;">
                    <div class="col-3" style="width: auto; height: 5px; background-color: #fff; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #335689; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #f7a60f; "></div>
                    <div class="col-2" style="width: auto; height: 5px; background-color: #335689; "></div>
                    <div class="col-4" style="width: auto; height: 5px; background-color: #fff; "></div>
                </section>

            </div>
    
        </section>

    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>


</body>
</html>