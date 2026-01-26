<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/TipoCombustible.php");

$ciudad = new Ciudad();
$ciudades = $ciudad->listar();
/* VARIABLES MENU*/
$titulo = 'Registrar Vehiculos';
$redireccion = 'vehiculos.php';
$icono = 'fa fa-car';

$tipoVehiculo = new TipoVehiculo();
$listarTV = $tipoVehiculo->listar();

$tipoServicio = new TipoServicio();
$listarTS = $tipoServicio->listar();

$contrato = new Contrato();
$hoy = date('Y-m-d');
$listarC = $contrato->listarContratosHabiles($hoy);

$empresa = new Empresa();
$listadoEmpresas = $empresa->listar();
$cliente = new Cliente();

$clienteConvenio = new Cliente_Convenio();
$listarEmpresasConvenio = $clienteConvenio->listar();

$paises = Paises();

$usuario = new Usuario();
$listarUsuariosProp = $usuario->listarPropietariosExistentesVehiculos();

$tipocombustible = new TipoCombustible();
$listarTipoCombustible = $tipocombustible->listar();

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
            background: #1b2d3b !important;
            border: #fff;
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

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
    	        <form action="../Controlador/registrarVehi.php" method="POST" id="registroVehi" enctype="multipart/form-data">
    	        	<div id="tabs">
                        <ul>
                          <li><a href="#tabs-1">Información </a></li>
                          <li><a href="#tabs-2">Documentación </a></li>
                          <li><a href="#tabs-3">Fotografias</a></li>
                          <li><a href="#tabs-4">Propietario</a></li>
                          <li><a href="#tabs-5">Referencias Propietario</a></li>
                          <li><a href="#tabs-6">Contrato</a></li>
                          <li><a href="#tabs-7">Flota propia</a></li>
                          <li><a href="#tabs-8">Empresa Conv</a></li>
                        </ul>

                        <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-4">

                                <!-- TIPO VEHICULO -->
                                <div class="row ">
                                    <div class="label">
                                        <label>Tipo Vehiculo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo" title="SELECCIONAR" required="required" >
                                            <?php foreach ($listarTV as $ltv){ ?>
                                                <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                    <?php echo $ltv['nombre_tipo_vehiculo'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>              
                                </div>

                                <!-- TIPO SERVICIO-->
                                <div class="row mt-3 ">
                                    <div class="label">
                                        <label>Tipo servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_tipo_servicio" id="id_tipo_servicio" title="SELECCIONAR" required="required" >
                                            <?php foreach ($listarTS as $lts){ ?>
                                                <option value="<?php echo $lts['id_tipo_servicio'] ?>">
                                                        <?php echo $lts['nombre_tipo_servicio'] ?>
                                                </option>
                                            <?php } ?>
                                            </select>
                                    </div>              
                                </div>

                                <!-- PLACA -->
                                <div class="row  mt-3  ">
                                    <div class="label">
                                        <label>Placa <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <input type="text" maxlength="6" name="placa" id="placa" class="form-control form-control-sm" required="required" />
                                    </div>      		
                                </div>     
                                    
                                <!-- CANT PASAJEROS-->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Cantidad de pasajeros <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="cant_pasajeros" id="cant_pasajeros" class="form-control form-control-sm" required="required">
                                    </div>              
                                </div>

                                <!--  MARCA -->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Marca y Linea <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
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
                                
                                <!-- TIPO DE AFILIACIÓN -->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Tipo Afiliación<i style="font-size: .4rem;" class="fa fa-asterisk ml-1"></i></label>
                                    </div>
                                    <div class="input">
                                        <select name="tipo_afiliacion" id="tipo_afiliacion" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR" required="required">
                                            <option value="TERCERO">EXTERNO (TERCERO)</option>
                                            <option value="AFILIADO">AFILIADO</option>
                                        </select>
                                    </div>              
                                </div>

                                <div class="row m-3 p-3" id="campo_afiliado" style="border: 1px dashed #d3d3d3; border-radius:5px; display:none;">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>Empresa Afiliada</label>
                                        <select name="empresa_afiliada" id="empresa_afiliada" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                            <option value="ORT">ORT</option>
                                            <option value="LP">LINEAS PREMIUM</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>NIT Empresa Afiliada</label>
                                        <input type="text" name="nit_empresa_afiliada" id="nit_empresa_afiliada" class="form-control form-control-sm" placeholder="NIT" readonly="readonly">     
                                    </div>
                                </div>
                                
                                <div class="row m-3 p-3" id="campo_externo" style="border: 1px dashed #d3d3d3; border-radius:5px; display:none;">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>Nombre Empresa</label>
                                        <input type="text" name="otra_empresa_afiliada" id="otra_empresa_afiliada" class="form-control form-control-sm" placeholder="Razon Social">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>NIT Empresa Afiliada</label>
                                        <input type="text" name="nit_otra_empresa_afiliada" id="nit_otra_empresa_afiliada" class="form-control form-control-sm" placeholder="NIT">     
                                    </div>
                                </div>   

                                <!-- NUMERO MOVIL-->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Numero movil <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="movil" id="movil_afiliado" class="form-control form-control-sm" style="display:none;" value="">
                                        <input type="text" name="movil" id="movil_tercero" class="form-control form-control-sm" style="display:none;" value="C-">
                                    </div>      		
                                </div>

                                <!-- NUMERO MOTOR-->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Numero motor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="numero_motor" id="numero_motor" class="form-control form-control-sm" required="required">
                                    </div>              
                                </div>

                                <!-- NUMERO CHASIS-->
                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Numero chasis <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="numero_chasis" id="numero_chasis" class="form-control form-control-sm" required="required">
                                    </div>              
                                </div>

                                <!-- FECHA REGISTRO -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Fecha Registro (Licecia)</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="fecha_registro" id="fecha_registro" class="form-control form-control-sm">
                                        
                                    </div>      		
                                </div>
                                
                                <!-- CIUDAD REGISTRO -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Ciudad Registro (Licecia)</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="ciudad_registro" id="ciudad_registro" class="form-control form-control-sm">
                                        
                                    </div>      		
                                </div>
                                
                                <!-- NUMERO DE PUERTAS -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Numero de Puertas</label>
                                    </div>
                                    <div class="input">
                                        <input type="number" name="num_puertas" id="num_puertas" class="form-control form-control-sm" min="0" >
                                        
                                    </div>      		
                                </div>
                                
                                <!-- CILINDRAJE -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Cilindraje</label>
                                    </div>
                                    <div class="input">
                                        <input type="number" name="cilindraje" id="cilindraje" class="form-control form-control-sm" min="0" >
                                        
                                    </div>      		
                                </div>
                                
                                <!-- TIPO CARROCERIA -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Tipo Carroceria</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="tipo_carroceria" id="tipo_carroceria" class="form-control form-control-sm">
                                        
                                    </div>      		
                                </div>
                                
                                <!-- TIPO COMBUSTIBLE -->
                                <div class="row  mt-3">
                                    <div class="label">
                                        <label>Tipo Combustible</label>
                                    </div>
                                    <div class="input">
                                        <select name="tipo_combustible" id="tipo_combustible" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                            <?php foreach($listarTipoCombustible as $tipocom){ ?>
                                            <option value="<?php echo $tipocom['detalle'];?>"><?php echo $tipocom['detalle'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>      		
                                </div>

                            </div>

                        <!------------------ ************************** ------------------>

                        <!-- DOCUMENTACION-->
                            <div id="tabs-2">

                            	<!-- TARJETA DE OPERACIÓN -->
                                    
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
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Número Tarj. Operación</label>
                                            <input type="text" name="num_tarjeta_operacion" id="num_tarjeta_operacion" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Vencimiento Tarj. Operación</label>
                                            <input type="text" name="fecha_vencimiento_to" id="fecha_vencimiento_to" class="form-control form-control-sm">
                                        </div>           
                                    </div>
                                    
                                <!--  ---------------------  -->

                                <!---------  LICENCIA  -------->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                    <p>Licencia de Tránsito</p>
                                </div>

                                <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                        <label>Documento Licencia de Tránsito</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                        <input type="file" name="licencia_transito"  id="licencia_transito" class="form-control form-control-sm" >
                                    </div>        
                                </div> 

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>Número Lic. Tránsito</label>
                                        <input type="text" name="num_licencia_transito" id="num_licencia_transito" class="form-control form-control-sm" >     
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label>Expedición Lic. Tránsito</label>
                                        <input type="text" name="fecha_vencimiento_lt" id="fecha_vencimiento_lt" class="form-control form-control-sm">     
                                    </div>
                                </div>   

                                <!--  ---------------------  -->

                                <!----------- SOAT ------------>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                    <p>SOAT</p>
                                </div>

                                <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                        <label>Documento SOAT</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                        <input type="file" name="soat"  id="soat" class="form-control form-control-sm" >
                                    </div>        
                                </div>  

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Número SOAT</label>
                                        <input type="text" name="num_soat" id="num_soat" class="form-control form-control-sm">
                                    </div>   
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Vencimiento SOAT</label>
                                        <input type="text" name="fecha_vencimiento_soat" id="fecha_vencimiento_soat" class="form-control form-control-sm">
                                    </div>           
                                </div>  

                                <!--  ---------------------  -->
        		       
                                <!------- REVISION TECNOMECANICA ------>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                    <p>Revisión Tecnomecanica</p>
                                </div>

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                        <label>Documento Rev. Tecnomecanica</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                        <input type="file" name="revision_tecnomecanica" id="revision_tecnomecanica" class="form-control form-control-sm">
                                    </div>
                                </div>  

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
                                        <label>Número Tecnomecanica</label>
                                        <input type="text" name="num_revision_tecnomecanica" id="num_revision_tecnomecanica" class="form-control form-control-sm">    
                                    </div>   
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-6">
                                        <label>Vencimiento Rev. Tecnomecanica</label>
                                        <input type="text" name="fecha_vencimiento_rt" id="fecha_vencimiento_rt" class="form-control form-control-sm">
                                    </div>           
                                </div>  

                                <!--  ---------------------  -->
        		       
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

                                <!--  ---------------------  -->

        		                <!-------- RCE Y RCC --------->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Póliza de RCC (Responsabilidad Civil Contractual)</p>
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
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Número Póliza de RCC</label>
                                            <input type="text" name="num_poliza_contra" id="num_poliza_contra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Vencimiento Póliza de RCC</label>
                                            <input type="text" name="fecha_vencimiento_contra" id="fecha_vencimiento_contra" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->
                                           
                                
                                <!-------- RCE Y RCC --------->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Póliza de RCE (Responsabilidad Civil Extracontractual)</p>
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
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Número Póliza de RCE</label>
                                            <input type="text" name="num_poliza_extra" id="num_poliza_extra" class="form-control form-control-sm">
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Vencimiento Póliza de RCE</label>
                                            <input type="text" name="fecha_vencimiento_extra" id="fecha_vencimiento_extra" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->

                                <!-- DISPOSITIVO DE VELOCIDAD -->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Verificación Dispositivo Velocidad</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Documento Disp. de Velocidad</label>
                                            <input type="file" name="disp_velocidad" id="disp_velocidad" class="form-control" >
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Expedición Disp. de Velocidad</label>
                                            <input type="text" name="fecha_exp_disp_velocidad" id="fecha_exp_disp_velocidad" class="form-control form-control-sm">
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->
                                
                                <!-- FICHA TECNICA DE HOMOLOGACIÓN-->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Ficha Tecnica de Homologación</p>
                                    </div>

                                    <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <label>Documento Ficha Tec. de Homologación</label>
                                        </div>  
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <input type="file" name="ficha_tecnica_homologacion"  id="ficha_tecnica_homologacion" class="form-control" >
                                        </div>           
                                    </div>  

                                <!--  --------------------- -->
                                
                                <!------- TODO RIESGO -------->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                    <p>Seguro Todo Riesgo</p>
                                </div>

                                <div class="row m-3 p-2" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                        <label>Documento Seguro Todo Riesgo</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                        <input type="file" name="seguro_todo_riesgo" id="seguro_todo_riesgo" class="form-control form-control-sm" >
                                    </div>        
                                </div>  

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Número Seguro Todo Riesgo</label>
                                        <input type="text" name="num_seguro_todo_riesgo" id="num_seguro_todo_riesgo" class="form-control form-control-sm">
                                    </div>  
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Vencimiento Seguro Todo Riesgo</label>
                                        <input type="text" name="fecha_vencimiento_tr" id="fecha_vencimiento_tr" class="form-control form-control-sm">
                                    </div>           
                                </div>  

                                <!--  --------------------- -->
                                
                            </div>

                        <!-- FOTOS DEL VEHICULO-->

                            <div id="tabs-3">
                                    
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

                        <!--PROPIETARIO-->

                            <div id="tabs-4">
                           
                                <!-- OPCIONES REGISTRO PROPIETARIO -->
                                    <div class="row mt-3">
                                        <div class="label">
                                            <label>Seleccione el tipo de registro para el propietario <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="opcionProp" id="opcionProp" onchange="validarOpcionProp(this.value);" required="required">
                                                <option value="">SELECCIONAR</option>
                                                <option value="BA">Buscar y Anclar</option>
                                                <option value="RN">Registrar Nuevo</option>
                                            </select>
                                        </div>              
                                    </div>


                                <div id="contentExistingProp" style="display: none;">

                                    <!-- PROPIETARIOS -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Propietario</label>
                                            </div>
                                            <div class="input">
                                                 <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_propietario" id="id_propietario">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarUsuariosProp as $lupe){ ?>
                                                        <option value="<?php echo $lupe['id_usuario'] ?>"><?php echo $lupe['nombre'] . ' - ' . $lupe['usuario']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>              
                                        </div>

                                </div>

                                <div id="contentNewProp" style="display: none;">

                               		<!-- TIPO PROPIETARIO -->  
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Tipo Propietario <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control form-control-sm" name="tipo_propietario">
                                                    <option value="PN">Persona Natural</option>
                                                    <option value="PJ">Persona Juridica</option>
                                                </select>
                                            </div>              
                                        </div>

                                    <!-- PROPIEDAD DE -->  
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Propiedad de <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control form-control-sm" name="propiedad">
                                                    <option value="Propia">Propio</option>
                                                    <option value="Leasing">Leasing</option>
                                                    <option value="Fiduciaria">Fiduciaria</option>
                                                </select>
                                            </div>              
                                        </div>

                                    <!-- NOMBRE -->  
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Nombre  <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="nombre" id="nombre" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- CEDULA --> 
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Numero Documento o Nit <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="cedula" id="cedula" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- CORREO ELECTRONICO --> 
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Correo Electronico  <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- TELEFONO --> 
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Telefono  <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="telefono_propietario" id="telefono_propietario" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- FOTOCOPIA CEDULA -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Fotocopia de la Cedula</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="fotocopia_cedula_propietario"  id="fotocopia_cedula_propietario" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                    <!-- DIRECCION PROPIETARIO--> 
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Dirección  <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="direccion_propietario" id="direccion_propietario" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- CIUDAD PROPIETARIO--> 
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Ciudad Residencia</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="ciudad_propietario" id="ciudad_propietario" class="form-control form-control-sm">
                                            </div>              
                                        </div>

                                    <!-- CAMARA DE COMERCIO -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Camara de Comercio</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="camara_comercio"  id="camara_comercio" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                    <!-- CONTRATO LEASING o FIDUCIA -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Contrato Leasing o Fiducia</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="contrato_banco"  id="contrato_banco" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                    <!-- HOJA DE VIDA -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Hoja de Vida</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="hoja_vida"  id="hoja_vida" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                    <!-- RUT -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Registro Único Tributario (RUT)</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="rut"  id="rut" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                    <!-- PODER APODERADO -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Poder Apoderado</label>
                                            </div>
                                            <div class="input">
                                                <input type="file" name="poder_apoderado"  id="poder_apoderado" class="form-control form-control-sm" >
                                            </div>              
                                        </div>

                                </div>
                           </div> 

                        <!--REFERENCIAS-->

                            <div id="tabs-5">

                                <!-- REFERENCIAS COMERCIALES -->
                                
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Comerciales</p>
                                    </div>

                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre_rc" id="nombre_rc" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Telefono</label>
                                            <input type="text" name="telefono_rc" id="telefono_rc" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Dirección</label>
                                            <input type="text" name="direccion_rc" id="direccion_rc" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                <!-- REFERENCIAS LABORALES -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Laborales</p>
                                    </div>

                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre_rl" id="nombre_rl" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Telefono</label>
                                            <input type="text" name="telefono_rl" id="telefono_rl" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Dirección</label>
                                            <input type="text" name="direccion_rl" id="direccion_rl" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                <!-- REFERENCIAS FAMILIARES -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Familiares</p>
                                    </div>

                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre_rf" id="nombre_rf" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Telefono</label>
                                            <input type="text" name="telefono_rf" id="telefono_rf" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Dirección</label>
                                            <input type="text" name="direccion_rf" id="direccion_rf" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                <!-- REFERENCIAS PERSONALES -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>Referencias Personales</p>
                                    </div>

                                    <div class="row p-3" style="border-radius: 3px; border: 1px solid #ddd; background-color: #f5f5f5">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Nombre</label>
                                            <input type="text" name="nombre_rp" id="nombre_rp" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Telefono</label>
                                            <input type="text" name="telefono_rp" id="telefono_rp" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Dirección</label>
                                            <input type="text" name="direccion_rp" id="direccion_rp" class="form-control form-control-sm">
                                        </div>
                                    </div>                  
                            </div>

                        <!--CONTRATO-->
                            <div id="tabs-6">

                                <div class="row m-3 p-3" style="border: 1px dashed #d3d3d3; border-radius:5px;">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Documento Cont. de Transporte / Vinculación</label>
                                        <input type="file" name="seguro_todo_riesgo" id="seguro_todo_riesgo" class="form-control form-control-sm">
                                    </div>  
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <label>Expedición Cont. de Vinculación</label>
                                        <input type="text" name="fecha_exp_contrato_vinculacion" id="fecha_exp_contrato_vinculacion" class="form-control form-control-sm">
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

                        <!--FLOTA PROPIA-->
                            <div id="tabs-7">

                                <!-- FLOTA PROPIA --> 

                                    <div class="row  mt-3  ">
                                            
                                        <div class="label">
                                            <label>¿Es una flota propia?  <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <select name="flota_propia" id="flota_propia" class="form-control form-control-sm" onchange="flota(this.value)" required="required" >
                                                <option value="">SELECCIONAR</option>
                                                <option value="S">SI</option>
                                                <option value="N">NO</option>
                                            </select>
                                        </div>    

                                    </div> 

                                     <div class="row mt-3" id="empresas" style="display:none">
                                        <div class="label">
                                            <label>Empresa</label>
                                        </div>
                                        <div class="input">
                                            <select name="id_empresa" id="id_empresa" class="form-control form-control-sm selectpicker" title="SELECCIONAR" data-live-search="true" >
                                                <?php foreach($listadoEmpresas as $le){?>
                                                    <option value="<?php echo $le['id_empresa'];?>"><?php echo $le['nombre_empresa'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div>      
                            </div>  

                        <!--EMPRESA CONVENIO-->
                            <div id="tabs-8">

                                <div class="row  mt-3 ">
                                    <div class="label">
                                        <label>Seleccione el tipo de registro para la empresa</label>
                                    </div>
                                    <div class="input">
                                        <select name="tipo_registroEmpConv" id="tipo_registroEmpConv" class="form-control" onchange="validarOpcionRegistro(this.value);">
                                            <option value="">Seleccionar</option>
                                            <option value="BA">Buscar y Anclar</option>
                                            <option value="NR">Nuevo Registro</option>
                                        </select>
                                    </div>              
                                </div> 

                                <!-- EMPRESAS CONVENIO --> 
                                    <div class="row  mt-3 " id="empresaConvenio" style="display: none;">
                                        <div class="label">
                                            <label>Empresas Convenio</label>
                                        </div>
                                        <div class="input">
                                            <select name="id_empresa_convenio" id="id_empresa_convenio" class="form-control selectpicker" data-live-search="true">
                                                <option value="">SELECCIONAR</option>
                                                <?php foreach ($listarEmpresasConvenio as $lec){ ?>
                                                    <option value="<?php echo $lec['id_cliente'] ?>"><?php echo $lec['razon_social'] . " - Nit " . $lec['nit_cliente']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div> 

                                <!-- NUEVO REGISTRO --> 

                                    <section class="col-12" id="nuevoRegistroEmpresa" style="display: none;">

                                        <!-- Razón Social-->
                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>Razon Social</label>
                                                </section>
                                                <section class="input">
                                                        <input type="text" name="razon_social" id="razon_social" class="form-control" maxlength="82">
                                                </section>
                                            </div>

                                        <!-- Nit-->

                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>NIT o Cedula</label>
                                                </section>
                                                <section class="input">
                                                    <input type="text" name="nit_cliente" id="nit_cliente" class="form-control">
                                                </section>
                                            </div>

                                        <!-- Direccion-->

                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>Direccion</label>
                                                </section>
                                                <section class="input">
                                                    <input type="text" name="direccion" id="direccion" class="form-control">
                                                </section>
                                            </div>

                                        <!-- Telefono-->

                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>Telefono</label>
                                                </section>
                                                <section class="input">
                                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                                </section>
                                            </div>
                                            
                                        <!-- Representante Legal-->

                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>Nombre Representante Legal</label>
                                                </section>
                                                <section class="input">
                                                    <input type="text" name="nombre_rl" id="nombre_rl" class="form-control">
                                                </section>
                                            </div>

                                        <!-- Identificacion Representante Legal-->
                                            <div class="row mt-3">
                                                <section class="label">
                                                    <label>No. Documento</label>
                                                </section>
                                                <section class="input">
                                                    <input type="text" name="doc_rl" id="doc_rl" class="form-control">
                                                </section>
                                            </div>

                                        <!-- Pais Expedicion RL-->

                                            <div class="row  mt-3 ">
                                                <section class="label">
                                                    <label>Pais Expedicion</label>
                                                </section>
                                                <section class="input">
                                                    <select name="id_pais_exp" id="id_pais_exp" class="form-control" onchange="cargar_departamentos_exp(this.value)">
                                                        <option>Seleccionar</option>
                                                        <?php foreach ($paises as $lcl){ ?>
                                                            <option value="<?php echo $lcl['id_pais'] ?>">
                                                                <?php echo $lcl['pais'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </section>
                                            </div>

                                        <!-- Departamento Expedicion RL-->

                                            <div class="row  mt-3">
                                                <section class="label">
                                                    <label>Departamento Expedicion</label>
                                                </section>
                                                <section class="input">
                                                    <select name="id_departamento_exp" id="id_departamento_exp" class="form-control" onchange="cargar_ciudades_exp(this.value)">
                                                    </select>
                                                 </section>
                                            </div>

                                        <!-- Ciudad Representante Legal-->
                                            <div class="row  mt-3">
                                                <section class="label">
                                                    <label>Ciudad Expedicion</label>
                                                </section>
                                                <section class="input">
                                                    <select name="id_ciudad_exp" id="id_ciudad_exp" class="form-control">
                                                    </select>
                                                 </section>
                                            </div>

                                    </section>
                            </div>
                    </div>

                    <!-- BOTONES -->
                    
                        <section class="col-12 mt-5 d-flex justify-content-center">
                          
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

        $('#tipo_afiliacion').on('change', function(){
            if(this.value == 'TERCERO'){
                $('#campo_afiliado').css('display' , 'none');
                $('#campo_externo').css('display' , 'flex');
                $('#movil_afiliado').css('display' , 'none');
                $('#movil_tercero').css('display' , 'flex');
                document.getElementById('otra_empresa_afiliada').required = true;
                document.getElementById('nit_otra_empresa_afiliada').required = true;
                document.getElementById('empresa_afiliada').required = false;
                document.getElementById('nit_empresa_afiliada').required = false;
            }else{
                $('#campo_afiliado').css('display', 'flex');
                $('#campo_externo').css('display' , 'none');
                $('#movil_afiliado').css('display' , 'flex');
                $('#movil_tercero').css('display' , 'none');
                document.getElementById('otra_empresa_afiliada').required = false;
                document.getElementById('nit_otra_empresa_afiliada').required = false;
                document.getElementById('empresa_afiliada').required = true;
                document.getElementById('nit_empresa_afiliada').required = true;
            }
        })
        
        $('#empresa_afiliada').on('change', function(){
            if(this.value == 'ORT'){
                document.getElementById('nit_empresa_afiliada').value = "830.099.803-4";
            }else if(this.value == 'LP'){
                document.getElementById('nit_empresa_afiliada').value = '900.461.872-8';
            }
        })

        function validarOpcionProp(value){
            if (value == 'BA') {
                document.getElementById('contentExistingProp').style.display = 'block';
                document.getElementById('contentNewProp').style.display = 'none';
            }else if(value == 'RN'){
                document.getElementById('contentNewProp').style.display = 'block';
                document.getElementById('contentExistingProp').style.display = 'none';
            }else{
                document.getElementById('contentExistingProp').style.display = 'none';
                document.getElementById('contentNewProp').style.display = 'none';
            }
        }

    	$(function() {
            $("#fecha_vencimiento_to").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_lt").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_soat").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_rt").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_rp").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_contra").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_extra").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_exp_disp_velocidad").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_vencimiento_tr").datepicker({dateFormat:'yy/mm/dd'});
            $("#fecha_exp_contrato_vinculacion").datepicker({dateFormat:'yy/mm/dd'});
			$("#fecha_registro").datepicker({dateFormat:'yy/mm/dd'});
        });

        $(function() {
          $("#tabs").tabs();
        }); 

        function validarOpcionRegistro(val){
            if (val == 'BA') {
                document.getElementById('empresaConvenio').style.display = 'flex';
                document.getElementById('nuevoRegistroEmpresa').style.display = 'none';
            }else if(val == 'NR'){
                document.getElementById('nuevoRegistroEmpresa').style.display = 'block';
                document.getElementById('empresaConvenio').style.display = 'none';
            }else{
                document.getElementById('empresaConvenio').style.display = 'none';
                document.getElementById('nuevoRegistroEmpresa').style.display = 'none';
            }
        }

        function cargar_departamentos_exp(id_pais){
            //alert(id_pais); 
            if(id_pais != ''){
                var parametros = {
                    "id_pais" : id_pais
                };
                $.ajax({
                    data:  parametros,
                    url:   '../Controlador/listarDepartamentos.php',
                    type:  'post',
                    beforeSend: function () {
                        $("#id_departamento_exp").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                    },
                    success:  function (response) {
                        $("#id_departamento_exp").html(response);
                    }
                });
            }
            cargar_ciudades_exp(0);
        }

        function cargar_ciudades_exp(id_departamento){
          //alert(id_departamento); 
          if(id_departamento != ''){
              var parametros = {
                "id_departamento" : id_departamento
              };
              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarCiudades.php',
                  type:  'post',
                  beforeSend: function () {
                      //alert('envio');
                      $("#id_ciudad_exp").html("<option value='' disabled='disabled' selected='selected'>Cargando datos, por favor espere</option>");
                  },
                  success:  function (response) {
                      //alert(response);
                      $("#id_ciudad_exp").html(response);
                  }
              });
          }
        }

        $( function(){
            $("#id_contrato_apoyo").chosen(); 
        });

        function flota(opcion){
            if(opcion == 'S'){
                document.getElementById('empresas').style.display = "flex";
                document.getElementById('id_empresa').required = true;
            } else {
                document.getElementById('empresas').style.display = "none";
                document.getElementById('id_empresa').required = false;
            }
        }

 
		function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var nombres = [<?php foreach($ciudades as $ct){ ?> "<?php echo $ct['ciudad'];?>", <?php } ?> ];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("ciudad_registro"), nombres);

/*
        function validar(){
            document.getElementById('guardar').innerHTML = 'Por favor espere';
            document.getElementById('guardar').disabled = true;

            return true;
        }

        onsubmit="return validar()"*/
    </script>
    
</body>
</html>