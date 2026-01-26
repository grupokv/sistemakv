<?php 
//include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Vehiculo.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Conductor.php");

$vehiculo = new Vehiculo();
$empresa = new Empresa();
$conductor = new Conductor();

$listarVehActivos = $vehiculo->listarActivos();
$listarCondActivos = $conductor->listarConductoresActivos();
$listarE = $empresa->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Inspección Vehicular</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #1b2d3b !important;
            border: #fff;
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
    
        <section class="home_content">  

            <div aria-label="breadcrumb" class="mt-1"> 
                <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="inspeccionVehicular.php">Inspección Vehicular</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar Inspección</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>REGISTRAR INSPECCIÓN VEHICULAR</strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
                    <form action="../Controlador/registrarInspeccionVehicular.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
                        <div id="tabs" class="mt-4">
                            <ul>
                                <li><a href="#tabs-1">General </a></li>
                                <li><a href="#tabs-2">Documentación </a></li>
                                <li><a href="#tabs-3">1ra Sección</a></li>
                                <li><a href="#tabs-4">2da Sección</a></li>
                                <li><a href="#tabs-5">3ra Sección</a></li>
                                <li><a href="#tabs-6">Daños Observados</a></li>
                            </ul>

                            <!-- INFORMACION BASICA-->
                                <div id="tabs-1" class="p-4">

                                    <!-- ENTREGA VEHÍCULO -->
                                    <div class="row m-4 p-2" style="border:1px dashed #d3d3d3;">
                                        <div class="label col-lg-5">
                                            <label>¿La inspección hace parte de la entrega del vehículo? <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="entrega_vehiculo" id="entrega_vehiculo" title="SELECCIONAR" required="required" onchange="entrega(this.value)" >
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>              
                                    
                                        <div class="label col-lg-5 mt-2">
                                            <label>¿El vehiculo ya esta creado en la plataforma? <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 mt-2">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="existe_vehiculo" id="existe_vehiculo" title="SELECCIONAR" required="required" onchange="existe_veh(this.value)" >
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>              
                                    
                                        <div class="label col-lg-5 mt-2">
                                            <label>¿El conductor ya esta creado en la plataforma? <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 mt-2">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="existe_conductor" id="existe_conductor" title="SELECCIONAR" required="required" onchange="existe_cond(this.value)" >
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Empresa</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control form-control-sm" name="empresa" id="empresa" >
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Contrato</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control form-control-sm" name="contrato" id="contrato" >
                                        </div>              
                                    </div>

                                    <!-- VEHÍCULO -->
                                    <div class="row mt-2" id="vehiculo_existe" style="display:none">
                                        <div class="label">
                                            <label>Vehículo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control form-control-sm selectpicker" onchange="traer_datos_veh(this.value)" data-live-search="true" name="id_vehiculo" id="id_vehiculo" title="SELECCIONAR" required="required" >
                                                <?php foreach($listarVehActivos As $lva){ ?>
                                                    <option value="<?php echo $lva['id_vehiculo']; ?>"><?php echo $lva['placa'] . " - " . $lva['numero_movil'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Placa <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="placa" id="placa" required="required" value="" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Movil <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="movil" id="movil" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Capacidad <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="cantidad" id="cantidad" required="required" value="" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Modelo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="modelo" id="modelo" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Tipo Vehiculo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tipo_vehiculo" id="tipo_vehiculo" required="required" value="" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Tipo Combustible <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tipo_combustible" id="tipo_combustible" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <!-- CONDUCTOR -->
                                    <div class="row mt-2" id="conductor_existe" style="display:none">
                                        <div class="label">
                                            <label>Conductor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_conductor" id="id_conductor" title="SELECCIONAR" required="required" onchange="traer_datos_cond(this.value)" >
                                                <?php foreach($listarCondActivos As $lca){ ?>
                                                    <option value="<?php echo $lca['id_conductor']; ?>"><?php echo $lca['nombre_conductor'] . " - " . $lca['numero_documento_conductor'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Nombre Conductor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input" id="conductores">
                                            <input type="text" name="nombre_conductor" id="nombre_conductor" class="form-control form-control-sm" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Numero Doc <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="num_doc_conductor" id="num_doc_conductor" required="required" value="" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Numero Licencia <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="num_lic_conductor" id="num_lic_conductor" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Celular <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tel_conductor" id="tel_conductor" required="required" value="" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Fecha Venc. Licencia <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="fecha_lic_conductor" id="fecha_lic_conductor" required="required" value="" />
                                        </div>              
                                    </div>
                                    
                                    <!-- NIVEL GASOLINA -->
                                    <div class="row mt-3">
                                        <div class="label">
                                            <label>Nivel de Combustible <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row">
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor1.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="Empty" required="required">
                                            </div>

                                            <div class="col-2">
                                                <img src="../Resources/images/medidor4.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="1/4" required="required">
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor2.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="1/2" required="required">
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor5.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="small" required="required">
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor3.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="Full" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- FECHA PROXIMO MTTO -->
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Kilometraje <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" name="kilometraje" id="kilometraje" class="form-control form-control-sm" required="required" value=""/>
                                        </div>   
                                        
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Fecha Proxima Inspección <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" name="fecha_proximo_mtto" id="fecha_proximo_mtto" class="form-control form-control-sm" value=""/>
                                        </div>              
                                    </div>  
                                    
                                </div>

                            <!-- DOCUMENTACIÓN -->
                                <div id="tabs-2" class="p-4">

                                    <!-- TARJETA DE PROPIEDAD 
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tarjeta de Propiedad <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="tarjeta_propiedad1">SI</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_propiedad2">NO</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_propiedad3">N/A</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="tarjeta_propiedad_fv">Fecha Expedición</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tarjeta_propiedad_fv" id="tarjeta_propiedad_fv" value="">
                                            </div>
                                        </div>              
                                    </div>-->

                                    <!-- TARJETA DE OPERACIÓN -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tarjeta de Operación <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="tarjeta_operacion1">SI</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_operacion2">NO</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_operacion3">N/A</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="tarjeta_operacion_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tarjeta_operacion_fv" id="tarjeta_operacion_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- SOAT -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>SOAT <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="soat1">SI</label>
                                                <input type="radio" name="soat" id="soat1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="soat2">NO</label>
                                                <input type="radio" name="soat" id="soat2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="soat3">N/A</label>
                                                <input type="radio" name="soat" id="soat3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="soat_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="soat_fv" id="soat_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- POLIZAS EXTRA Y CONTRA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Polizas Extra y Contra <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="polizas_extra_contra1">SI</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="polizas_extra_contra2">NO</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="polizas_extra_contra3">N/A</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="poliza_extra_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="poliza_extra_fv" id="poliza_extra_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- REVISIÓN TECNOMECANICA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Revisión Tecnomecánica <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="revision_tecnomecanica1">SI</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_tecnomecanica2">NO</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_tecnomecanica3">N/A</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="tecnomecanica_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tecnomecanica_fv" id="tecnomecanica_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- REVISIÓN PREVENTIVA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Revisión Preventiva <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row justify-content-center">
                                            <div class="col-2">
                                                <label for="revision_preventiva1">SI</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_preventiva2">NO</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_preventiva3">N/A</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="preventiva_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="preventiva_fv" id="preventiva_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- FUEC -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Extracto de Contrato (FUEC) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="fuec1">SI</label>
                                                <input type="radio" name="fuec" id="fuec1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="fuec2">NO</label>
                                                <input type="radio" name="fuec" id="fuec2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="fuec3">N/A</label>
                                                <input type="radio" name="fuec" id="fuec3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="fuec_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="fuec_fv" id="fuec_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- DISPOSITIVO DE VELOCIDAD -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Dispositivo de Velocidad <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad1">SI</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad2">NO</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad3">N/A</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="disp_velocidad_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="disp_velocidad_fv" id="disp_velocidad_fv" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LICENCIA DE TRANSITO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Licencia de Transito <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="licencia_transito1">SI</label>
                                                <input type="radio" name="licencia_transito" id="licencia_transito1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_transito2">NO</label>
                                                <input type="radio" name="licencia_transito" id="licencia_transito2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_transito3">N/A</label>
                                                <input type="radio" name="licencia_transito" id="licencia_transito3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="licencia_transito_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="licencia_transito_fv" id="licencia_transito_fv" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LICENCIA DE CONDUCCION -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Licencia de Conducción <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="licencia_conduccion1">SI</label>
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_conduccion2">NO</label>
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_conduccion3">N/A</label>
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="licencia_conduccion_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="licencia_conduccion_fv" id="licencia_conduccion_fv" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- PLANILLA SS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Seguridad Social Vigente <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="seguridad_social1">SI</label>
                                                <input type="radio" name="seguridad_social" id="seguridad_social1" value="SI" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="seguridad_social2">NO</label>
                                                <input type="radio" name="seguridad_social" id="seguridad_social2" value="NO" required="required">
                                            </div>
                                            <div class="col-2">
                                                <label for="seguridad_social3">N/A</label>
                                                <input type="radio" name="seguridad_social" id="seguridad_social3" value="N/A" required="required">
                                            </div>
                                            <div class="col-6">
                                                <label for="seguridad_social_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="seguridad_social_fv" id="seguridad_social_fv" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                </div>  

                            <!-- PRIMERA SECCIÓN -->
                                <div id="tabs-3" class="p-4">    
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>KIT DE CARRETERA</p>
                                    </div>

                                    <!-- GATO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Gato <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="gato1">SI</label>
                                                <input type="radio" name="gato" id="gato1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="gato2">NO</label>
                                                <input type="radio" name="gato" id="gato2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- CRUCETA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Cruceta o Copas de Tuercas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="cruceta1">SI</label>
                                                <input type="radio" name="cruceta" id="cruceta1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="cruceta2">NO</label>
                                                <input type="radio" name="cruceta" id="cruceta2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- SEÑALES DE CARRETERA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Señales de Carretera <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="seniales_carretera1">SI</label>
                                                <input type="radio" name="seniales_carretera" id="seniales_carretera1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="seniales_carretera2">NO</label>
                                                <input type="radio" name="seniales_carretera" id="seniales_carretera2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- TACOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tacos (Especificos al tipo de Vehículo) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="tacos1">SI</label>
                                                <input type="radio" name="tacos" id="tacos1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="tacos2">NO</label>
                                                <input type="radio" name="tacos" id="tacos2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- LINTERNA CON PILAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Linterna (Con Pilas) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="linterna1">SI</label>
                                                <input type="radio" name="linterna" id="linterna1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="linterna2">NO</label>
                                                <input type="radio" name="linterna" id="linterna2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- LLAVES FIJAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Llaves Fijas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="llaves_fijas1">SI</label>
                                                <input type="radio" name="llaves_fijas" id="llaves_fijas1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="llaves_fijas2">NO</label>
                                                <input type="radio" name="llaves_fijas" id="llaves_fijas2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- ALICATES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Alicates <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="alicates1">SI</label>
                                                <input type="radio" name="alicates" id="alicates1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="alicates2">NO</label>
                                                <input type="radio" name="alicates" id="alicates2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- LLAVE EXPANSIVA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Llave Expansiva <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="llave_expansiva1">SI</label>
                                                <input type="radio" name="llave_expansiva" id="llave_expansiva1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="llave_expansiva2">NO</label>
                                                <input type="radio" name="llave_expansiva" id="llave_expansiva2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- DESTORNILLADOR -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Destornillador (Pala - Estrella - Mixto) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="destornillador1">SI</label>
                                                <input type="radio" name="destornillador" id="destornillador1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="destornillador2">NO</label>
                                                <input type="radio" name="destornillador" id="destornillador2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- CHALECO REFLECTIVO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Chaleco Reflectivo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="chaleco_reflectivo1">SI</label>
                                                <input type="radio" name="chaleco_reflectivo" id="chaleco_reflectivo1" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="chaleco_reflectivo2">NO</label>
                                                <input type="radio" name="chaleco_reflectivo" id="chaleco_reflectivo2" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    
                                    <!-- EXTINTOR CAPACIDAD -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Extintor<i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="extintor2">SI</label>
                                                <input type="radio" name="extintor" id="extintor2" value="SI" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="extintor3">NO</label>
                                                <input type="radio" name="extintor" id="extintor3" value="NO" required="required">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="extintor_cap">Capacidad (Lb)</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="extintor_cap" id="extintor_cap" value="">
                                            </div>
                                            <div class="col-5">
                                                <label for="extintor_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="extintor_fv" id="extintor_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- ****************************** -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>BOTIQUIN</p>
                                    </div>

                                    <!-- ******************************  -->

                                    <!-- GASAS ESTÉRILES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Gasas Estériles <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="gasas_esteriles1">SI</label>
                                                <input type="radio" name="gasas_esteriles" id="gasas_esteriles1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="gasas_esteriles2">NO</label>
                                                <input type="radio" name="gasas_esteriles" id="gasas_esteriles2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="gasas_esteriles_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="gasas_esteriles_fv" id="gasas_esteriles_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- ALGODÓN -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Algodón <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="algodon1">SI</label>
                                                <input type="radio" name="algodon" id="algodon1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="algodon2">NO</label>
                                                <input type="radio" name="algodon" id="algodon2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="algodon_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="algodon_fv" id="algodon_fv" value="">
                                            </div>
                                        </div>             
                                    </div> 

                                    <!-- VENDA ELÁSTICA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Venda Elástica <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="venda_elastica1">SI</label>
                                                <input type="radio" name="venda_elastica" id="venda_elastica1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="venda_elastica2">NO</label>
                                                <input type="radio" name="venda_elastica" id="venda_elastica2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="venda_elastica_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="venda_elastica_fv" id="venda_elastica_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- MICROPORE -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Micropore <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="micropore1">SI</label>
                                                <input type="radio" name="micropore" id="micropore1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="micropore2">NO</label>
                                                <input type="radio" name="micropore" id="micropore2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="micropore_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="micropore_fv" id="micropore_fv" value="">
                                            </div>
                                        </div>             
                                    </div> 
                                    
                                    <!-- CURAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Curas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="curas1">SI</label>
                                                <input type="radio" name="curas" id="curas1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="curas2">NO</label>
                                                <input type="radio" name="curas" id="curas2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="curas_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="curas_fv" id="curas_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- BAJALENGUAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Bajalenguas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="bajalengua1">SI</label>
                                                <input type="radio" name="bajalenguas" id="bajalenguas1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="bajalenguas2">NO</label>
                                                <input type="radio" name="bajalenguas" id="bajalenguas2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="bajalenguas_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="bajalenguas_fv" id="bajalenguas_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- GUANTES DE LATEX -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Guantes de Latex <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="guantes_latex_1">SI</label>
                                                <input type="radio" name="guantes_latex" id="guantes_latex1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="guantes_latex2">NO</label>
                                                <input type="radio" name="guantes_latex" id="guantes_latex2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="guantes_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="guantes_fv" id="guantes_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- APLICADORES / COPITOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Aplicadores / Copitos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="copitos1">SI</label>
                                                <input type="radio" name="copitos" id="copitos1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="copitos2">NO</label>
                                                <input type="radio" name="copitos" id="copitos2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="copitos_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="copitos_fv" id="copitos_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- PITO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Pito <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="pito1">SI</label>
                                                <input type="radio" name="pito_botiquin" id="pito1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="alcohol2">NO</label>
                                                <input type="radio" name="pito_botiquin" id="pito2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Bolsas Rojas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="bolsasrojas1">SI</label>
                                                <input type="radio" name="bolsas_rojas" id="bolsasrojas1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="bolsasrojas2">NO</label>
                                                <input type="radio" name="bolsas_rojas" id="bolsasrojas2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- SUERO FIOSOLOGICO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Suero Fisiológico <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="suero1">SI</label>
                                                <input type="radio" name="suero" id="suero1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="suero2">NO</label>
                                                <input type="radio" name="suero" id="suero2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="suero_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="suero_fv" id="suero_fv" value="">
                                            </div>
                                        </div>             
                                    </div> 

                                    <!-- ANTISÉPTICO -->
                                    <!--<div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Antiséptico / Thimerasol <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="antiseptico1">SI</label>
                                                <input type="radio" name="antiseptico" id="antiseptico1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="antiseptico2">NO</label>
                                                <input type="radio" name="antiseptico" id="antiseptico2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="antiseptico_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="antiseptico_fv" id="antiseptico_fv" value="">
                                            </div>
                                        </div>              
                                    </div> -->

                                    <!-- TIJERAS ANTI-TRAUMA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tijeras Anti-trauma (o Punta Roma)<i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="tijeras1">SI</label>
                                                <input type="radio" name="tijeras" id="tijeras1" value="SI" required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="tijeras2">NO</label>
                                                <input type="radio" name="tijeras" id="tijeras2" value="NO" required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="tijeras_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="tijeras_fv" id="tijeras_fv" value="">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- ****************************** -->

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>ELEMENTOS DE TRABAJO</p>
                                    </div>

                                    <!-- ******************************  -->

                                    <!-- ASEO PERSONAL -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Aseo Personal - Uniforme <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="aseo_personal1">SI</label>
                                                <input type="radio" name="aseo_personal" id="aseo_personal1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_personal2">NO</label>
                                                <input type="radio" name="aseo_personal" id="aseo_personal2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- SISTEMA DE COMUNICACIÓN -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Sistema de Comunicación <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="sistema_comunicacion1">SI</label>
                                                <input type="radio" name="sistema_comunicacion" id="sistema_comunicacion1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="sistema_comunicacion2">NO</label>
                                                <input type="radio" name="sistema_comunicacion" id="sistema_comunicacion2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- GPS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>GPS <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="gps1">SI</label>
                                                <input type="radio" name="gps" id="gps1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="gps2">NO</label>
                                                <input type="radio" name="gps" id="gps2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- RUTERO - IMANTADOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Rutero - Imantados <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="rutero1">SI</label>
                                                <input type="radio" name="rutero" id="rutero1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="rutero2">NO</label>
                                                <input type="radio" name="rutero" id="rutero2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- ASEO INTERNO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Aseo Interno del Vehiculo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="aseo_interno1">SI</label>
                                                <input type="radio" name="aseo_interno" id="aseo_interno1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_interno_externo2">NO</label>
                                                <input type="radio" name="aseo_interno" id="aseo_interno2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- ASEO EXTERNO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Aseo Externo del Vehiculo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="aseo_externo1">SI</label>
                                                <input type="radio" name="aseo_externo" id="aseo_externo1" value="SI">
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_externo2">NO</label>
                                                <input type="radio" name="aseo_externo" id="aseo_externo2" value="NO">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                </div>

                            <!-- SEGUNDA SECCIÓN -->
                                <div id="tabs-4" class="p-4">    
                                        
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>ELEMENTOS DEL VEHÍCULO</p>
                                    </div>

                                    <div class="row mt-2 ml-5">
                                        <div class="label col-10" style="text-align:center">
                                            <label><b>Bueno (B) - Regular (R) - Malo (M)</b></label>
                                        </div>
                                    </div>

                                    <!-- LUCES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Luces <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="luces1">B</label>
                                                <input type="radio" name="luces" id="luces1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces2">R</label>
                                                <input type="radio" name="luces" id="luces2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces3">M</label>
                                                <input type="radio" name="luces" id="luces3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_obs" id="luces_obs" value="">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- DIRECCIONALES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Direccionales <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="direccionales1">B</label>
                                                <input type="radio" name="direccionales" id="direccionales1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="direccionales2">R</label>
                                                <input type="radio" name="direccionales" id="direccionales2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="direccionales3">M</label>
                                                <input type="radio" name="direccionales" id="direccionales3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="direccionales_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="direccionales_obs" id="direccionales_obs" value="">
                                            </div>
                                        </div>             
                                    </div>
                                    
                                    <!-- PANORAMICO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Panoramico <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="panoramico1">B</label>
                                                <input type="radio" name="panoramico" id="panoramico1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="panoramico2">R</label>
                                                <input type="radio" name="panoramico" id="panoramico2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="panoramico3">M</label>
                                                <input type="radio" name="panoramico" id="panoramico3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="panoramico_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="panoramico_obs" id="panoramico_obs" value="">
                                            </div>
                                        </div>              
                                    </div>

                                    <!-- LIMPIABRISAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Limpiabrisas: Plumillas y sistema de agua <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="limpiabrisas1">B</label>
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="limpiabrisas2">R</label>
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="limpiabrisas3">M</label>
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="limpiabrisas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="limpiabrisas_obs" id="limpiabrisas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>

                                    <!-- STOPS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Stops <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="stops1">B</label>
                                                <input type="radio" name="stops" id="stops1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="stops2">R</label>
                                                <input type="radio" name="stops" id="stops2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="stops3">M</label>
                                                <input type="radio" name="stops" id="stops3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="stops_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="stops_obs" id="stops_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LUCES INTERNAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Luces internas: pasillos y baños <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="luces_internas1">B</label>
                                                <input type="radio" name="luces_internas" id="luces_internas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_internas2">R</label>
                                                <input type="radio" name="luces_internas" id="luces_internas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_internas3">M</label>
                                                <input type="radio" name="luces_internas" id="luces_internas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_internas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_internas_obs" id="luces_internas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LUCES TABLERO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Luces de tablero: indicadores <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="luces_tablero1">B</label>
                                                <input type="radio" name="luces_tablero" id="luces_tablero1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_tablero2">R</label>
                                                <input type="radio" name="luces_tablero" id="luces_tablero2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_tablero3">M</label>
                                                <input type="radio" name="luces_tablero" id="luces_tablero3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_tablero_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_tablero_obs" id="luces_tablero_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- AIRE ACONDICIONADO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Aire Acondicionado <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="aire_acondicionado1">B</label>
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="aire_acondicionado2">R</label>
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="aire_acondicionado3">M</label>
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="aire_acondicionado_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="aire_acondicionado_obs" id="aire_acondicionado_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- RADIO Y PARLANTES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Radio y Parlantes <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="radio1">B</label>
                                                <input type="radio" name="radio" id="radio1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="radio2">R</label>
                                                <input type="radio" name="radio" id="radio2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="radio3">M</label>
                                                <input type="radio" name="radio" id="radio3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="radio_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="radio_obs" id="radio_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- TELEVISOR -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Televisor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="televisor1">B</label>
                                                <input type="radio" name="televisor" id="televisor1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="televisor2">R</label>
                                                <input type="radio" name="televisor" id="televisor2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="televisor3">M</label>
                                                <input type="radio" name="televisor" id="televisor3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="televisor_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="televisor_obs" id="televisor_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- BOCELES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Boceles <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="boceles1">B</label>
                                                <input type="radio" name="boceles" id="boceles1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="boceles2">R</label>
                                                <input type="radio" name="boceles" id="boceles2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="boceles3">M</label>
                                                <input type="radio" name="boceles" id="boceles3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="boceles_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="boceles_obs" id="boceles_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- ANTENAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Antenas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="antenas1">B</label>
                                                <input type="radio" name="antenas" id="antenas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="antenas2">R</label>
                                                <input type="radio" name="antenas" id="antenas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="antenas3">M</label>
                                                <input type="radio" name="antenas" id="antenas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="antenas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="antenas_obs" id="antenas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- RINES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tapas / Rines <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="rines1">B</label>
                                                <input type="radio" name="rines" id="rines1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="rines2">R</label>
                                                <input type="radio" name="rines" id="rines2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="rines3">M</label>
                                                <input type="radio" name="rines" id="rines3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="rines_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="rines_obs" id="rines_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- AIRBAG -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>AirBag <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="airbag1">B</label>
                                                <input type="radio" name="airbag" id="airbag1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="airbag2">R</label>
                                                <input type="radio" name="airbag" id="airbag2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="airbag3">M</label>
                                                <input type="radio" name="airbag" id="airbag3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="airbag_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="airbag_obs" id="airbag_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- TAPICERIA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tapiceria <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="tapiceria1">B</label>
                                                <input type="radio" name="tapiceria" id="tapiceria1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="tapiceria2">R</label>
                                                <input type="radio" name="tapiceria" id="tapiceria2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="tapiceria3">M</label>
                                                <input type="radio" name="tapiceria" id="tapiceria3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="tapiceria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="tapiceria_obs" id="tapiceria_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- SILLETERIA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Silleteria <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="silleteria1">B</label>
                                                <input type="radio" name="silleteria" id="silleteria1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="silleteria2">R</label>
                                                <input type="radio" name="silleteria" id="silleteria2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="silleteria3">M</label>
                                                <input type="radio" name="silleteria" id="silleteria3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="silleteria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="silleteria_obs" id="silleteria_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- DISPOSITIVO VELOCIDAD -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Dispositivo Velocidad (Sticker Validacion) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="disp_velocidad1">B</label>
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="disp_velocidad2">R</label>
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="disp_velocidad3">M</label>
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="disp_velocidad_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="disp_velocidad_obs" id="disp_velocidad_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- CINTURON SEGURIDAD -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Cinturones de Seguridad <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="cinturon_seguridad1">B</label>
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="cinturon_seguridad2">R</label>
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="cinturon_seguridad3">M</label>
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="cinturon_seguridad_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cinturon_seguridad_obs" id="cinturon_seguridad_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- CORTINAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Cortinas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="cortinas1">B</label>
                                                <input type="radio" name="cortinas" id="cortinas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="cortinas2">R</label>
                                                <input type="radio" name="cortinas" id="cortinas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="cortinas3">M</label>
                                                <input type="radio" name="cortinas" id="cortinas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="cortinas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cortinas_obs" id="cortinas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- SALIDA EMERGENCIA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Salida de Emergencia <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="salida_emergencia1">B</label>
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="salida_emergencia2">R</label>
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="salida_emergencia3">M</label>
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="salida_emergencia_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="salida_emergencia_obs" id="salida_emergencia_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- MARTILLOS FRAGMENTACION -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Martillos de Fragmentación <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="martillos1">B</label>
                                                <input type="radio" name="martillos" id="martillos1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="martillos2">R</label>
                                                <input type="radio" name="martillos" id="martillos2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="martillos3">M</label>
                                                <input type="radio" name="martillos" id="martillos3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="martillos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="martillos_obs" id="martillos_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- ESTADO DEL BAÑO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Estado de Baño <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="estado_bano1">B</label>
                                                <input type="radio" name="estado_bano" id="estado_bano1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="estado_bano2">R</label>
                                                <input type="radio" name="estado_bano" id="estado_bano2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="estado_bano3">M</label>
                                                <input type="radio" name="estado_bano" id="estado_bano3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="estado_bano_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="estado_bano_obs" id="estado_bano_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- VIDRIOS ESPEJOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Vidrios y Espejos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="vidrios1">B</label>
                                                <input type="radio" name="vidrios" id="vidrios1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="vidrios2">R</label>
                                                <input type="radio" name="vidrios" id="vidrios2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="vidrios3">M</label>
                                                <input type="radio" name="vidrios" id="vidrios3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="vidrios_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="vidrios_obs" id="vidrios_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LLANTAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Llantas (que no este lisa) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="llantas1">B</label>
                                                <input type="radio" name="llantas" id="llantas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="llantas2">R</label>
                                                <input type="radio" name="llantas" id="llantas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="llantas3">M</label>
                                                <input type="radio" name="llantas" id="llantas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="llantas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="llantas_obs" id="llantas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LLANTA REPUESTO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Llanta de Repuesto (que no este lisa) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="repuesto1">B</label>
                                                <input type="radio" name="repuesto" id="repuesto1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="repuesto2">R</label>
                                                <input type="radio" name="repuesto" id="repuesto2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="repuesto3">M</label>
                                                <input type="radio" name="repuesto" id="repuesto3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="repuesto_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="repuesto_obs" id="repuesto_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- TAPETES -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tapetes <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="tapetes1">B</label>
                                                <input type="radio" name="tapetes" id="tapetes1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="tapetes2">R</label>
                                                <input type="radio" name="tapetes" id="tapetes2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="tapetes3">M</label>
                                                <input type="radio" name="tapetes" id="tapetes3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="tapetes_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="tapetes_obs" id="tapetes_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- ENCENDEDOR -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Encendedor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="encendedor1">B</label>
                                                <input type="radio" name="encendedor" id="encendedor1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="encendedor2">R</label>
                                                <input type="radio" name="encendedor" id="encendedor2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="encendedor3">M</label>
                                                <input type="radio" name="encendedor" id="encendedor3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="encendedor_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="encendedor_obs" id="encendedor_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- LATONERIA PINTURA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Latoneria y Pintura <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="latoneria1">B</label>
                                                <input type="radio" name="latoneria" id="latoneria1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="latoneria2">R</label>
                                                <input type="radio" name="latoneria" id="latoneria2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="latoneria3">M</label>
                                                <input type="radio" name="latoneria" id="latoneria3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="latoneria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="latoneria_obs" id="latoneria_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- DISTINTIVOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Distintivos normativos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="distintivos1">B</label>
                                                <input type="radio" name="distintivos" id="distintivos1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="distintivos2">R</label>
                                                <input type="radio" name="distintivos" id="distintivos2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="distintivos3">M</label>
                                                <input type="radio" name="distintivos" id="distintivos3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="distintivos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="distintivos_obs" id="distintivos_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- BODEGAS BAUL -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Bodegas y/o Baul <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="bodegas1">B</label>
                                                <input type="radio" name="bodegas" id="bodegas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="bodegas2">R</label>
                                                <input type="radio" name="bodegas" id="bodegas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="bodegas3">M</label>
                                                <input type="radio" name="bodegas" id="bodegas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="bodegas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="bodegas_obs" id="bodegas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- NIVEL FLUIDOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Niveles de Fluidos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="fluidos1">B</label>
                                                <input type="radio" name="fluidos" id="fluidos1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="fluidos2">R</label>
                                                <input type="radio" name="fluidos" id="fluidos2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="fluidos3">M</label>
                                                <input type="radio" name="fluidos" id="fluidos3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="fluidos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="fluidos_obs" id="fluidos_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- PALOMERAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Revisión de Palomeras (sin objetos - solo buses) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="palomeras1">B</label>
                                                <input type="radio" name="palomeras" id="palomeras1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="palomeras2">R</label>
                                                <input type="radio" name="palomeras" id="palomeras2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="palomeras3">M</label>
                                                <input type="radio" name="palomeras" id="palomeras3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="palomeras_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="palomeras_obs" id="palomeras_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- VELOCIDAD MAXIMA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Calcomania Velocidad Maxima <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="calcomania1">B</label>
                                                <input type="radio" name="calcomania" id="calcomania1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="calcomania2">R</label>
                                                <input type="radio" name="calcomania" id="calcomania2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="calcomania3">M</label>
                                                <input type="radio" name="calcomania" id="calcomania3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="calcomania_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="calcomania_obs" id="calcomania_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- COMO CONDUZCO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Como Conduzco Externo e Interno <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="como_conduzco1">B</label>
                                                <input type="radio" name="como_conduzco" id="como_conduzco1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="como_conduzco2">R</label>
                                                <input type="radio" name="como_conduzco" id="como_conduzco2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="como_conduzco3">M</label>
                                                <input type="radio" name="como_conduzco" id="como_conduzco3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="como_conduzco_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="como_conduzco_obs" id="como_conduzco_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- CIERRE PUERTAS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Cierre: Puertas y Manijas <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="cierre_puertas1">B</label>
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="cierre_puertas2">R</label>
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="cierre_puertas3">M</label>
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="cierre_puertas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cierre_puertas_obs" id="cierre_puertas_obs" value="">
                                            </div>
                                        </div>              
                                    </div>

                                </div>

                            <!-- TERCERA SECCIÓN -->
                                <div id="tabs-5" class="p-4">
                                    
                                    <!-- *************************************************** -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
                                        <p>VEHICULO EN MOVIMIENTO</p>
                                    </div>
                                    <!-- *************************************************** -->

                                    <div class="row mt-2 ml-5">
                                        <div class="label col-10" style="text-align:center">
                                            <label><b>Bueno (B) - Regular (R) - Malo (M)</b></label>
                                        </div>
                                    </div>

                                    <!-- SISTEMA FRENOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Sistema de Frenos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="frenos1">B</label>
                                                <input type="radio" name="frenos" id="frenos1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="frenos2">R</label>
                                                <input type="radio" name="frenos" id="frenos2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="frenos3">M</label>
                                                <input type="radio" name="frenos" id="frenos3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="frenos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="frenos_obs" id="frenos_obs" value="">
                                            </div>
                                        </div>              
                                    </div>

                                    <!-- EMBRAGUE -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Embrague <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="embrague1">B</label>
                                                <input type="radio" name="embrague" id="embrague1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="embrague2">R</label>
                                                <input type="radio" name="embrague" id="embrague2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="embrague3">M</label>
                                                <input type="radio" name="embrague" id="embrague3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="embrague_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="embrague_obs" id="embrague_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- SUSPENSION -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Suspensión Delantera y Trasera <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="suspension1">B</label>
                                                <input type="radio" name="suspension" id="suspension1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="suspension2">R</label>
                                                <input type="radio" name="suspension" id="suspension2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="suspension3">M</label>
                                                <input type="radio" name="suspension" id="suspension3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="suspension_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="suspension_obs" id="suspension_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- CAJA CAMBIOS -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Caja de Cambios <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="cambios1">B</label>
                                                <input type="radio" name="cambios" id="cambios1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="cambios2">R</label>
                                                <input type="radio" name="cambios" id="cambios2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="cambios3">M</label>
                                                <input type="radio" name="cambios" id="cambios3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="cambios_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cambios_obs" id="cambios_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- PITO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Pito / Pito de Reversa <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="pito1">B</label>
                                                <input type="radio" name="pito" id="pito1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="pito2">R</label>
                                                <input type="radio" name="pito" id="pito2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="pito3">M</label>
                                                <input type="radio" name="pito" id="pito3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="pito_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="pito_obs" id="pito_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- BATERIA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Estado de la Bateria <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="bateria1">B</label>
                                                <input type="radio" name="bateria" id="bateria1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="bateria2">R</label>
                                                <input type="radio" name="bateria" id="bateria2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="bateria3">M</label>
                                                <input type="radio" name="bateria" id="bateria3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="bateria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="bateria_obs" id="bateria_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- FRENO PARQUEO -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Freno de Parqueo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="freno_mano1">B</label>
                                                <input type="radio" name="freno_mano" id="freno_mano1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="freno_mano2">R</label>
                                                <input type="radio" name="freno_mano" id="freno_mano2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="freno_mano3">M</label>
                                                <input type="radio" name="freno_mano" id="freno_mano3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="freno_mano_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="freno_mano_obs" id="freno_mano_obs" value="">
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <!-- DIRECCION -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Dirección <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="direccion1">B</label>
                                                <input type="radio" name="direccion" id="direccion1" value="B">
                                            </div>
                                            <div class="col-2">
                                                <label for="direccion2">R</label>
                                                <input type="radio" name="direccion" id="direccion2" value="R">
                                            </div>
                                            <div class="col-2">
                                                <label for="direccion3">M</label>
                                                <input type="radio" name="direccion" id="direccion3" value="M">
                                            </div>
                                            <div class="col-6">
                                                <label for="direccion_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="direccion_obs" id="direccion_obs" value="">
                                            </div>
                                        </div>              
                                    </div>

                                </div>

                            <!-- QUINTA SECCIÓN -->
                                <div id="tabs-6" class="p-4">
                                    
                                    <!-- DAÑOS -->
                                        <div class="row mt-5 ml-5">
                                            <div class="label">
                                                <label>Novedades <b>(Rayones, Abolladuras, Golpes, etc)</b> <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <textarea name="novedades_danios" id="novedades_danios" class="form-control col-12"></textarea>
                                            </div>              
                                        </div>

                                    <!-- OBSERVACIONES -->
                                    
                                        <div class="row mt-5 ml-5">
                                            <div class="label">
                                                <label>Observaciones <b>(Describir cualquier condición anormal encontrada hasta la fecha)</b></label>
                                            </div>
                                            <div class="input">
                                                <textarea name="observaciones" id="observaciones" class="form-control col-12"></textarea>
                                            </div>              
                                        </div>
                                        
                                    <!-- EVIDENCIAS -->  
                                    
                                    <div class="row mt-5 ml-5">
                                            <div class="label">
                                                <label>Evidencias <b>(Fotos o Video de la inspección) (MAX 10 Fotos o 2 Videos)</b></label>
                                            </div>
                                            <div class="input">
                                                <input type="file" multiple name="evidencias[]" id="evidencias" class="form-control col-12">
                                            </div>              
                                        </div>
                                        
                                    <!-- OBSERVACIONES -->
                                    
                                        <div class="row mt-5 ml-5" style="display:none" id="obs_entrega">
                                            <div class="label">
                                                <label>Observaciones Entrega</label>
                                            </div>
                                            <div class="input">
                                                <textarea name="observaciones_entrega" id="observaciones_entrega" class="form-control col-12"></textarea>
                                            </div>              
                                        </div>

                                </div>

                        </div>

                        <!-- BOTONES -->
                            <section class="col-12 mt-5 d-flex justify-content-center">
                                <!-- CANCELAR REGISTRO -->
                                    <a href="inspeccionVehicular.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                                <!-- REGISTRAR -->
                                    <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Registrar</button>
                            </section>
                    </form>
                </div>
            </section>

        </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
  <script>
        $(function() {
            $("#tabs").tabs();
        }); 

        $(function() {
            $("#fecha_proximo_mtto").datepicker({dateFormat:'yy-mm-dd'});
            $("#fecha_lic_conductor").datepicker({dateFormat:'yy-mm-dd'});
            $("#tarjeta_propiedad_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#tarjeta_operacion_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#soat_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#poliza_extra_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#tecnomecanica_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#preventiva_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#fuec_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#disp_velocidad_fv").datepicker({dateFormat:'yy-mm-dd'});
            
            $("#licencia_transito_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#licencia_conduccion_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#seguridad_social_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#extintor_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#gasas_esteriles_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#algodon_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#venda_elastica_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#micropore_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#curas_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#bajalenguas_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#guantes_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#copitos_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#alcohol_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#suero_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#antiseptico_fv").datepicker({dateFormat:'yy-mm-dd'});
            $("#tijeras_fv").datepicker({dateFormat:'yy-mm-dd'});
            
        });

        function validarTipoVehiculo(val){

            const parametros = {
                "id_vehiculo" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/validarTipoVehiculoInspeccion.php',
                type:  'POST',
                beforeSend: function () {
                    $("#img_danios_observados").val("");
                },
                success:  function (response) {
                    $("#img_danios_observados").html(response);                  
                }
            });

        }
        
        function traer_datos_veh(val){
            const parametros = {
                "id_vehiculo" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/traerDatosVehiculo.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    var data = response.split('|');
                    if(data.length > 0){
                        document.getElementById('placa').value = data[0];
                        document.getElementById('movil').value = data[1];
                        document.getElementById('cantidad').value = data[2];
                        document.getElementById('modelo').value = data[3];
                        document.getElementById('tipo_vehiculo').value = data[4];
                        document.getElementById('tipo_combustible').value = data[5];
                    } else {
                        document.getElementById('placa').value = '';
                        document.getElementById('movil').value = '';
                        document.getElementById('cantidad').value = '';
                        document.getElementById('modelo').value = '';
                        document.getElementById('tipo_vehiculo').value = '';
                        document.getElementById('tipo_combustible').value = '';
                    }
                }
            });
        }
        
        function traer_datos_cond(val){
            const parametros = {
                "id_conductor" : val
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/traerDatosConductor.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    var data = response.split('|');
                    if(data.length > 0){
                        document.getElementById('nombre_conductor').value = data[0];
                        document.getElementById('num_doc_conductor').value = data[1];
                        document.getElementById('num_lic_conductor').value = data[2];
                        document.getElementById('tel_conductor').value = data[3];
                        document.getElementById('fecha_lic_conductor').value = data[4];
                    } else {
                        document.getElementById('nombre_conductor').value = '';
                        document.getElementById('num_doc_conductor').value = '';
                        document.getElementById('num_lic_conductor').value = '';
                        document.getElementById('tel_conductor').value = '';
                        document.getElementById('fecha_lic_conductor').value = '';
                    }
                }
            });
        }
        
    function entrega(val){
        if(val == 'SI'){
            document.getElementById('obs_entrega').style.display = "flex";
        } else {
            document.getElementById('obs_entrega').style.display = "none";
        }
    }
    function existe_veh(val){
        if(val == 'SI'){
            document.getElementById('vehiculo_existe').style.display = "flex";
        } else {
            document.getElementById('vehiculo_existe').style.display = "none";
            document.getElementById('placa').value = '';
            document.getElementById('movil').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('tipo_vehiculo').value = '';
            document.getElementById('tipo_combustible').value = '';
        }
    }
    function existe_cond(val){
        if(val == 'SI'){
            document.getElementById('conductor_existe').style.display = "flex";
        } else {
            document.getElementById('conductor_existe').style.display = "none";
            document.getElementById('nombre_conductor').value = '';
            document.getElementById('num_doc_conductor').value = '';
            document.getElementById('num_lic_conductor').value = '';
            document.getElementById('tel_conductor').value = '';
            document.getElementById('fecha_lic_conductor').value = '';
        }
    }
  </script>
  <!-- FIN SCRIPTS -->

</body>
</html>