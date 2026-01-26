<?php 

include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Pais';
$redireccion = 'paises.php';
$icono = 'fa fa-map';

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Pais</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="paises.php">Paises</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Pais</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarPais.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>
                    <!--NOMBRE AREA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Nombre pais</label>
                            </div>
                            <div class="input">
                                <input type="text" name="nombre_pais" id="nombre_pais" class="form-control" required="required">
                            </div>
                        </div>
                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>