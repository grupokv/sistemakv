<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Imprimir Vales';
$redireccion = 'vales_generados.php';
$icono = 'fa fa-pencil-square-o';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Imprimir Vales</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="vales_generados.php">vales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Imprimir Vales</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/imprimirVales.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>
                    <!--NOMBRE AREA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Empresa</label>
                            </div>
                            <div class="input">
                                <select name="empresa" id="empresa" required="required" class="form-control">
                                    <option value="">Seleccione Opcion</option>
                                    <option value="ORT">ORT</option>
									<option value="LP">Lineas Premium</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Cantidad</label>
                            </div>
                            <div class="input">
                                <input type="number" name="cantidad" id="cantidad" class="form-control" required="required">
                            </div>
                        </div>
                        
                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>