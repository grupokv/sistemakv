<?php 
include ("../Controlador/Sesion/autenticar.php");
include("../Modelo/TipoVehiculo.php");

$tv = new TipoVehiculo();
$listado_tv = $tv->listar();$cantidad = count($listado_tv);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Concepto Cobro</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->

</head>
<body>

    <!-- MENU -->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!-- FIN MENU -->

    <!-- ************************************ -->

    <!-- CONTENIDO -->

        <section class="home_content">

        	<div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="conceptos_cobro.php">Conceptos Cobro</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registrar</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-money mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR CONCEPTO COBRO</b></strong>
            </div>

            <section class="form-usuarios">
                <div class="formulario mb-5">
        	        <form action="../Controlador/registrarConceptoCobro.php" method="POST">

                        <!-- DETALLE - NOMBRE CONCEPTO -->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Detalle</label>
                                </div>
                                <div class="input">
                                    <input class="form-control" name="detalle" id="detalle" required="required" type="text">
                                </div>
                            </div>	
                                
                        <!-- CUENTA PUC-->
                            <div class="row mt-3 mb-4">                            
                                <div class="label">                                
                                    <label>Cuenta PUC</label>                            
                                </div>                            
                                <div class="input">                                
                                    <input class="form-control" name="cuentapuc" id="cuentapuc" required="required" type="number">                            
                                </div>                        
                            </div>	
                             
                        <!-- CONTRACUENTA PUC -->   
                            <div class="row mt-3 mb-4">                            
                                <div class="label">                                
                                    <label>Contracuenta PUC</label>                            
                                </div>                          
                                <div class="input">                                
                                    <input class="form-control" name="contrapuc" id="contrapuc" required="required" type="number">                            
                                </div>                        
                            </div>			

                        <!-- FECHA ACTIVACIÓN -->
                                <div class="row mt-3 mb-4">                            
                                    <div class="label">                                
                                        <label>Siguiente Fecha</label>                            
                                    </div>                            
                                    <div class="input">                                
                                        <input class="form-control" name="fecha" id="fecha" type="date" min="<?php echo date('Y-m-d');?>">                            
                                    </div>                        
                                </div>
                                
                        <!-- ESTADO -->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Estado</label>
                                </div>
                                <div class="input">
                                    <select name="estado" id="estado" class="form-control selectpicker" data-live-search="true" required="required">				
                                        <option value="">SELECCIONAR</option>				
                                        <option value="1">Activo</option>				
                                        <option value="0">Inactivo</option>				
                                    </select>
                                </div>
                            </div>			
                                
                        <!-- FRECUENCIA -->
                                <div class="row mt-3 mb-4">                            
                                    <div class="label">                                
                                        <label>Frecuencia</label>                            
                                    </div>                            
                                    <div class="input">                                
                                        <select name="frecuencia" id="frecuencia" class="form-control selectpicker" data-live-search="true" required="required">
                                            <option value="">SELECCIONAR</option>				
                                            <option value="N">NINGUNA</option>				
                                            <option value="M">MENSUAL</option>				
                                            <option value="A">ANUAL</option>				
                                        </select>                            
                                    </div>                        
                                </div>
                                

                        <!-- BOTONES -->
                                <section class="col-12 mt-5 d-flex justify-content-center">
                          
                                    <!-- CANCELAR REGISTRO -->
                                        <a href="activar_cobro.php" class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>
                                  
                                    <!-- REGISTRAR -->
                                        <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Activar</button>
                              
                                </section>
        	        </form>
                </div>
            </section>

            conceptos_cobro


    <?php include("Template/scripts.php"); ?>
</body>
</html>