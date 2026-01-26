<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Tipo Combustible';
$redireccion = 'tipo_combustible.php';
$icono = 'fa fa-thermometer-full';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Tipo Combustible</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
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
                    <li class="breadcrumb-item " aria-current="page"><a href="tipo_combustible.php">Tipos Combustible</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registrar Tipo Combustible</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-map mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR TIPO COMBUSTIBLE</b></strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
        	        <form action="../Controlador/registrarTipoCombustible.php" method="POST">

                        <!--NOMBRE CIUDAD-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Detalle</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="nombre_tipo" id="nombre_tipo" class="form-control" required="required">
                                </div>
                            </div>

                        <!-- BOTONES -->
                    
                            <section class="col-12 mt-5 d-flex justify-content-center">
                          
                                <!-- CANCELAR REGISTRO -->
                                    <a href="tipo_combustible.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                                <!-- REGISTRAR -->
                                    <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                      
                            </section>

        	        </form>
                </div>
            </section>

        </section>

    <!-- FIN CONTENIDO -->

    <!--**************************--->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->

</body>
</html>