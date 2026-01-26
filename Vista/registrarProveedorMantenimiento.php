<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Proveedor';
$redireccion = 'proveedores_mantenimiento.php';
$icono = 'fa fa-building-o';
$id = '';
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Proveedor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="proveedores_mantenimiento.php">Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar proveedor</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarProv.php" method="POST" enctype="multipart/form-data">
                <?php include("Template/header-form.php"); ?>   
                    <div id="tabs">
	                    
	                    <!-- EMPRESA -->
		                    <div id="tabs-1">

						        <!--NOMBRE EMPRESA-->
							        <div class="row mt-3 ">
							        	<div class="label">
								            <label>Razón Social</label>
							        	</div>
							        	<div class="input">
							        		<input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control">
							        	</div>
							        </div>
							        
						        <!--NIT-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Nit</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="nit_empresa" id="nit_empresa" class="form-control" >
							            </div>
							        </div>

						        <!--DIRECCION-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Direccion</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="direccion" id="direccion" class="form-control" >
							            </div>
							        </div>

						        <!--TELEFONO-->
							        <div class="row mt-3 ">
							        	<div class="label">
							                <label>Telefono</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="telefono" id="telefono" class="form-control" >
							            </div>
							        </div>

							    <!--LOGO-->
							        <div class="row mt-3 mb-4 ">
							        	<div class="label">
							                <label>Correo Electronico</label>
							            </div>
							        	<div class="input">
							                <input type="text" name="email_empresa" id="email_empresa" class="form-control">
							            </div>
							        </div>

							    
						    </div>
				    </div>
                <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>


</body>
</html>