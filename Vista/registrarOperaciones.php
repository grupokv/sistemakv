<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operacion.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Operación';
$redireccion = 'operaciones.php';
$icono = 'fa fa-briefcase';

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Operación</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("../Vista/Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("../Vista/Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="../Vista/inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="operaciones.php">Operaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Operación</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/registrarOperacion.php" method="POST">
			    <?php include("../Vista/Template/header-form.php"); ?> 
					<!--NOMBRE OPERACIÓN-->
						<div class="row mt-3">
							<div class="label">
								<label>Nombre Operación</label>
							</div>
							<div class="input">
							    <input type="text" name="nombre_operacion" id="nombre_operacion" class="form-control">
							</div>
					    </div>
					<!--DESCRIPCION-->
					    <div class="row mt-3 mb-3">
							<div class="label">
								<label>Descripción</label>
							</div>
							<div class="input">
							    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
							</div>
					    </div>
					        
				<?php include("../Vista/Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("../Vista/Template/scripts.php"); ?>
</body>
</html>

