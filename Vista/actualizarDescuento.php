<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Cartera.php';
require_once("../Modelo/ConceptosCobro.php");

$vehiculo = new Vehiculo();
$listarVehiculosVinculados = $vehiculo->listarVehiculosVinculados();

$conceptoCobro = new ConceptoCobro();
$listarConceptos = $conceptoCobro->listar();

$cartera = new Cartera();
$listarDescuentosCarteraPorId = $cartera->listarDescuentosCarteraPorId($_GET['id_descuento']);


/* VARIABLES MENU*/
$titulo = 'Registrar Actas';
$redireccion = 'actas.php';
$icono = 'fa fa-file-text';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Actas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="descuentosCartera.php">Descuentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Descuentos</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarDescuentoCartera.php" method="POST" onsubmit="return validar()">
				<?php include("Template/header-form.php"); ?> 
				
				    <?php foreach($listarDescuentosCarteraPorId As $ldcpi){ ?>
                
                            <input type="hidden" class="form-control" name="id_descuento" id="id_descuento" value="<?php echo $_GET['id_descuento']; ?>"/>
                            <input type="hidden" class="form-control" name="id_usuario_creador" id="id_usuario_creador" value="<?php echo $ldcpi['id_usuario_creador']; ?>"/>
                            <input type="hidden" class="form-control" name="fecha_creacion_descuento" id="fecha_creacion_descuento" value="<?php echo $ldcpi['fecha_creacion_descuento']; ?>"/>
                            <input type="hidden" class="form-control" name="estado" id="estado" value="<?php echo $ldcpi['estado']; ?>"/>
                     
                            <!--VEHICULO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Vehiculo</label>
		        	                </div>
		        	                <div class="input">
		        	                    <select name="id_vehiculo" id="id_vehiculo" required="required" class="form-control selectpicker" data-live-search="true">
                                            <option class="0">SELECCIONAR</option>
                                            <?php foreach($listarVehiculosVinculados As $lvv){ ?>
                                                <option value="<?php echo $lvv['id_vehiculo'] ?>" <?php if($ldcpi['id_vehiculo'] == $lvv['id_vehiculo']){ ?> selected="selected" <?php }?> ><?php echo $lvv['placa'] . ' | N° MOVIL ' . $lvv['numero_movil'] ?></option>
                                            <?php } ?>
                                        </select>
		        	                </div>      		
		                        </div>
		                        
		                        
		                    <!--CONCEPTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Concepto</label>
		        	                </div>
		        	                <div class="input">
		        	                    <select name="id_concepto" id="id_concepto" class="form-control">
                                            <option>SELECCIONAR</option>
                                            <?php foreach($listarConceptos As $lc){ ?>
                                                <option value="<?php echo $lc['id_concepto']; ?>" <?php if($ldcpi['id_concepto'] == $lc['id_concepto']){ ?> selected="selected" <?php }?>><?php echo $lc['detalle_concepto']; ?></option>
                                            <?php } ?>
                                        </select>
		        	                </div>      		
		                        </div>
		                        
		                    <!--TIPO DESCUENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Tipo Descuento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <select name="tipo_descuento" id="tipo_descuento" class="form-control">
                                            <option value="0">SELECCIONAR</option>
                                            <?php if($ldcpi['tipo_descuento'] == "PORCENTAJE"){ ?>
                                                <option value="PORCENTAJE" selected="selected">PORCENTAJE (%)</option>
                                                <option value="FIJO">VALOR FIJO ($)</option>
                                            <?php } else if($ldcpi['tipo_descuento'] == "FIJO"){ ?>
                                                <option value="PORCENTAJE" >PORCENTAJE (%)</option>
                                                <option value="FIJO" selected="selected">VALOR FIJO ($)</option>
                                            <?php } else { ?>
                                                <option value="0" selected="selected">SELECCIONAR</option>
                                                <option value="PORCENTAJE" >PORCENTAJE (%)</option>
                                                <option value="FIJO">VALOR FIJO ($)</option>
                                            <?php } ?>
                                        </select>
		        	                </div>      		
		                        </div>
		                  
		                           
		                    <!--DESCUENTO-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Descuento</label>
		        	                </div>
		        	                <div class="input">
		        	                    <input type="text" class="form-control" name="descuento" id="descuento" value="<?php echo $ldcpi['descuento']; ?>" />
		        	                </div>      		
		                        </div>
		                        
		                        
		                    <!--PERIODO DE VALIDEZ-->
		                        <div class="row mt-3">
		        	                <div class="label">
		        		                <label>Periodo de Validez</label>
		        	                </div>
		        	                <div class="row d-flex justify-content-center">
		        	                	<div class="col-6">
											 <input type="text" name="fecha_inicial" id="datepicker" class="form-control" required="required" value="<?php echo $ldcpi['fecha_inicial_valido']; ?>">
		        	                	</div>
		        	                	<div class="col-6">
											 <input type="text" name="fecha_final" id="datepicker1" class="form-control" required="required" value="<?php echo $ldcpi['fecha_final_valido']; ?>">
		        	                	</div>
		        	                </div>      		
		                        </div>
		            <?php } ?>    

			    <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$( function() {
            $("#datepicker").datepicker({ dateFormat:'yy-mm-dd'});
            $("#datepicker1").datepicker({ dateFormat:'yy-mm-dd'});
        } );


        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

    </script>
</body>
</html>