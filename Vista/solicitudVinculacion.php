<?php 
include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Solicitud de Vinculación';
$redireccion = 'inicio.php';
$icono = 'fa fa-user-o';


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Solicitud de Vinculación</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Solicitud de Vinculación</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarSolicitudVinculacion.php" method="POST">
                <?php include("Template/header-form.php"); ?> 
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                        <p>Información Personal</p>
                    </div>
                    
                    <div class="mb-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #fafafa">
                        
    	        	    <!--NOMBRE Y APELLIDOS-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Nombres y Apellidos</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="nombres_apellidos" id="nombres_apellidos" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Numero de Documento</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="num_documento" id="num_documento" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Telefono</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Correo Electronico</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="correo_electronico" id="correo_electronico" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Ciudad de Residencia</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="ciudad_residencia" id="ciudad_residencia" class="form-control">
                                </div>
                            </div>
                        
                    
                    </div>
                        
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  text-center" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                        <p>Información del Vehiculo</p>
                    </div>
                        
                        
                    <div style="border-radius: 3px; border: 1px solid #ddd; background-color: #fafafa">
                        
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Placa</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="placa" id="placa" class="form-control">
                                </div>
                            </div>
                        
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Tipo de Vehiculo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" class="form-control">
                                </div>
                            </div>
                        
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Marca y Linea</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="marca_linea" id="marca_linea" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Modelo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="modelo" id="modelo" class="form-control">
                                </div>
                            </div>
                            
    	        	    <!-- NUM DOCUMENTO-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>motivo</label>
                                </div>
                                <div class="input">
                                    <select name="motivo" id="motivo" class="form-control">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="TRASLADO">Traslado de Empresa</option>
                                        <option value="NUEVO">Vehiculo Nuevo</option>
                                    </select>
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