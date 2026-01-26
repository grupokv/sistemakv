<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Propietario.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");

$tipoVehiculo = new TipoVehiculo();
$propietario = new Propietario();
$conductor = new Conductor();
$contrato = new Contrato();
$vehiculo = new Vehiculo();
$empresa = new Empresa();
$cliente = new Cliente();
$ciudad = new Ciudad();

$listarTV = $tipoVehiculo->listar();
$listarTipoMoviles = $vehiculo->listarTipoMoviles();
$listarConductores = $conductor->listar();
$listarPropietarios = $propietario->listarPropietarios();
$ciudades = $ciudad->listar();

$hoy = date('Y-m-d');
$listarC = $contrato->listarContratosHabiles($hoy);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Vehiculo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #5e99b1 !important;
            border: #fff;
        }

        label{
            font-size: .9rem;
        }

        select{

        }

        th, td {
            padding: .5px !important;
            border: 0px !important;
        }

        table{
            border-collapse: separate;
            border-spacing: 0px 10px;
        }


        #inventory table {
            font-size: .8rem;
        }

        #inventory thead {
            background-color: #fff;
        }

        #inventory tr {
            background-color: #fff;
        }

        #inventory th {
            border-radius: 15px;
            border: 3px solid #fff !important;
            background-color: #274054;
            color: #fff;
        }


    </style>

</head>
<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>



    <section class="home_content">  
    	<div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="vehiculos.php">Vehículos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar Vehículo</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>REGISTRO VEHÍCULO</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-4">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
    	        <form action="../Controlador/registrarVehi.php" method="POST" enctype="multipart/form-data">
    	        	<div id="tabs">
                        <ul>
                          <li><a href="#tabs-1">Información </a></li>
                          <li><a href="#tabs-2">Licencia </a></li>
                          <li><a href="#tabs-3">Documentos</a></li>
                          <li><a href="#tabs-4">Propietarios - Tenedores - Conductores</a></li>
                          <li><a href="#tabs-5">Contrato</a></li>
                          <li><a href="#tabs-6">Fotografias</a></li>
                          <li><a href="#tabs-7">Relación de Inventario</a></li>
                        </ul>

                        <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-3">
                                
                                <!-- ESTADO -->
                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Estado<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control selectpicker form-control-sm" data-live-search="true" name="estado" id="estado" title="SELECCIONAR">
                                                <option value="1">ACTIVO</option>
                                                <option value="0">INACTIVO</option>
                                            </select>
                                        </div>      		
                                    </div>  

                                <!-- PLACA -->
                                    <div class="row  mt-3">
                                        <div class="label">
                                            <label>Placa<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" maxlength="6" name="placa" id="placa" class="form-control form-control-sm" required="required" />
                                        </div>      		
                                    </div>  

                                <!-- NUMERO MOVIL-->
                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Número Movil<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="movil" id="movil" class="form-control  form-control-sm" required="required" >
                                        </div>      		
                                    </div>

                                <!-- CLASE MOVIL -->
                                    <div class="row mt-3">
                                        <div class="label">
                                            <label>Tipo de Vehículo<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo" required="required" title="SELECCIONAR">
                                                <?php foreach ($listarTV as $ltv){ ?>
                                                    <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                        <?php echo $ltv['nombre_tipo_vehiculo'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div>

                                <!-- TIPO MOVIL -->
                                    <div class="row mt-3 ">
                                        <div class="label">
                                            <label>Tipo de Movil<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_servicio" id="id_tipo_servicio"  required="required" title="SELECCIONAR">
                                                <?php foreach ($listarTipoMoviles as $ltm){ ?>
                                                    <option value="<?php echo $ltm['id_tipo'] ?>">
                                                        <?php echo $ltm['tipo_movil'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div>

                                <!--  MARCA -->
                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Marca y Linea<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="marca" id="marca" class="form-control form-control-sm"  required="required" />
                                        </div>      		
                                    </div>

                                <!--  MODELO -->
                                    <div class="row  mt-3  ">
                                        <div class="label">
                                            <label>Modelo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" maxlength="4" name="modelo" id="modelo" class="form-control form-control-sm" required="required" >
                                        </div>      		
                                    </div>

                                <!-- COLOR -->
                                    <div class="row mt-3">
                                        <div class="label">
                                            <label>Color<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" maxlength="4" name="color" id="color" class="form-control form-control-sm" required="required" >
                                        </div>      		
                                    </div>
                                
                                <!-- NUMERO PUERTAS -->
                                    <div class="row  mt-3">
                                        <div class="label">
                                            <label>Numero de Puertas</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="num_puertas" id="num_puertas" class="form-control">
                                            
                                        </div>      		
                                    </div>
										
                                <!-- CILINDRAJE -->
                                    <div class="row  mt-3">
                                        <div class="label">
                                            <label>Cilindraje</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="cilindraje" id="cilindraje" class="form-control">
                                            
                                        </div>      		
                                    </div>
									
                                <!-- TIPO CARROCERIA -->	
                                    <div class="row  mt-3">
                                        <div class="label">
                                            <label>Tipo Carroceria</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="tipo_carroceria" id="tipo_carroceria" class="form-control">
                                            
                                        </div>      		
                                    </div>

                                <!-- TIPO COMBUSTIBLE -->
                                    <div class="row  mt-3">
                                        <div class="label">
                                            <label>Tipo Combustible</label>
                                        </div>
                                        <div class="input">
                                            <select name="tipo_combustible" id="tipo_combustible" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                                <option value="GASOLINA">GASOLINA</option>
                                                <option value="DIÉSEL">DIÉSEL (ACPM)</option>
                                                <option value="GAS">GAS</option>
                                            </select>
                                        </div>      		
                                    </div>

                            	<!-- CANT PASAJEROS-->
                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Capacidad de Pax<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="cant_pasajeros" id="cant_pasajeros" class="form-control form-control-sm" required="required">
                                        </div>              
                                    </div>
                                
                                <!-- TIPO DE AFILIACIÓN -->
                                    <div class="row  mt-3 ">
                                        <div class="label">
                                            <label>Tipo Afiliación<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                        </div>
                                        <div class="input">
                                            <select name="tipo_afiliacion" id="tipo_afiliacion" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                                <option value="TERCERO">EXTERNO (TERCERO)</option>
                                                <option value="AFILIADO">AFILIADO</option>
                                            </select>
                                        </div>              
                                    </div>

                                <!-- ALIADO -->
                                    <div class="row p-3 m-3" style="border: 1px dashed #d3d3d3; display:none;" id="contentAliado">
                                        <section class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                                <label>Aliado en</label>
                                                <select name="aliado" id="aliado" class="form-control form-control-sm selectpicker" data-live-search="true">
                                                    <option value="">SELECCIONAR</option>

                                                </select>
                                        </section>  
                                        <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <label>Número Convenio</label>
                                                <input type="text" name="id_convenio" id="id_convenio" class="form-control form-control-sm">
                                        </section>  
                                        <section class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                                <label>Vencimiento Convenio</label>
                                                <input type="text" name="fecha_vencimiento_convenio" id="fecha_vencimiento_convenio" class="form-control form-control-sm">
                                        </section>            
                                    </div>

                            </div>

                        <!-- LICENCIA -->
                            <div id="tabs-2" class="p-3">
                                
                                <!-- NUMERO TARJETA DE PROPIEDAD-->
                                    <div class="row mt-3 p-2">
                                        <div class="label">
                                            <label>Tarjeta de Propiedad No. <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="num_tarjeta_operacion" id="num_tarjeta_operacion" class="form-control form-control-sm" required="required" >
                                        </div>              
                                    </div>    

                                <!-- NUMERO MOTOR -->
                                    <div class="row mt-2 p-2">
                                        <div class="label">
                                            <label>Número Motor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="numero_motor" id="numero_motor" class="form-control form-control-sm" required="required">
                                        </div>              
                                    </div>

                                <!-- NUMERO CHASIS -->
                                    <div class="row mt-2 p-2">
                                        <div class="label">
                                            <label>Número Chasis <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="numero_chasis" id="numero_chasis" class="form-control form-control-sm" required="required">
                                        </div>              
                                    </div>
                                
                                <!-- NUMERO SERIE -->
                                    <div class="row mt-2 p-2">
                                        <div class="label">
                                            <label>Número Serie <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="numero_serie" id="numero_serie" class="form-control form-control-sm" required="required">
                                        </div>              
                                    </div>
                                
                                <!-- FECHA DE MATRICULA -->
                                    <div class="row mt-2 p-2">
                                        <div class="label">
                                            <label>Fecha de Matricula</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="fecha_registro" id="fecha_registro" class="form-control form-control-sm">
                                            
                                        </div>      		
                                    </div>
                                
                                <!-- ORGANISMO DE TRANSITO -->
                                    <div class="row mt-2 p-2">
                                        <div class="label">
                                            <label>Organismo de Transito</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" name="organismo_transito" id="organismo_transito" class="form-control form-control-sm">
                                            
                                        </div>      		
                                    </div>
									
                            </div>

                        <!-- DOCUMENTACIÓN -->
                            <div id="tabs-3" class="p-3">

                                <!--------  LICENCIA  -------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Licencia de Tránsito</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Documento Lic. Tránsito</label>
        		       			            <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control form-control-sm"  >     
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Expedición Lic. Tránsito</label>
        		       			            <input type="text" name="fecha_vencimiento_rp" id="fecha_vencimiento_rp" class="form-control form-control-sm">     
                                        </div>
        		                    </div>   

                                <!--  --------------------- -->

                                <!--- TARJETA DE OPERACION --->
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Tarjeta de Operación</p>
                                    </div>

                                    <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                            <label>Documento Tarj. Operación</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                            <input type="file" name="tarjeta_operacion"  id="tarjeta_operacion" class="form-control form-control-sm" >
                                        </div>        
                                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Expedición Tarj. Operación</label>
                                            <input type="text" name="fecha_expedicion_to" id="fecha_expedicion_to" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Número Tarj. Operación</label>
                                            <input type="text" name="numero_to" id="numero_to" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento Tarj. Operación</label>
                                            <input type="text" name="fecha_vencimiento_to" id="fecha_vencimiento_to" class="form-control form-control-sm">
                                        </div>           
                                    </div>

                                    
                                <!--  --------------------- -->


                                <!-------  PREVENTIVA -------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Revisión Preventiva</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Documento Rev. Preventiva</label>
        		       			            <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control form-control-sm"  >     
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Vencimiento Rev. Preventiva</label>
        		       			            <input type="text" name="fecha_vencimiento_rp" id="fecha_vencimiento_rp" class="form-control form-control-sm">     
                                        </div>
        		                    </div>   

                                <!--  --------------------- -->


                                <!------- TECNOMECANICA ------>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Revisión Tecnomecanica</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Documento Rev. Tecnomecanica</label>
                                            <input type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control form-control-sm">    
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Número Tecnomecanica</label>
        		       			            <input type="text" name="numero_rt" id="numero_rt" class="form-control form-control-sm">     
                                        </div>
        		                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Expedición Rev. Tecnomecanica</label>
                                            <input type="text" name="fecha_expedicion_rt" id="fecha_expedicion_rt" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>CDA Rev. Tecnomecanica</label>
                                            <input type="text" name="cda_rt" id="cda_rt" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento Rev. Tecnomecanica</label>
                                            <input type="text" name="fecha_vencimiento_lt" id="fecha_vencimiento_lt" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->

                                <!----------- SOAT ----------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>SOAT</p>
                                    </div>

                                    <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                            <label>Documento SOAT</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                            <input type="file" name="documento_soat"  id="documento_soat" class="form-control form-control-sm" >
                                        </div>        
                                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Número SOAT</label>
                                            <input type="text" name="numero_soat" id="numero_soat" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Aseguradora SOAT</label>
                                            <input type="text" name="aseguradora_soat" id="aseguradora_soat" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento SOAT</label>
                                            <input type="text" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->


                                <!-------- RCE Y RCC --------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Póliza de RCC</p>
                                    </div>

                                    <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                            <label>Documento Póliza de RCC</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                            <input type="file" name="poliza_contra"  id="poliza_contra" class="form-control form-control-sm" >
                                        </div>        
                                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Número Póliza de RCC</label>
                                            <input type="text" name="numero_contra" id="numero_contra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Aseguradora Póliza de RCC</label>
                                            <input type="text" name="aseguradora_contra" id="aseguradora_contra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento Póliza de RCC</label>
                                            <input type="text" name="fecha_vencimiento_contra" id="fecha_vencimiento_contra" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->
                                           
                                
                                <!-------- RCE Y RCC --------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Póliza de RCE</p>
                                    </div>

                                    <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                            <label>Documento Póliza de RCE</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                            <input type="file" name="poliza_extra"  id="poliza_extra" class="form-control form-control-sm" >
                                        </div>        
                                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Número Póliza de RCE</label>
                                            <input type="text" name="numero_extra" id="numero_extra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Aseguradora Póliza de RCE</label>
                                            <input type="text" name="aseguradora_extra" id="aseguradora_extra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento Póliza de RCE</label>
                                            <input type="text" name="fecha_vencimiento_extra" id="fecha_vencimiento_extra" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->

                                
                                <!------- TODO RIESGO -------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Seguro Todo Riesgo</p>
                                    </div>

                                    <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                            <label>Documento Todo Riesgo</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                            <input type="file" name="seguro_todo_riesgo" id="seguro_todo_riesgo" class="form-control form-control-sm" >
                                        </div>        
                                    </div>  

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Número Todo Riesgo</label>
                                            <input type="text" name="numero_tr" id="numero_tr" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <label>Aseguradora Todo Riesgo</label>
                                            <input type="text" name="aseguradora_tr" id="aseguradora_tr" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                            <label>Vencimiento Todo Riesgo</label>
                                            <input type="text" name="fecha_vencimiento_tr" id="fecha_vencimiento_tr" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->

                            </div>
                        
                        <!-- PROPIETARIO * TENEDOR * CONDUCTORES -->
                            <div id="tabs-4" class="p-3">
                                
                                <!--------  PROPIETARIOS  -------->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Propietario(s)</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Cantidad de Propietario(s)</label>
        		       			            <select name="cant_propietarios" id="cant_propietarios" class="form-control form-control-sm selectpicker" data-live-search="true" onchange="validarCamposAdicionales(this.value, 'prop');">
                                                <option value="">SELECCIONAR</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 table-responsive" id="contProp">
                                            
                                        </div>
        		                    </div>  
                                <!-------------------------------->
                                    
                                <!----------  TENEDORES  --------->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Tenedor(es)</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Cantidad de Tenedor(es)</label>
        		       			            <select name="cant_tenedores" id="cant_tenedores" class="col-12 form-control form-control-sm selectpicker" data-live-search="true" onchange="validarCamposAdicionales(this.value, 'tene');">
                                                <option value="">SELECCIONAR</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 table-responsive" id="contTene">
                                            
                                        </div>
        		                    </div>   
                                <!-------------------------------->

                                <!---------- CONDUCTORES  -------->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Conductor(es)</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Cantidad de Conductor(es)</label>
        		       			            <select name="cant_conductores" id="cant_conductores" class="col-12 form-control form-control-sm selectpicker" data-live-search="true" onchange="validarCamposAdicionales(this.value, 'cond');">
                                                <option value="">SELECCIONAR</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 table-responsive" id="contCond">
                                            
                                        </div>
        		                    </div>  
                                <!-------------------------------->

                            </div>

                        <!-- CONTRATO -->
                            <div id="tabs-5" class="p-3">

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-2">
                                            <label>Doc. Contrato de Transporte / Vinculación</label>
        		       			            <input type="file" name="revision_preventiva" id="revision_preventiva" class="form-control form-control-sm">     
                                        </div>
        		                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                            <label>Contrato (Base)</label>
        		       			            <select name="id_contrato_base" id="id_contrato_base" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                                <?php foreach ($listarC as $lc){ ?>
                                                    <option value="<?php echo $lc['id_contrato']; ?>">
                                                        <?php
                                                        $emp = $empresa->listarPorId($lc['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lc['id_cliente']);
                                                        echo "CONTRATO No. ".$lc['id_contrato']. " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; ?>
                                                    </option>           
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                            <label>Contrato/s (Apoyo)</label>
                                            <select name="id_contrato_apoyo[]" id="id_contrato_apoyo" class="form-control form-control-sm" multiple data-live-search="true" title="SELECCIONAR">
                                                <?php foreach ($listarC as $lc){ ?>
                                                    <option value="<?php echo $lc['id_contrato']; ?>">
                                                        <?php
                                                        $emp = $empresa->listarPorId($lc['id_empresa']);
                                                        $cli = $cliente->listarClientePorId($lc['id_cliente']);
                                                        echo "No. interno ".$lc['id_contrato']." - CONTRATO N° " . $lc['numero_contrato'] . " Entre " . $cli[0]['razon_social'] . " y " . $emp[0]['nombre_empresa']; ?>
                                                    </option>           
                                                <?php } ?>
                                            </select>
                                        </div>
        		                    </div>
                                    
                            </div>

                        <!-- FOTOGRAFIAS -->
                            <div id="tabs-6" class="p-3">

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3;">
                                    <label>Foto Delantera</label>
                                    <input type="file" name="fotografia_frontal" id="fotografia_frontal" class="form-control form-control-sm" >       
                                </div>

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3;">
                                    <label>Foto Trasera</label>
                                    <input type="file" name="fotografia_trasera" id="fotografia_trasera" class="form-control form-control-sm" >       
                                </div>

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3;">
                                    <label>Foto Lateral Izquierda</label>
                                    <input type="file" name="fotografia_lateral_izq" id="fotografia_lateral_izq" class="form-control form-control-sm" >       
                                </div>

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3;">
                                    <label>Foto Lateral Derecha</label>
                                    <input type="file" name="fotografia_lateral_der" id="fotografia_lateral_der" class="form-control form-control-sm" >       
                                </div>

                            </div>
                            
                        <!-- FOTOGRAFIAS -->
                            <div id="tabs-7" class="p-3">
                                                    
                                <section class="d-flex justify-content-center mt-2 mb-2">
                                    <div  id="botones" class="row m-3">
                                        <button class="btn btn-outline-danger mr-3" onclick="eliminarFilaInventario();" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Eliminar fila <i class="fa fa-trash ml-2" style="font-size: 1.2rem;"></i></button>
                                        <button class=" btn btn-outline-success" onclick="agregarFilaInventario();" type="button" style="margin: 0px; padding: 5px 6px 5px 6px;"> Agregar Fila <i class="fa fa-plus-circle ml-2" style="font-size: 1.2rem;"></i></button>
                                    </div>
                                </section>

                                <hr>

                                <table id="inventory" class="table table-hover table-sm display text-center" style="width:100%">
                                    <thead style="background-color: #1b2d3b; color: #fff;">
                                        <tr>
                                            <th style="vertical-align: top;"></th>
                                            <th style="vertical-align: top;" width="150px;">FECHA</th>
                                            <th style="vertical-align: top;" width="300px;">DOC INVENTARIO</th>
                                            <th style="vertical-align: top;">COND. QUE ENTREGA</th>
                                            <th style="vertical-align: top;">COND. QUE RECIBE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contentInventory">

                                    </tbody>
                                </table>

                            </div>

                    </div>

                    <!-- BOTONES -->
                        <section class="col-12 mt-3 d-flex justify-content-center">
                            <!-- CANCELAR REGISTRO -->
                                <a href="extractosFijosPropietarios.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                          
                            <!-- REGISTRAR -->
                                <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
            
                        </section>

    	        </form>
            <!--FIN FORMULARIO-->


            </div>
        </section>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

        $(function() {
            $("#tabs").tabs();
        }); 

        $( function(){
            $("#id_contrato_apoyo").chosen(); 
        });


        $(function() {
            $("#fecha_vencimiento_convenio").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_registro").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_expedicion_to").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_to").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_rp").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_expedicion_rt").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_rt").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_soat").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_contra").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_extra").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_vencimiento_tr").datepicker({dateFormat:'yy-mm-dd'});
            $(".fecha_inventario").datepicker({dateFormat:'yy-mm-dd'});
        });

        $('#tipo_afiliacion').on('change', function(){
            if(this.value == 'EXTERNO'){
                $('#contentAliado').css({
                    'display' : 'flex',
                });
            }else{
                $('#contentAliado').css('display', 'none');
            }
        })

        function validarCamposAdicionales(cant, tipo){
            var parametros = {
                "cant" : cant,
                "tipo": tipo 
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/cargarCamposVehiculos.php',
                type:  'POST',
                beforeSend: function () {},
                success:  function (response) {
                    //alert(response);
                    $("#cont" + capitalize(tipo)).html(response);
                    $(".propietario").selectpicker('refresh');
                    $(".tenedor").selectpicker('refresh');
                    $(".conductor").selectpicker('refresh');
                }
            });
        }


        function agregarFila(tipo) {
            let nFilas = $("#table" + capitalize(tipo) + " tr").length;
           
            if(tipo == 'prop'){
                let htmlTags = '<tr><td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td><td>Propietario '+(nFilas+1)+'</td><td><select name="propietario[]" id="propietario'+(nFilas+1)+'" class="form-control form-control-sm propietario" data-container="body" data-live-search="true"><option value="">SELECCIONAR</option><?php foreach($listarPropietarios as $lp){ ?><option value="<?php echo $lp['id_propietario']; ?>"><?php echo $lp['nombre'] . ' - ' . $lp['numero_documento']; ?></option><?php } ?></select></td></tr>';
                
                if((nFilas+1) <= 5){
                    $('#table'+ capitalize(tipo)).append(htmlTags);
                    $(".propietario").selectpicker('refresh');
                }else{
                    alertify.error("Has llegado al limite de agregar campos");
                }   

            }else if(tipo == 'tene'){
                let htmlTags = '<tr><td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td><td>Tenedor '+(nFilas+1)+'</td><td><select name="tenedor[]" id="tenedor'+(nFilas+1)+'" class="form-control form-control-sm tenedor" data-container="body" data-live-search="true"><option value="">SELECCIONAR</option><?php foreach($listarPropietarios as $lp){ ?><option value="<?php echo $lp['id_propietario']; ?>"><?php echo $lp['nombre'] . ' - ' . $lp['numero_documento']; ?></option><?php } ?></select></td></tr>';
                
                if((nFilas+1) <= 5){
                    $('#table'+ capitalize(tipo)).append(htmlTags);
                    $(".tenedor").selectpicker('refresh');
                }else{
                    alertify.error("Has llegado al limite de agregar campos");
                }   
            }else if(tipo == 'cond'){
                let htmlTags = '<tr><td><i class="fa fa-user-circle" style="color:#1b2d3b;"></i></td><td>Conductor '+(nFilas+1)+'</td><td><select name="conductor[]" id="conductor'+(nFilas+1)+'" class="form-control form-control-sm conductor" data-container="body" data-live-search="true"><option value="">SELECCIONAR</option><?php foreach($listarConductores as $lc){ ?><option value="<?php echo $lc['id_conductor']; ?>"><?php echo $lc['nombre_conductor'] . ' - ' . $lc['numero_documento']; ?></option><?php } ?></select></td></tr>';
                
                if((nFilas+1) <= 4){
                    $('#table'+ capitalize(tipo)).append(htmlTags);
                    $(".conductor").selectpicker('refresh');
                }else{
                    alertify.error("Has llegado al limite de agregar campos");
                }   
            }
            
        }

        function agregarFilaInventario() {
            let nFilas = $("#inventory tr").length;
            alert(nFilas);

            let parametros = {
                "cant" : nFilas,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/cargarCamposInventarioVehiculos.php',
                type:  'POST',
                beforeSend: function () {},
                success:  function (response) {
                    if(nFilas <= 25){
                        $('#contentInventory').append(response);
                        $(".conductor_entrega").selectpicker('refresh');
                        $(".conductor_recibo").selectpicker('refresh');
                    }else{
                        alertify.error("Has llegado al limite para agregar campos");
                    }
                }
            });
               
        }

        function eliminarFila(tipo) {
            var nFilas = $("#table" + capitalize(tipo) + " tr").length;
            var celdaAnterior = parseFloat(nFilas) - parseFloat(1);
            if(nFilas > 1){
                $("#table" + capitalize(tipo) + " tr:last").remove();
            }
        }

        function capitalize(word) {
            return word[0].toUpperCase() + word.slice(1);
        }

    </script>
    
</body>
</html>