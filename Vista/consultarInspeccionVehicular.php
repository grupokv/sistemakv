<?php 
    //include("../Controlador/Sesion/autenticar.php");
    require_once("../Modelo/Usuario.php");
    require_once("../Modelo/InspeccionVehicular.php");
    
    $id = $_GET['id'];
    
    $usuario = new Usuario();
    $inspeccionvehicular = new InspeccionVehicular();

    $datos = $inspeccionvehicular->listarID($id);
    $evidencias = $inspeccionvehicular->listarEvidenciaID($id);
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
                <li class="breadcrumb-item active" aria-current="page">Consultar Inspección</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>CONSULTAR INSPECCIÓN VEHICULAR</strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
                    
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
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="entrega_vehiculo" disabled="disabled" id="entrega_vehiculo" title="SELECCIONAR" required="required" >
                                                <option value="SI" <?php if($datos[0]['entrega_vehiculo'] == 'SI'){ ?> selected="selected" <?php } ?>>SI</option>
                                                <option value="NO" <?php if($datos[0]['entrega_vehiculo'] == 'NO'){ ?> selected="selected" <?php } ?>>NO</option>
                                            </select>
                                        </div>              
                                    
                                        <div class="label col-lg-5 mt-2">
                                            <label>¿El vehiculo ya esta creado en la plataforma? <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 mt-2">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="existe_vehiculo" disabled="disabled" id="existe_vehiculo" title="SELECCIONAR" required="required" >
                                                <option value="SI" <?php if($datos[0]['vehiculo_nuevo'] == 'SI'){ ?> selected="selected" <?php } ?>>SI</option>
                                                <option value="NO" <?php if($datos[0]['vehiculo_nuevo'] == 'NO'){ ?> selected="selected" <?php } ?>>NO</option>
                                            </select>
                                        </div>              
                                    
                                        <div class="label col-lg-5 mt-2">
                                            <label>¿El conductor ya esta creado en la plataforma? <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 mt-2">
                                            <select class="form-control form-control-sm selectpicker" data-live-search="true" name="existe_conductor" disabled="disabled" id="existe_conductor" title="SELECCIONAR" required="required" >
                                                <option value="SI" <?php if($datos[0]['conductor_nuevo'] == 'SI'){ ?> selected="selected" <?php } ?>>SI</option>
                                                <option value="NO" <?php if($datos[0]['conductor_nuevo'] == 'NO'){ ?> selected="selected" <?php } ?>>NO</option>
                                            </select>
                                        </div>
                                        
                                    </div>  

                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Empresa</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control form-control-sm" name="empresa" id="empresa" value="<?php echo $datos[0]['empresa']; ?>" disabled="disabled" >
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Contrato</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" class="form-control form-control-sm" name="contrato" id="contrato" value="<?php echo $datos[0]['contrato']; ?>" disabled="disabled" >
                                        </div>              
                                    </div>

                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Placa <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="placa" id="placa" required="required" value="<?php echo $datos[0]['placa'];?>" disabled="disabled" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Movil <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="movil" id="movil" required="required" value="<?php echo $datos[0]['movil'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Capacidad <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="cantidad" id="cantidad" required="required" value="<?php echo $datos[0]['capacidad'];?>" disabled="disabled" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Modelo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="modelo" id="modelo" required="required" value="<?php echo $datos[0]['modelo'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Tipo Vehiculo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tipo_vehiculo" id="tipo_vehiculo" required="required" value="<?php echo $datos[0]['tipo_vehiculo'];?>" disabled="disabled" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Tipo Combustible <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tipo_combustible" id="tipo_combustible" required="required" value="<?php echo $datos[0]['tipo_combustible'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label">
                                            <label>Nombre Conductor <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input" id="conductores">
                                            <input type="text" name="nombre_conductor" id="nombre_conductor" class="form-control form-control-sm" required="required" value="<?php echo $datos[0]['nombre'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Numero Doc <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="num_doc_conductor" id="num_doc_conductor" required="required" value="<?php echo $datos[0]['num_cedula'];?>" disabled="disabled" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Numero Licencia <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="num_lic_conductor" id="num_lic_conductor" required="required" value="<?php echo $datos[0]['num_licencia'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Celular <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="tel_conductor" id="tel_conductor" required="required" value="<?php echo $datos[0]['celular'];?>" disabled="disabled" />
                                        </div>              
                                    
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Fecha Venc. Licencia <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="fecha_lic_conductor" id="fecha_lic_conductor" required="required" value="<?php echo $datos[0]['fecha_venc_licencia'];?>" disabled="disabled" />
                                        </div>              
                                    </div>
                                    
                                    <!-- NIVEL GASOLINA -->
                                    <div class="row mt-3">
                                        <div class="label">
                                            <label>Nivel de Gasolina <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row">
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor1.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="Empty" disabled="disabled" <?php if($datos[0]['nivel_gasolina'] == 'Empty'){ ?> checked="checked" <?php } ?> >
                                            </div>

                                            <div class="col-2">
                                                <img src="../Resources/images/medidor4.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="1/4" disabled="disabled" <?php if($datos[0]['nivel_gasolina'] == '1/4'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor2.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="1/2" disabled="disabled" <?php if($datos[0]['nivel_gasolina'] == '1/2'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor5.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="small" disabled="disabled" <?php if($datos[0]['nivel_gasolina'] == 'small'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                            
                                            <div class="col-2">
                                                <img src="../Resources/images/medidor3.PNG" alt="Medidor de Gasolina" height="30" width="57">
                                                <input type="radio" name="nivel_gasolina" value="Full" disabled="disabled" <?php if($datos[0]['nivel_gasolina'] == 'Full'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- FECHA PROXIMO MTTO -->
                                    <div class="row mt-2">
                                        
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Kilometraje <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" name="kilometraje" id="kilometraje" class="form-control form-control-sm" required="required" value="<?php echo $datos[0]['kilometraje'];?>" disabled="disabled"/>
                                        </div>   
                                        
                                        <div class="label col-lg-2 col-md-4">
                                            <label>Fecha Proximo Mantenimiento <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input col-lg-3 col-md-6">
                                            <input type="text" name="fecha_proximo_mtto" id="fecha_proximo_mtto" class="form-control form-control-sm" value="<?php echo $datos[0]['fecha_proximo_mtto'];?>" disabled="disabled"/>
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
                                                <label for="tarjeta_propiedad1">Si</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad1" value="SI" disabled="disabled" <?php if($datos[0]['tarjeta_propiedad_veh'] == 'SI'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_propiedad2">No</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad2" value="NO" disabled="disabled" <?php if($datos[0]['tarjeta_propiedad_veh'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_propiedad3">N/A</label>
                                                <input type="radio" name="tarjeta_propiedad" id="tarjeta_propiedad3" value="N/A"  disabled="disabled" <?php if($datos[0]['tarjeta_propiedad_veh'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="tarjeta_propiedad_fv">Fecha Expedición</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tarjeta_propiedad_fv" id="tarjeta_propiedad_fv" disabled="disabled" value="<?php echo $datos[0]['tarjeta_propiedad_fecha'];?>">
                                            </div>
                                        </div>              
                                    </div> -->

                                    <!-- TARJETA DE OPERACIÓN -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tarjeta de Operación <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="tarjeta_operacion1">Si</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion1" value="SI" disabled="disabled" <?php if($datos[0]['tarjeta_operacion'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_operacion2">No</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion2" value="NO" disabled="disabled" <?php if($datos[0]['tarjeta_operacion'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tarjeta_operacion3">N/A</label>
                                                <input type="radio" name="tarjeta_operacion" id="tarjeta_operacion3" value="N/A" disabled="disabled" <?php if($datos[0]['tarjeta_operacion'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="tarjeta_operacion_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tarjeta_operacion_fv" id="tarjeta_operacion_fv" disabled="disabled" value="<?php echo $datos[0]['tarjeta_operacion_fecha'];?>">
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
                                                <label for="soat1">Si</label>
                                                <input type="radio" name="soat" id="soat1" value="SI" disabled="disabled" <?php if($datos[0]['soat'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="soat2">No</label>
                                                <input type="radio" name="soat" id="soat2" value="NO" disabled="disabled" <?php if($datos[0]['soat'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="soat3">N/A</label>
                                                <input type="radio" name="soat" id="soat3" value="N/A" disabled="disabled" <?php if($datos[0]['soat'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="soat_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="soat_fv" id="soat_fv" disabled="disabled" value="<?php echo $datos[0]['soat_fecha'];?>">
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
                                                <label for="polizas_extra_contra1">Si</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra1" value="SI" disabled="disabled" <?php if($datos[0]['polizas_extra_contra'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="polizas_extra_contra2">No</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra2" value="NO" disabled="disabled" <?php if($datos[0]['polizas_extra_contra'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="polizas_extra_contra3">N/A</label>
                                                <input type="radio" name="polizas_extra_contra" id="polizas_extra_contra3" value="N/A" disabled="disabled" <?php if($datos[0]['polizas_extra_contra'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="poliza_extra_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="poliza_extra_fv" id="poliza_extra_fv" disabled="disabled" value="<?php echo $datos[0]['poliza_extra_fecha'];?>">
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
                                                <label for="revision_tecnomecanica1">Si</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica1" value="SI" disabled="disabled" <?php if($datos[0]['rev_tecnomecanica'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_tecnomecanica2">No</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica2" value="NO" disabled="disabled" <?php if($datos[0]['rev_tecnomecanica'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_tecnomecanica3">N/A</label>
                                                <input type="radio" name="revision_tecnomecanica" id="revision_tecnomecanica3" value="N/A" disabled="disabled" <?php if($datos[0]['rev_tecnomecanica'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="tecnomecanica_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="tecnomecanica_fv" id="tecnomecanica_fv" disabled="disabled" value="<?php echo $datos[0]['tecnomecanica_fecha'];?>">
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
                                                <label for="revision_preventiva1">Si</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva1" value="SI" disabled="disabled" <?php if($datos[0]['preventiva'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_preventiva2">No</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva2" value="NO" disabled="disabled" <?php if($datos[0]['preventiva'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="revision_preventiva3">N/A</label>
                                                <input type="radio" name="revision_preventiva" id="revision_preventiva3" value="N/A" disabled="disabled" <?php if($datos[0]['preventiva'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="preventiva_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="preventiva_fv" id="preventiva_fv" disabled="disabled" value="<?php echo $datos[0]['preventiva_fecha'];?>">
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
                                                <label for="fuec1">Si</label>
                                                <input type="radio" name="fuec" id="fuec1" value="SI" disabled="disabled" <?php if($datos[0]['fuec'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="fuec2">No</label>
                                                <input type="radio" name="fuec" id="fuec2" value="NO" disabled="disabled" <?php if($datos[0]['fuec'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="fuec3">N/A</label>
                                                <input type="radio" name="fuec" id="fuec3" value="N/A" disabled="disabled" <?php if($datos[0]['fuec'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="fuec_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="fuec_fv" id="fuec_fv" disabled="disabled" value="<?php echo $datos[0]['fuec_fecha'];?>">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- DISPOSITIVO DE VELOCIDAD -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Dispositivo de Velocidad<i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad1">Si</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad1" value="SI" disabled="disabled" <?php if($datos[0]['dispositivo_velocidad'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad2">No</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad2" value="NO" disabled="disabled" <?php if($datos[0]['dispositivo_velocidad'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="dispositivo_velocidad3">N/A</label>
                                                <input type="radio" name="dispositivo_velocidad" id="dispositivo_velocidad3" value="N/A" disabled="disabled" <?php if($datos[0]['dispositivo_velocidad'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="disp_velocidad_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" name="disp_velocidad_fv" id="disp_velocidad_fv" disabled="disabled" value="<?php echo $datos[0]['disp_velocidad_fecha'];?>">
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
                                                <input type="radio" name="licencia_transito" id="licencia_transito1" value="SI" required="required" disabled="disabled" <?php if($datos[0]['licencia_transito'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_transito2">NO</label>
                                                <input type="radio" name="licencia_transito" id="licencia_transito2" value="NO" required="required" disabled="disabled" <?php if($datos[0]['licencia_transito'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_transito3">N/A</label>
                                                <input type="radio" name="licencia_transito" id="licencia_transito3" value="N/A" required="required" disabled="disabled" <?php if($datos[0]['licencia_transito'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="licencia_transito_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" disabled="disabled" name="licencia_transito_fv" id="licencia_transito_fv" value="<?php echo $datos[0]['licencia_transito_fv'];?>">
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
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion1" value="SI" required="required" disabled="disabled" <?php if($datos[0]['licencia_conduccion'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_conduccion2">NO</label>
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion2" value="NO" required="required" disabled="disabled" <?php if($datos[0]['licencia_conduccion'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="licencia_conduccion3">N/A</label>
                                                <input type="radio" name="licencia_conduccion" id="licencia_conduccion3" value="N/A" required="required" disabled="disabled" <?php if($datos[0]['licencia_conduccion'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="licencia_conduccion_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" disabled="disabled" name="licencia_conduccion_fv" id="licencia_conduccion_fv" value="<?php echo $datos[0]['licencia_conduccion_fv'];?>">
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
                                                <input type="radio" name="seguridad_social" id="seguridad_social1" value="SI" required="required" disabled="disabled" <?php if($datos[0]['seguridad_social'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="seguridad_social2">NO</label>
                                                <input type="radio" name="seguridad_social" id="seguridad_social2" value="NO" required="required" disabled="disabled" <?php if($datos[0]['seguridad_social'] == 'NO'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="seguridad_social3">N/A</label>
                                                <input type="radio" name="seguridad_social" id="seguridad_social3" value="N/A" required="required" disabled="disabled" <?php if($datos[0]['seguridad_social'] == 'N/A'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="seguridad_social_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" disabled="disabled" name="seguridad_social_fv" id="seguridad_social_fv" value="<?php echo $datos[0]['seguridad_social_fv'];?>">
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
                                                <input type="radio" name="gato" id="gato1" value="SI" disabled="disabled" <?php if($datos[0]['gato'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="gato2">NO</label>
                                                <input type="radio" name="gato" id="gato2" value="NO" disabled="disabled" <?php if($datos[0]['gato'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="cruceta" id="cruceta1" value="SI" disabled="disabled" <?php if($datos[0]['cruceta'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="cruceta2">NO</label>
                                                <input type="radio" name="cruceta" id="cruceta2" value="NO" disabled="disabled" <?php if($datos[0]['cruceta'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="seniales_carretera" id="seniales_carretera1" value="SI" disabled="disabled" <?php if($datos[0]['seniales_carretera'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="seniales_carretera2">NO</label>
                                                <input type="radio" name="seniales_carretera" id="seniales_carretera2" value="NO" disabled="disabled" <?php if($datos[0]['seniales_carretera'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="tacos" id="tacos1" value="SI" disabled="disabled" <?php if($datos[0]['tacos'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="tacos2">NO</label>
                                                <input type="radio" name="tacos" id="tacos2" value="NO" disabled="disabled" <?php if($datos[0]['tacos'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="linterna" id="linterna1" value="SI" disabled="disabled" <?php if($datos[0]['linterna'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="linterna2">NO</label>
                                                <input type="radio" name="linterna" id="linterna2" value="NO" disabled="disabled" <?php if($datos[0]['linterna'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="llaves_fijas" id="llaves_fijas1" value="SI" disabled="disabled" <?php if($datos[0]['llaves_fijas'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="llaves_fijas2">NO</label>
                                                <input type="radio" name="llaves_fijas" id="llaves_fijas2" value="NO" disabled="disabled" <?php if($datos[0]['llaves_fijas'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="alicates" id="alicates1" value="SI" disabled="disabled" <?php if($datos[0]['alicates'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="alicates2">NO</label>
                                                <input type="radio" name="alicates" id="alicates2" value="NO" disabled="disabled" <?php if($datos[0]['alicates'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="llave_expansiva" id="llave_expansiva1" value="SI" disabled="disabled" <?php if($datos[0]['llave_expansiva'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="llave_expansiva2">NO</label>
                                                <input type="radio" name="llave_expansiva" id="llave_expansiva2" value="NO" disabled="disabled" <?php if($datos[0]['llave_expansiva'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="destornillador" id="destornillador1" value="SI" disabled="disabled" <?php if($datos[0]['destornillador'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="destornillador2">NO</label>
                                                <input type="radio" name="destornillador" id="destornillador2" value="NO" disabled="disabled" <?php if($datos[0]['destornillador'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="chaleco_reflectivo" id="chaleco_reflectivo1" value="SI" disabled="disabled" <?php if($datos[0]['chaleco_reflectivo'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="chaleco_reflectivo2">NO</label>
                                                <input type="radio" name="chaleco_reflectivo" id="chaleco_reflectivo2" value="NO" disabled="disabled" <?php if($datos[0]['chaleco_reflectivo'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                        </div>              
                                    </div> 

                                    <!-- MARTILLO(S) DE FRAGMENTACIÓN -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Martillos de Fragmentación <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-5">
                                                <label for="martillo_frag1">SI</label>
                                                <input type="radio" name="martillo_frag" id="martillo_frag1" value="SI" disabled="disabled" <?php if($datos[0]['martillo_frag'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="martillo_frag2">NO</label>
                                                <input type="radio" name="martillo_frag" id="martillo_frag2" value="NO" disabled="disabled" <?php if($datos[0]['martillo_frag'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="extintor" id="extintor2" value="SI" disabled="disabled" <?php if($datos[0]['extintor'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="extintor3">NO</label>
                                                <input type="radio" name="extintor" id="extintor3" value="NO" disabled="disabled" <?php if($datos[0]['extintor'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" disabled="disabled" name="extintor_cap" id="extintor_cap" value="<?php echo $datos[0]['extintor_cap'];?>">
                                            </div>
                                            <div class="col-5">
                                                <label for="extintor_fv">Fecha Vencimiento</label>
                                                <input class="form-control form-control-sm col-5" style="float:right" type="text" disabled="disabled" name="extintor_fv" id="extintor_fv" value="<?php echo $datos[0]['extintor_fv'];?>">
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
                                                <input type="radio" name="gasas_esteriles" id="gasas_esteriles1" value="SI" disabled="disabled" <?php if($datos[0]['gasas_esteriles'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="gasas_esteriles2">NO</label>
                                                <input type="radio" name="gasas_esteriles" id="gasas_esteriles2" value="NO" disabled="disabled" <?php if($datos[0]['gasas_esteriles'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="gasas_esteriles_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" disabled="disabled" name="gasas_esteriles_fv" id="gasas_esteriles_fv" value="<?php echo $datos[0]['gasas_esteriles_fv'];?>">
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
                                                <input type="radio" name="algodon" id="algodon1" value="SI" disabled="disabled" <?php if($datos[0]['algodon'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="algodon2">NO</label>
                                                <input type="radio" name="algodon" id="algodon2" value="NO" disabled="disabled" <?php if($datos[0]['algodon'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="algodon_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="algodon_fv" id="algodon_fv" value="<?php echo $datos[0]['algodon_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="venda_elastica" id="venda_elastica1" value="SI" disabled="disabled" <?php if($datos[0]['venda_elastica'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="venda_elastica2">NO</label>
                                                <input type="radio" name="venda_elastica" id="venda_elastica2" value="NO" disabled="disabled" <?php if($datos[0]['venda_elastica'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="venda_elastica_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="venda_elastica_fv" id="venda_elastica_fv" value="<?php echo $datos[0]['venda_elastica_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="micropore" id="micropore1" value="SI" disabled="disabled" <?php if($datos[0]['micropore'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="micropore2">NO</label>
                                                <input type="radio" name="micropore" id="micropore2" value="NO" disabled="disabled" <?php if($datos[0]['micropore'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="micropore_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="micropore_fv" id="micropore_fv" value="<?php echo $datos[0]['micropore_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="curas" id="curas1" value="SI" disabled="disabled" <?php if($datos[0]['curas'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="curas2">NO</label>
                                                <input type="radio" name="curas" id="curas2" value="NO" disabled="disabled" <?php if($datos[0]['curas'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="curas_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="curas_fv" id="curas_fv" value="<?php echo $datos[0]['curas_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="bajalenguas" id="bajalenguas1" value="SI" disabled="disabled" <?php if($datos[0]['bajalenguas'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="bajalenguas2">NO</label>
                                                <input type="radio" name="bajalenguas" id="bajalenguas2" value="NO" disabled="disabled" <?php if($datos[0]['bajalenguas'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="bajalenguas_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="bajalenguas_fv" id="bajalenguas_fv" value="<?php echo $datos[0]['bajalenguas_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="guantes_latex" id="guantes_latex1" value="SI" disabled="disabled" <?php if($datos[0]['guantes_latex'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="guantes_latex2">NO</label>
                                                <input type="radio" name="guantes_latex" id="guantes_latex2" value="NO" disabled="disabled" <?php if($datos[0]['guantes_latex'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="guantes_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="guantes_fv" id="guantes_fv" value="<?php echo $datos[0]['guantes_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="copitos" id="copitos1" value="SI" disabled="disabled" <?php if($datos[0]['copitos'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="copitos2">NO</label>
                                                <input type="radio" name="copitos" id="copitos2" value="NO" disabled="disabled" <?php if($datos[0]['copitos'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="copitos_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="copitos_fv" id="copitos_fv" value="<?php echo $datos[0]['copitos_fv'];?>" disabled="disabled">
                                            </div>
                                        </div>              
                                    </div> 
                                    
                                    <!-- ALCOHOL -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Pito <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="pitobotiquin1">SI</label>
                                                <input type="radio" name="pito_botiquin" id="pitobotiquin1" value="SI" disabled="disabled" <?php if($datos[0]['pito_botiquin'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="pitobotiquin2">NO</label>
                                                <input type="radio" name="pito_botiquin" id="pitobotiquin2" value="NO" disabled="disabled" <?php if($datos[0]['pito_botiquin'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="bolsas_rojas" id="bolsasrojas1" value="SI" disabled="disabled" <?php if($datos[0]['bolsas_rojas'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="bolsasrojas2">NO</label>
                                                <input type="radio" name="bolsas_rojas" id="bolsasrojas2" value="NO" disabled="disabled" <?php if($datos[0]['bolsas_rojas'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
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
                                                <input type="radio" name="suero" id="suero1" value="SI" disabled="disabled" <?php if($datos[0]['suero'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="suero2">NO</label>
                                                <input type="radio" name="suero" id="suero2" value="NO" disabled="disabled" <?php if($datos[0]['suero'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="suero_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="suero_fv" id="suero_fv" value="<?php echo $datos[0]['suero_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="antiseptico" id="antiseptico1" value="SI" disabled="disabled" <?php if($datos[0]['antiseptico'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="antiseptico2">NO</label>
                                                <input type="radio" name="antiseptico" id="antiseptico2" value="NO" disabled="disabled" <?php if($datos[0]['antiseptico'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="antiseptico_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="antiseptico_fv" id="antiseptico_fv" value="<?php echo $datos[0]['antiseptico_fv'];?>" disabled="disabled">
                                            </div>
                                        </div>              
                                    </div>-->

                                    <!-- TIJERAS ANTI-TRAUMA -->
                                    <div class="row mt-2 ml-5">
                                        <div class="label">
                                            <label>Tijeras Anti-trauma (o Punta Roma)<i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                        </div>
                                        <div class="input row d-flex justify-content-center">
                                            <div class="col-3">
                                                <label for="tijeras1">SI</label>
                                                <input type="radio" name="tijeras" id="tijeras1" value="SI" disabled="disabled" <?php if($datos[0]['tijeras'] == 'SI'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-3">
                                                <label for="tijeras2">NO</label>
                                                <input type="radio" name="tijeras" id="tijeras2" value="NO" disabled="disabled" <?php if($datos[0]['tijeras'] == 'NO'){ ?> checked="checked" <?php } ?> required="required">
                                            </div>
                                            <div class="col-5">
                                                <label for="tijeras_fv">Vence</label>
                                                <input class="form-control form-control-sm col-9" style="float:right" type="text" name="tijeras_fv" id="tijeras_fv" value="<?php echo $datos[0]['tijeras_fv'];?>" disabled="disabled">
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
                                                <input type="radio" name="aseo_personal" id="aseo_personal1" value="SI" disabled="disabled" <?php if($datos[0]['aseo_personal'] == 'SI'){ ?> checked="checked" <?php } ?> >
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_personal2">NO</label>
                                                <input type="radio" name="aseo_personal" id="aseo_personal2" value="NO" disabled="disabled" <?php if($datos[0]['aseo_personal'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="sistema_comunicacion" id="sistema_comunicacion1" value="SI" disabled="disabled" <?php if($datos[0]['sistema_comunicacion'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-5">
                                                <label for="sistema_comunicacion2">NO</label>
                                                <input type="radio" name="sistema_comunicacion" id="sistema_comunicacion2" value="NO" disabled="disabled" <?php if($datos[0]['sistema_comunicacion'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="gps" id="gps1" value="SI" disabled="disabled" <?php if($datos[0]['gps'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-5">
                                                <label for="gps2">NO</label>
                                                <input type="radio" name="gps" id="gps2" value="NO" disabled="disabled" <?php if($datos[0]['gps'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="rutero" id="rutero1" value="SI" disabled="disabled" <?php if($datos[0]['rutero'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-5">
                                                <label for="rutero2">NO</label>
                                                <input type="radio" name="rutero" id="rutero2" value="NO" disabled="disabled" <?php if($datos[0]['rutero'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="aseo_interno" id="aseo_interno1" value="SI" disabled="disabled" <?php if($datos[0]['aseo_interno'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_interno_externo2">NO</label>
                                                <input type="radio" name="aseo_interno" id="aseo_interno2" value="NO" disabled="disabled" <?php if($datos[0]['aseo_interno'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="aseo_externo" id="aseo_externo1" value="SI" disabled="disabled" <?php if($datos[0]['aseo_externo'] == 'SI'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-5">
                                                <label for="aseo_externo2">NO</label>
                                                <input type="radio" name="aseo_externo" id="aseo_externo2" value="NO" disabled="disabled" <?php if($datos[0]['aseo_externo'] == 'NO'){ ?> checked="checked" <?php } ?>>
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
                                                <input type="radio" name="luces" id="luces1" value="B" disabled="disabled" <?php if($datos[0]['luces'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces2">R</label>
                                                <input type="radio" name="luces" id="luces2" value="R" disabled="disabled" <?php if($datos[0]['luces'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces3">M</label>
                                                <input type="radio" name="luces" id="luces3" value="M" disabled="disabled" <?php if($datos[0]['luces'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_obs" id="luces_obs" value="<?php echo $datos[0]['luces_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['luces_obs'];?>">
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
                                                <input type="radio" name="direccionales" id="direccionales1" value="B" disabled="disabled" <?php if($datos[0]['direccionales'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="direccionales2">R</label>
                                                <input type="radio" name="direccionales" id="direccionales2" value="R" disabled="disabled" <?php if($datos[0]['direccionales'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="direccionales3">M</label>
                                                <input type="radio" name="direccionales" id="direccionales3" value="M" disabled="disabled" <?php if($datos[0]['direccionales'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="direccionales_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="direccionales_obs" id="direccionales_obs" value="<?php echo $datos[0]['direccionales_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['direccionales_obs'];?>">
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
                                                <input type="radio" name="panoramico" id="panoramico1" value="B" disabled="disabled" <?php if($datos[0]['panoramico'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="panoramico2">R</label>
                                                <input type="radio" name="panoramico" id="panoramico2" value="R" disabled="disabled" <?php if($datos[0]['panoramico'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="panoramico3">M</label>
                                                <input type="radio" name="panoramico" id="panoramico3" value="M" disabled="disabled" <?php if($datos[0]['panoramico'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="panoramico_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="panoramico_obs" id="panoramico_obs" value="<?php echo $datos[0]['panoramico_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['panoramico_obs'];?>">
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
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas1" value="B" disabled="disabled" <?php if($datos[0]['limpiabrisas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="limpiabrisas2">R</label>
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas2" value="R" disabled="disabled" <?php if($datos[0]['limpiabrisas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="limpiabrisas3">M</label>
                                                <input type="radio" name="limpiabrisas" id="limpiabrisas3" value="M" disabled="disabled" <?php if($datos[0]['limpiabrisas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="limpiabrisas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="limpiabrisas_obs" id="limpiabrisas_obs" value="<?php echo $datos[0]['limpiabrisas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['limpiabrisas_obs'];?>">
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
                                                <input type="radio" name="stops" id="stops1" value="B" disabled="disabled" <?php if($datos[0]['stops'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="stops2">R</label>
                                                <input type="radio" name="stops" id="stops2" value="R" disabled="disabled" <?php if($datos[0]['stops'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="stops3">M</label>
                                                <input type="radio" name="stops" id="stops3" value="M" disabled="disabled" <?php if($datos[0]['stops'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="stops_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="stops_obs" id="stops_obs" value="<?php echo $datos[0]['stops_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['stops_obs'];?>">
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
                                                <input type="radio" name="luces_internas" id="luces_internas1" value="B" disabled="disabled" <?php if($datos[0]['luces_internas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_internas2">R</label>
                                                <input type="radio" name="luces_internas" id="luces_internas2" value="R" disabled="disabled" <?php if($datos[0]['luces_internas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_internas3">M</label>
                                                <input type="radio" name="luces_internas" id="luces_internas3" value="M" disabled="disabled" <?php if($datos[0]['luces_internas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_internas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_internas_obs" id="luces_internas_obs" value="<?php echo $datos[0]['luces_internas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['luces_internas_obs'];?>">
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
                                                <input type="radio" name="luces_tablero" id="luces_tablero1" value="B" disabled="disabled" <?php if($datos[0]['luces_tablero'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_tablero2">R</label>
                                                <input type="radio" name="luces_tablero" id="luces_tablero2" value="R" disabled="disabled" <?php if($datos[0]['luces_tablero'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="luces_tablero3">M</label>
                                                <input type="radio" name="luces_tablero" id="luces_tablero3" value="M" disabled="disabled" <?php if($datos[0]['luces_tablero'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="luces_tablero_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="luces_tablero_obs" id="luces_tablero_obs" value="<?php echo $datos[0]['luces_tablero_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['luces_tablero_obs'];?>">
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
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado1" value="B" disabled="disabled" <?php if($datos[0]['aire_acondicionado'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="aire_acondicionado2">R</label>
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado2" value="R" disabled="disabled" <?php if($datos[0]['aire_acondicionado'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="aire_acondicionado3">M</label>
                                                <input type="radio" name="aire_acondicionado" id="aire_acondicionado3" value="M" disabled="disabled" <?php if($datos[0]['aire_acondicionado'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="aire_acondicionado_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="aire_acondicionado_obs" id="aire_acondicionado_obs" value="<?php echo $datos[0]['aire_acondicionado_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['aire_acondicionado_obs'];?>">
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
                                                <input type="radio" name="radio" id="radio1" value="B" disabled="disabled" <?php if($datos[0]['radio'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="radio2">R</label>
                                                <input type="radio" name="radio" id="radio2" value="R" disabled="disabled" <?php if($datos[0]['radio'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="radio3">M</label>
                                                <input type="radio" name="radio" id="radio3" value="M" disabled="disabled" <?php if($datos[0]['radio'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="radio_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="radio_obs" id="radio_obs" value="<?php echo $datos[0]['radio_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['radio_obs'];?>">
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
                                                <input type="radio" name="televisor" id="televisor1" value="B" disabled="disabled" <?php if($datos[0]['televisor'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="televisor2">R</label>
                                                <input type="radio" name="televisor" id="televisor2" value="R" disabled="disabled" <?php if($datos[0]['televisor'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="televisor3">M</label>
                                                <input type="radio" name="televisor" id="televisor3" value="M" disabled="disabled" <?php if($datos[0]['televisor'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="televisor_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="televisor_obs" id="televisor_obs" value="<?php echo $datos[0]['televisor_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['televisor_obs'];?>">
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
                                                <input type="radio" name="boceles" id="boceles1" value="B" disabled="disabled" <?php if($datos[0]['boceles'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="boceles2">R</label>
                                                <input type="radio" name="boceles" id="boceles2" value="R" disabled="disabled" <?php if($datos[0]['boceles'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="boceles3">M</label>
                                                <input type="radio" name="boceles" id="boceles3" value="M" disabled="disabled" <?php if($datos[0]['boceles'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="boceles_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="boceles_obs" id="boceles_obs" value="<?php echo $datos[0]['boceles_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['boceles_obs'];?>">
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
                                                <input type="radio" name="antenas" id="antenas1" value="B" disabled="disabled" <?php if($datos[0]['antenas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="antenas2">R</label>
                                                <input type="radio" name="antenas" id="antenas2" value="R" disabled="disabled" <?php if($datos[0]['antenas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="antenas3">M</label>
                                                <input type="radio" name="antenas" id="antenas3" value="M" disabled="disabled" <?php if($datos[0]['antenas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="antenas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="antenas_obs" id="antenas_obs" value="<?php echo $datos[0]['antenas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['antenas_obs'];?>">
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
                                                <input type="radio" name="rines" id="rines1" value="B" disabled="disabled" <?php if($datos[0]['rines'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="rines2">R</label>
                                                <input type="radio" name="rines" id="rines2" value="R" disabled="disabled" <?php if($datos[0]['rines'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="rines3">M</label>
                                                <input type="radio" name="rines" id="rines3" value="M" disabled="disabled" <?php if($datos[0]['rines'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="rines_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="rines_obs" id="rines_obs" value="<?php echo $datos[0]['rines_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['rines_obs'];?>">
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
                                                <input type="radio" name="airbag" id="airbag1" value="B" disabled="disabled" <?php if($datos[0]['airbag'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="airbag2">R</label>
                                                <input type="radio" name="airbag" id="airbag2" value="R" disabled="disabled" <?php if($datos[0]['airbag'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="airbag3">M</label>
                                                <input type="radio" name="airbag" id="airbag3" value="M" disabled="disabled" <?php if($datos[0]['airbag'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="airbag_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="airbag_obs" id="airbag_obs" value="<?php echo $datos[0]['airbag_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['airbag_obs'];?>">
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
                                                <input type="radio" name="tapiceria" id="tapiceria1" value="B" disabled="disabled" <?php if($datos[0]['tapiceria'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tapiceria2">R</label>
                                                <input type="radio" name="tapiceria" id="tapiceria2" value="R" disabled="disabled" <?php if($datos[0]['tapiceria'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tapiceria3">M</label>
                                                <input type="radio" name="tapiceria" id="tapiceria3" value="M" disabled="disabled" <?php if($datos[0]['tapiceria'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="tapiceria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="tapiceria_obs" id="tapiceria_obs" value="<?php echo $datos[0]['tapiceria_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['tapiceria_obs'];?>">
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
                                                <input type="radio" name="silleteria" id="silleteria1" value="B" disabled="disabled" <?php if($datos[0]['silleteria'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="silleteria2">R</label>
                                                <input type="radio" name="silleteria" id="silleteria2" value="R" disabled="disabled" <?php if($datos[0]['silleteria'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="silleteria3">M</label>
                                                <input type="radio" name="silleteria" id="silleteria3" value="M" disabled="disabled" <?php if($datos[0]['silleteria'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="silleteria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="silleteria_obs" id="silleteria_obs" value="<?php echo $datos[0]['silleteria_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['silleteria_obs'];?>">
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
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad1" value="B" disabled="disabled" <?php if($datos[0]['disp_velocidad'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="disp_velocidad2">R</label>
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad2" value="R" disabled="disabled" <?php if($datos[0]['disp_velocidad'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="disp_velocidad3">M</label>
                                                <input type="radio" name="disp_velocidad" id="disp_velocidad3" value="M" disabled="disabled" <?php if($datos[0]['disp_velocidad'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="disp_velocidad_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="disp_velocidad_obs" id="disp_velocidad_obs" value="<?php echo $datos[0]['disp_velocidad_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['disp_velocidad_obs'];?>">
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
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad1" value="B" disabled="disabled" <?php if($datos[0]['cinturon_seguridad'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cinturon_seguridad2">R</label>
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad2" value="R" disabled="disabled" <?php if($datos[0]['cinturon_seguridad'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cinturon_seguridad3">M</label>
                                                <input type="radio" name="cinturon_seguridad" id="cinturon_seguridad3" value="M" disabled="disabled" <?php if($datos[0]['cinturon_seguridad'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="cinturon_seguridad_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cinturon_seguridad_obs" id="cinturon_seguridad_obs" value="<?php echo $datos[0]['cinturon_seguridad_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['cinturon_seguridad_obs'];?>">
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
                                                <input type="radio" name="cortinas" id="cortinas1" value="B" disabled="disabled" <?php if($datos[0]['cortinas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cortinas2">R</label>
                                                <input type="radio" name="cortinas" id="cortinas2" value="R" disabled="disabled" <?php if($datos[0]['cortinas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cortinas3">M</label>
                                                <input type="radio" name="cortinas" id="cortinas3" value="M" disabled="disabled" <?php if($datos[0]['cortinas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="cortinas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cortinas_obs" id="cortinas_obs" value="<?php echo $datos[0]['cortinas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['cortinas_obs'];?>">
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
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia1" value="B" disabled="disabled" <?php if($datos[0]['salida_emergencia'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="salida_emergencia2">R</label>
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia2" value="R" disabled="disabled" <?php if($datos[0]['salida_emergencia'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="salida_emergencia3">M</label>
                                                <input type="radio" name="salida_emergencia" id="salida_emergencia3" value="M" disabled="disabled" <?php if($datos[0]['salida_emergencia'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="salida_emergencia_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="salida_emergencia_obs" id="salida_emergencia_obs" value="<?php echo $datos[0]['salida_emergencia_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['salida_emergencia_obs'];?>">
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
                                                <input type="radio" name="martillos" id="martillos1" value="B" disabled="disabled" <?php if($datos[0]['martillos'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="martillos2">R</label>
                                                <input type="radio" name="martillos" id="martillos2" value="R" disabled="disabled" <?php if($datos[0]['martillos'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="martillos3">M</label>
                                                <input type="radio" name="martillos" id="martillos3" value="M" disabled="disabled" <?php if($datos[0]['martillos'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="martillos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="martillos_obs" id="martillos_obs" value="<?php echo $datos[0]['martillos_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['martillos_obs'];?>">
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
                                                <input type="radio" name="estado_bano" id="estado_bano1" value="B" disabled="disabled" <?php if($datos[0]['estado_bano'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="estado_bano2">R</label>
                                                <input type="radio" name="estado_bano" id="estado_bano2" value="R" disabled="disabled" <?php if($datos[0]['estado_bano'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="estado_bano3">M</label>
                                                <input type="radio" name="estado_bano" id="estado_bano3" value="M" disabled="disabled" <?php if($datos[0]['estado_bano'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="estado_bano_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="estado_bano_obs" id="estado_bano_obs" value="<?php echo $datos[0]['estado_bano_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['estado_bano_obs'];?>">
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
                                                <input type="radio" name="vidrios" id="vidrios1" value="B" disabled="disabled" <?php if($datos[0]['vidrios'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="vidrios2">R</label>
                                                <input type="radio" name="vidrios" id="vidrios2" value="R" disabled="disabled" <?php if($datos[0]['vidrios'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="vidrios3">M</label>
                                                <input type="radio" name="vidrios" id="vidrios3" value="M" disabled="disabled" <?php if($datos[0]['vidrios'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="vidrios_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="vidrios_obs" id="vidrios_obs" value="<?php echo $datos[0]['vidrios_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['vidrios_obs'];?>">
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
                                                <input type="radio" name="llantas" id="llantas1" value="B" disabled="disabled" <?php if($datos[0]['llantas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="llantas2">R</label>
                                                <input type="radio" name="llantas" id="llantas2" value="R" disabled="disabled" <?php if($datos[0]['llantas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="llantas3">M</label>
                                                <input type="radio" name="llantas" id="llantas3" value="M" disabled="disabled" <?php if($datos[0]['llantas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="llantas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="llantas_obs" id="llantas_obs" value="<?php echo $datos[0]['llantas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['llantas_obs'];?>">
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
                                                <input type="radio" name="repuesto" id="repuesto1" value="B" disabled="disabled" <?php if($datos[0]['repuesto'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="repuesto2">R</label>
                                                <input type="radio" name="repuesto" id="repuesto2" value="R" disabled="disabled" <?php if($datos[0]['repuesto'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="repuesto3">M</label>
                                                <input type="radio" name="repuesto" id="repuesto3" value="M" disabled="disabled" <?php if($datos[0]['repuesto'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="repuesto_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="repuesto_obs" id="repuesto_obs" value="<?php echo $datos[0]['repuesto_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['repuesto_obs'];?>">
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
                                                <input type="radio" name="tapetes" id="tapetes1" value="B" disabled="disabled" <?php if($datos[0]['tapetes'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tapetes2">R</label>
                                                <input type="radio" name="tapetes" id="tapetes2" value="R" disabled="disabled" <?php if($datos[0]['tapetes'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="tapetes3">M</label>
                                                <input type="radio" name="tapetes" id="tapetes3" value="M" disabled="disabled" <?php if($datos[0]['tapetes'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="tapetes_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="tapetes_obs" id="tapetes_obs" value="<?php echo $datos[0]['tapetes_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['tapetes_obs'];?>">
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
                                                <input type="radio" name="encendedor" id="encendedor1" value="B" disabled="disabled" <?php if($datos[0]['encendedor'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="encendedor2">R</label>
                                                <input type="radio" name="encendedor" id="encendedor2" value="R" disabled="disabled" <?php if($datos[0]['encendedor'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="encendedor3">M</label>
                                                <input type="radio" name="encendedor" id="encendedor3" value="M" disabled="disabled" <?php if($datos[0]['encendedor'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="encendedor_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="encendedor_obs" id="encendedor_obs" value="<?php echo $datos[0]['encendedor_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['encendedor_obs'];?>">
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
                                                <input type="radio" name="latoneria" id="latoneria1" value="B" disabled="disabled" <?php if($datos[0]['latoneria'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="latoneria2">R</label>
                                                <input type="radio" name="latoneria" id="latoneria2" value="R" disabled="disabled" <?php if($datos[0]['latoneria'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="latoneria3">M</label>
                                                <input type="radio" name="latoneria" id="latoneria3" value="M" disabled="disabled" <?php if($datos[0]['latoneria'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="latoneria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="latoneria_obs" id="latoneria_obs" value="<?php echo $datos[0]['latoneria_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['latoneria_obs'];?>">
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
                                                <input type="radio" name="distintivos" id="distintivos1" value="B" disabled="disabled" <?php if($datos[0]['distintivos'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="distintivos2">R</label>
                                                <input type="radio" name="distintivos" id="distintivos2" value="R" disabled="disabled" <?php if($datos[0]['distintivos'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="distintivos3">M</label>
                                                <input type="radio" name="distintivos" id="distintivos3" value="M" disabled="disabled" <?php if($datos[0]['distintivos'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="distintivos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="distintivos_obs" id="distintivos_obs" value="<?php echo $datos[0]['distintivos_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['distintivos_obs'];?>">
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
                                                <input type="radio" name="bodegas" id="bodegas1" value="B" disabled="disabled" <?php if($datos[0]['bodegas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="bodegas2">R</label>
                                                <input type="radio" name="bodegas" id="bodegas2" value="R" disabled="disabled" <?php if($datos[0]['bodegas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="bodegas3">M</label>
                                                <input type="radio" name="bodegas" id="bodegas3" value="M" disabled="disabled" <?php if($datos[0]['bodegas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="bodegas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="bodegas_obs" id="bodegas_obs" value="<?php echo $datos[0]['bodegas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['bodegas_obs'];?>">
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
                                                <input type="radio" name="fluidos" id="fluidos1" value="B" disabled="disabled" <?php if($datos[0]['fluidos'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="fluidos2">R</label>
                                                <input type="radio" name="fluidos" id="fluidos2" value="R" disabled="disabled" <?php if($datos[0]['fluidos'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="fluidos3">M</label>
                                                <input type="radio" name="fluidos" id="fluidos3" value="M" disabled="disabled" <?php if($datos[0]['fluidos'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="fluidos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="fluidos_obs" id="fluidos_obs" value="<?php echo $datos[0]['fluidos_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['fluidos_obs'];?>">
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
                                                <input type="radio" name="palomeras" id="palomeras1" value="B" disabled="disabled" <?php if($datos[0]['palomeras'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="palomeras2">R</label>
                                                <input type="radio" name="palomeras" id="palomeras2" value="R" disabled="disabled" <?php if($datos[0]['palomeras'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="palomeras3">M</label>
                                                <input type="radio" name="palomeras" id="palomeras3" value="M" disabled="disabled" <?php if($datos[0]['palomeras'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="palomeras_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="palomeras_obs" id="palomeras_obs" value="<?php echo $datos[0]['palomeras_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['palomeras_obs'];?>">
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
                                                <input type="radio" name="calcomania" id="calcomania1" value="B" disabled="disabled" <?php if($datos[0]['calcomania'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="calcomania2">R</label>
                                                <input type="radio" name="calcomania" id="calcomania2" value="R" disabled="disabled" <?php if($datos[0]['calcomania'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="calcomania3">M</label>
                                                <input type="radio" name="calcomania" id="calcomania3" value="M" disabled="disabled" <?php if($datos[0]['calcomania'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="calcomania_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="calcomania_obs" id="calcomania_obs" value="<?php echo $datos[0]['calcomania_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['calcomania_obs'];?>">
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
                                                <input type="radio" name="como_conduzco" id="como_conduzco1" value="B" disabled="disabled" <?php if($datos[0]['como_conduzco'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="como_conduzco2">R</label>
                                                <input type="radio" name="como_conduzco" id="como_conduzco2" value="R" disabled="disabled" <?php if($datos[0]['como_conduzco'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="como_conduzco3">M</label>
                                                <input type="radio" name="como_conduzco" id="como_conduzco3" value="M" disabled="disabled" <?php if($datos[0]['como_conduzco'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="como_conduzco_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="como_conduzco_obs" id="como_conduzco_obs" value="<?php echo $datos[0]['como_conduzco_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['como_conduzco_obs'];?>">
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
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas1" value="B" disabled="disabled" <?php if($datos[0]['cierre_puertas'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cierre_puertas2">R</label>
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas2" value="R" disabled="disabled" <?php if($datos[0]['cierre_puertas'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cierre_puertas3">M</label>
                                                <input type="radio" name="cierre_puertas" id="cierre_puertas3" value="M" disabled="disabled" <?php if($datos[0]['cierre_puertas'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="cierre_puertas_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cierre_puertas_obs" id="cierre_puertas_obs" value="<?php echo $datos[0]['cierre_puertas_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['cierre_puertas_obs'];?>">
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
                                                <input type="radio" name="frenos" id="frenos1" value="B" disabled="disabled" <?php if($datos[0]['frenos'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="frenos2">R</label>
                                                <input type="radio" name="frenos" id="frenos2" value="R" disabled="disabled" <?php if($datos[0]['frenos'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="frenos3">M</label>
                                                <input type="radio" name="frenos" id="frenos3" value="M" disabled="disabled" <?php if($datos[0]['frenos'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="frenos_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="frenos_obs" id="frenos_obs" value="<?php echo $datos[0]['frenos_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['frenos_obs'];?>">
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
                                                <input type="radio" name="embrague" id="embrague1" value="B" disabled="disabled" <?php if($datos[0]['embrague'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="embrague2">R</label>
                                                <input type="radio" name="embrague" id="embrague2" value="R" disabled="disabled" <?php if($datos[0]['embrague'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="embrague3">M</label>
                                                <input type="radio" name="embrague" id="embrague3" value="M" disabled="disabled" <?php if($datos[0]['embrague'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="embrague_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="embrague_obs" id="embrague_obs" value="<?php echo $datos[0]['embrague_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['embrague_obs'];?>">
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
                                                <input type="radio" name="suspension" id="suspension1" value="B" disabled="disabled" <?php if($datos[0]['suspension'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="suspension2">R</label>
                                                <input type="radio" name="suspension" id="suspension2" value="R" disabled="disabled" <?php if($datos[0]['suspension'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="suspension3">M</label>
                                                <input type="radio" name="suspension" id="suspension3" value="M" disabled="disabled" <?php if($datos[0]['suspension'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="suspension_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="suspension_obs" id="suspension_obs" value="<?php echo $datos[0]['suspension_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['suspension_obs'];?>">
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
                                                <input type="radio" name="cambios" id="cambios1" value="B" disabled="disabled" <?php if($datos[0]['cambios'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cambios2">R</label>
                                                <input type="radio" name="cambios" id="cambios2" value="R" disabled="disabled" <?php if($datos[0]['cambios'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="cambios3">M</label>
                                                <input type="radio" name="cambios" id="cambios3" value="M" disabled="disabled" <?php if($datos[0]['cambios'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="cambios_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="cambios_obs" id="cambios_obs" value="<?php echo $datos[0]['cambios_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['cambios_obs'];?>">
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
                                                <input type="radio" name="pito" id="pito1" value="B" disabled="disabled" <?php if($datos[0]['pito'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="pito2">R</label>
                                                <input type="radio" name="pito" id="pito2" value="R" disabled="disabled" <?php if($datos[0]['pito'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="pito3">M</label>
                                                <input type="radio" name="pito" id="pito3" value="M" disabled="disabled" <?php if($datos[0]['pito'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="pito_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="pito_obs" id="pito_obs" value="<?php echo $datos[0]['pito_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['pito_obs'];?>">
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
                                                <input type="radio" name="bateria" id="bateria1" value="B" disabled="disabled" <?php if($datos[0]['bateria'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="bateria2">R</label>
                                                <input type="radio" name="bateria" id="bateria2" value="R" disabled="disabled" <?php if($datos[0]['bateria'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="bateria3">M</label>
                                                <input type="radio" name="bateria" id="bateria3" value="M" disabled="disabled" <?php if($datos[0]['bateria'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="bateria_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="bateria_obs" id="bateria_obs" value="<?php echo $datos[0]['bateria_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['bateria_obs'];?>">
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
                                                <input type="radio" name="freno_mano" id="freno_mano1" value="B" disabled="disabled" <?php if($datos[0]['freno_mano'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="freno_mano2">R</label>
                                                <input type="radio" name="freno_mano" id="freno_mano2" value="R" disabled="disabled" <?php if($datos[0]['freno_mano'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="freno_mano3">M</label>
                                                <input type="radio" name="freno_mano" id="freno_mano3" value="M" disabled="disabled" <?php if($datos[0]['freno_mano'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="freno_mano_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="freno_mano_obs" id="freno_mano_obs" value="<?php echo $datos[0]['freno_mano_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['freno_mano_obs'];?>">
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
                                                <input type="radio" name="direccion" id="direccion1" value="B" disabled="disabled" <?php if($datos[0]['direccion'] == 'B'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="direccion2">R</label>
                                                <input type="radio" name="direccion" id="direccion2" value="R" disabled="disabled" <?php if($datos[0]['direccion'] == 'R'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-2">
                                                <label for="direccion3">M</label>
                                                <input type="radio" name="direccion" id="direccion3" value="M" disabled="disabled" <?php if($datos[0]['direccion'] == 'M'){ ?> checked="checked" <?php } ?>>
                                            </div>
                                            <div class="col-6">
                                                <label for="direccion_obs">Observaciones</label>
                                                <input class="form-control form-control-sm col-7" style="float:right" type="text" name="direccion_obs" id="direccion_obs" value="<?php echo $datos[0]['direccion_obs'];?>" disabled="disabled" title="<?php echo $datos[0]['direccion_obs'];?>">
                                            </div>
                                        </div>              
                                    </div>

                                </div>

                            <!-- QUINTA SECCIÓN -->
                                <div id="tabs-6" class="p-4">
                                    
                                    <!-- OBSERVACIONES -->
                                        <div class="row mt-2 ml-5">
                                            <div class="label">
                                                <label>Novedades <b>(Rayones, Abolladuras, Golpes, etc)</b> <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label>
                                            </div>
                                            <div class="input">
                                                <textarea name="novedades_danios" id="novedades_danios" class="form-control col-12" disabled="disabled"><?php echo $datos[0]['descripcion_danos_observados'];?></textarea>
                                            </div>              
                                        </div>

                                    <!-- OBSERVACIONES -->
                                    
                                        <div class="row mt-2 ml-5">
                                            <div class="label">
                                                <label>Observaciones <b>(Describir cualquier condición anormal encontrada hasta la fecha)</b></label>
                                            </div>
                                            <div class="input">
                                                <textarea name="observaciones" id="observaciones" class="form-control col-12" disabled="disabled"><?php echo $datos[0]['observaciones'];?></textarea>
                                            </div>              
                                        </div>
                                        
                                    <!-- EVIDENCIAS -->  
                                    
                                    <div class="row mt-2 ml-5">
                                            <div class="label">
                                                <label>Evidencias <b>(Fotos o Video de la inspección) (MAX 10 Fotos o 2 Videos)</b></label>
                                            </div>
                                            <div class="input">
                                                <ul class="ml-5">
                                                    <?php foreach($evidencias as $ev){ ?>
                                                    <li><?php echo $ev['archivo'];?> <a href="../Documentos/Inspeccion/<?php echo $id;?>/<?php echo $ev['archivo'];?>" target="_blank"><i class="fa fa-search"></i></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>              
                                        </div>
                                        
                                        <?php if($datos[0]['entrega_vehiculo'] == 'SI'){ ?>
                                        <div class="row mt-2 ml-5" id="obs_entrega">
                                            <div class="label">
                                                <label>Observaciones Entrega</label>
                                            </div>
                                            <div class="input">
                                                <textarea name="observaciones_entrega" id="observaciones_entrega" class="form-control col-12" disabled="disabled"><?php echo $datos[0]['observaciones_entrega'];?></textarea>
                                            </div>              
                                        </div>
                                        
                                        <div class="row mt-2 ml-5" id="obs_entrega">
                                            <div class="label">
                                                <label>Nombre Quien Entrega</label>
                                            </div>
                                            <div class="input">
                                                <input class="form-control col-12" disabled="disabled" value="<?php echo $datos[0]['entregado_por'];?>">
                                            </div>              
                                        </div>
                                        
                                         <div class="row mt-2 ml-5" id="obs_entrega">
                                            <div class="label">
                                                <label>Firma Quien Entrega</label>
                                            </div>
                                            <div class="input">
                                                <img src="../Documentos/Inspeccion/<?php echo $id;?>/<?php echo $datos[0]['firma_entrega'];?>" width="100%">
                                            </div>              
                                        </div>
                                        
                                        <div class="row mt-2 ml-5" id="obs_entrega">
                                            <div class="label">
                                                <label>Nombre Quien Recibe</label>
                                            </div>
                                            <div class="input">
                                                <input class="form-control col-12" disabled="disabled" value="<?php echo $datos[0]['recibido_por'];?>">
                                            </div>              
                                        </div>
                                        
                                        <div class="row mt-2 ml-5" id="obs_entrega">
                                            <div class="label">
                                                <label>Firma Quien Recibe</label>
                                            </div>
                                            <div class="input">
                                                <img src="../Documentos/Inspeccion/<?php echo $id;?>/<?php echo $datos[0]['firma_recibido'];?>" width="100%">
                                            </div>              
                                        </div>
                                        
                                        <?php } ?>

                                    <div class="row mt-5 ml-5">
                                            <div class="label">
                                                <label>Realizado Por</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" class="form-control col-12" disabled="disabled" value="<?php $datos_usu = $usuario->listarUsuarioPorId($datos[0]['id_usuario_registro']); echo $datos_usu[0]['nombre'];?>">
                                            </div>              
                                        </div>
                                        
                                        <div class="row mt-2 ml-5">
                                            <div class="label">
                                                <label>Fecha y Hora Inspeccion</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" class="form-control col-12" disabled="disabled" value="<?php echo $datos[0]['fecha_registro'];?>">
                                            </div>              
                                        </div>
                                    

                                </div>

                        </div>

                        <!-- BOTONES -->
                            <section class="col-12 mt-5 d-flex justify-content-center">
                                <!-- CANCELAR REGISTRO -->
                                    <a href="inspeccionVehicular.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Volver</a>
                                
                            </section>
                    
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
  </script>
  <!-- FIN SCRIPTS -->

</body>
</html>