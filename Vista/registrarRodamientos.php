<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");

$cliente = new Cliente();

/* VARIABLES MENU*/
$titulo = 'Registrar Rodamientos';
$redireccion = 'perfiles.php';
$icono = 'fa fa-gears';

$listarClientes = $cliente->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Rodamientos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="perfiles.php">Rodamientos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Rodamientos</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarRodamientosCartera.php" method="POST">
                <?php include("Template/header-form.php"); ?> 
                
                    
                        
                    <!--TIPO DOCUMENTO-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Empresa</label>
                            </div>
                            <div class="input">
                                <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="1">ORGANIZACIÓN ORT SAS</option>
                                    <option value="2">LINEAS PREMIUM</option>
                                </select>
                            </div>
                        </div>
                    
                    <!--TIPO DOCUMENTO-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Tipo de Documento</label>
                            </div>
                            <div class="input">
                                <select name="tipo_identificacion" id="tipo_identificacion" class="form-control selectpicker" data-live-search="true">
                                    <option value="0">SELECCIONAR</option>
                                    <option value="CC">CEDULA DE CIUDADANIA - CC</option>
                                    <option value="NIT">NIT</option>
                                </select>
                            </div>
                        </div>
                        
	        	    <!--CLIENTE-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Nombre del Cliente</label>
                            </div>
                            <div class="input">
                                <input name="nombre_cliente" id="nombre_cliente" class="form-control" />
                            </div>
                        </div>
                        
                    <!--NUMERO DOCUMENTO-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Numero de Documento</label>
                            </div>
                            <div class="input">
                                <input name="num_identificacion" id="num_identificacion" class="form-control" />
                            </div>
                        </div>
                        
                    <!-- VALOR TOTAL-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Valor Total</label>
                            </div>
                            <div class="input">
                                <input name="valor_total" id="valor_total" class="form-control" />
                            </div>
                        </div>
                        
                    <!-- POR VENCER -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Por Vencer</label>
                            </div>
                            <div class="input">
                                <input name="por_vencer" id="por_vencer" class="form-control" />
                            </div>
                        </div>
                        
                    <!--DIAS MORA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>1 a 30</label>
                            </div>
                            <div class="input">
                                <input name="dias_mora_1_30" id="dias_mora_1_30" class="form-control" />
                            </div>
                        </div>
                        
                    <!--DIAS MORA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>31 a 60</label>
                            </div>
                            <div class="input">
                                <input name="dias_mora_31_60" id="dias_mora_31_60" class="form-control" />
                            </div>
                        </div>
                        
                    <!--DIAS MORA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>61 a 90</label>
                            </div>
                            <div class="input">
                                <input name="dias_mora_61_90" id="dias_mora_61_90" class="form-control" />
                            </div>
                        </div>
                    
                    <!-- VALOR MORA -->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Mayor a 90</label>
                            </div>
                            <div class="input">
                                <input name="dias_mora_mayor_90" id="dias_mora_mayor_90" class="form-control" />
                            </div>
                        </div>
                        
                        
                <?php include("Template/bottom-form.php"); ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    
    
    
</body>
</html>