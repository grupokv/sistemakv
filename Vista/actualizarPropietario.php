<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicio.php");
require_once("../Modelo/Propietario.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Ciudad.php");

$tipoVehiculo = new TipoVehiculo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$ciudad = new Ciudad();
$propietario = new Propietario();

$id_propietario = $_GET['id_propietario'];
$listarPropietarioID = $propietario->listarPropietarioID($id_propietario);

$listarTV = $tipoVehiculo->listar();
$listarTipoMoviles = $vehiculo->listarTipoMoviles();
$listarConductores = $conductor->listar();
$listarCiudades = $ciudad->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Vehiculo</title>
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
            border: 0px!important;
        }

        select::-ms-expand { 
    display: none; /* remove default arrow in IE 10 and 11 */
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
                <li class="breadcrumb-item"><a href="vehiculos.php">Propietarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualizar Propietario</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong style="font-size:1.3rem;"><i class="fa fa-user-circle mr-3" style="font-size: 2rem;"></i>ACTUALIZAR PROPIETARIO</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-4">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
    	        <form action="../Controlador/actualizarPropietario.php" method="POST">
                    
                    <?php foreach($listarPropietarioID as $lpi){ ?>
                        <div id="tabs">

                            <ul>
                                <li><a href="#tabs-1">Información </a></li>
                                <li><a href="#tabs-2">Datos Bancarios </a></li>
                            </ul>

                            <!-- INFORMACION BASICA-->

                                <div id="tabs-1" class="p-3">
                                    
                                    <!-- ESTADO -->
                                        <input type="hidden" name="id_propietario" id="id_propietario" class="form-control" value="<?php echo $lpi['id_propietario']; ?>">

                                    <!-- ESTADO -->
                                        <div class="row mt-4">
                                            <div class="label">
                                                <label>Estado</label>
                                            </div>
                                            <div class="input">
                                                <select class="form-control selectpicker form-control-sm selectpicker" data-live-search="true" data-container="body" title="SELECCIONAR" name="estado" id="estado">
                                                    <option value="1" <?php if($lpi['estado'] == 1){ ?> selected="selected" <?php } ?> >ACTIVO</option>
                                                    <option value="0" <?php if($lpi['estado'] == 0){ ?> selected="selected" <?php } ?> >INACTIVO</option>
                                                </select>
                                            </div>      		
                                        </div>  

                                    <!-- TIPO DOCUMENTO -->
                                        <div class="row mt-3">
                                            <div class="label">
                                                <label>Tipo Documento</label>
                                            </div>
                                            <div class="input">
                                                <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm selectpicker" data-live-search="true"  data-container="body" title="SELECCIONAR" required="required">
                                                    <option value="CC" <?php if($lpi['tipo_documento'] == 'CC'){ ?> selected="selected" <?php } ?> >CEDULA DE CIUDADANIA (CC)</option>
                                                    <option value="NIT" <?php if($lpi['tipo_documento'] == 'NIT'){ ?> selected="selected" <?php } ?>>NÚMERO DE IDENTIFICACIÓN TRIBUTARIA (NIT)</option>
                                                    <option value="PASAPORTE" <?php if($lpi['tipo_documento'] == 'PASAPORTE'){ ?> selected="selected" <?php } ?>>PASAPORTE</option>
                                                </select>  
                                            </div>      		
                                        </div>  

                                    <!-- NUMERO DOCUMENTO -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>No. Documento</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="numero_documento" id="numero_documento" class="form-control form-control-sm" value="<?php echo $lpi['numero_documento']?>" required="required" >
                                            </div>      		
                                        </div>

                                    <!-- NOMBRES  -->
                                        <div class="row mt-3">
                                            <div class="label">
                                                <label>Nombre(s) y Apellido(s)</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="nombre" id="nombre" class="form-control form-control-sm" value="<?php echo $lpi['nombre']?>" required="required" >
                                            </div>              
                                        </div>

                                    <!-- CIUDAD -->
                                        <div class="row mt-3 ">
                                            <div class="label">
                                                <label>Ciudad</label>
                                            </div>
                                            <div class="input">
                                                <select  class="form-control form-control-sm selectpicker" data-live-search="true"  data-container="body" title="SELECCIONAR" required="required" name="ciudad" id="ciudad" required="required" >
                                                    <?php foreach($listarCiudades as $lc){ ?>
                                                        <option value="<?php echo $lc['ciudad']; ?>" <?php if($lpi['ciudad'] == $lc['ciudad']){ ?> selected="selected" <?php } ?>><?php echo $lc['ciudad']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>              
                                        </div>

                                    <!--  DIRECCION -->
                                        <div class="row  mt-3 ">
                                            <div class="label">
                                                <label>Dirección</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="direccion" id="direccion" class="form-control form-control-sm"  required="required" value="<?php echo $lpi['direccion']; ?>"/>
                                            </div>      		
                                        </div>

                                    <!--  TELEFONO -->
                                        <div class="row  mt-3  ">
                                            <div class="label">
                                                <label>Teléfono</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="telefono" id="telefono" class="form-control form-control-sm" required="required" value="<?php echo $lpi['telefono']; ?>">
                                            </div>      		
                                        </div>

                                    <!-- CORREO -->
                                        <div class="row mt-3">
                                            <div class="label">
                                                <label>Correo</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="correo" id="correo" class="form-control form-control-sm" required="required" value="<?php echo $lpi['correo']; ?>">
                                            </div>      		
                                        </div>
                                    
                                </div>

                            <!-- DATOS BANCARIOS -->

                                <div id="tabs-2" class="p-3">
                                    
                                    <!-- ENTIDAD BANCARIA -->
                                        <div class="row mt-3 p-2">
                                            <div class="label">
                                                <label>Entidad Bancaria</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="entidad_bancaria" id="entidad_bancaria" class="form-control form-control-sm" value="<?php echo $lpi['entidad_bancaria']; ?>">
                                            </div>              
                                        </div>    

                                    <!-- TITULAR CUENTA -->
                                        <div class="row mt-2 p-2">
                                            <div class="label">
                                                <label>Titular Cuenta</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="titular_cuenta" id="titular_cuenta" class="form-control form-control-sm" value="<?php echo $lpi['titular_cuenta']; ?>">
                                            </div>              
                                        </div>

                                    <!-- CC / NIT -->
                                        <div class="row mt-2 p-2">
                                            <div class="label">
                                                <label>C.C / NIT</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="cc_titular" id="cc_titular" class="form-control form-control-sm" value="<?php echo $lpi['cc_titular']; ?>">
                                            </div>              
                                        </div>
                                    
                                    <!-- TIPO CUENTA -->
                                        <div class="row mt-2 p-2">
                                            <div class="label">
                                                <label>Tipo de Cuenta</label>
                                            </div>
                                            <div class="input">
                                                <select type="text" name="tipo_cuenta" id="tipo_cuenta" class="form-control selectpicker form-control-sm" data-live-search="true" data-container="body" title="SELECCIONAR">
                                                    <option value="AHORROS" <?php if($lpi['tipo_cuenta'] == 'AHORROS'){ ?>selected<?php } ?>>AHORROS</option>
                                                    <option value="CORRIENTE" <?php if($lpi['tipo_cuenta'] == 'CORRIENTE'){ ?>selected<?php } ?>>CORRIENTE</option>
                                                </select>
                                            </div>              
                                        </div>
                                    
                                    <!-- # CUENTA -->
                                        <div class="row mt-2 p-2">
                                            <div class="label">
                                                <label>No. Cuenta</label>
                                            </div>
                                            <div class="input">
                                                <input type="text" name="num_cuenta" id="num_cuenta" class="form-control form-control-sm" value="<?php echo $lpi['num_cuenta']; ?>">
                                                
                                            </div>      		
                                        </div>
                                        
                                </div>

                        </div>
                    <?php } ?>

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

    </script>
    
</body>
</html>