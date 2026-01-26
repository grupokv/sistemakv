<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/contratoOcasional.php");
require_once("../Modelo/Contrato.php");

$id_responsable = $_SESSION['id_usuario'];


/* VARIABLES MENU*/
$titulo = 'Agregar detalle flota propia';
$redireccion = 'filtroFlotaPropia.php';
$icono = 'fa fa-file-text-o';

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarVehiculoFlotaPropia();

$contratoFijo = new Contrato();
$listarCF = $contratoFijo->listarTodos();

$contratoOcasional = new ContratoOcasional();
$listarCO = $contratoOcasional->listar();

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Agregar Descuentos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="filtroFlotaPropia.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarFlotaPropia.php">
	            	    <?php include("Template/header-form.php"); ?>

	            	    <input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $id_responsable ?>" class="form-control">
			        	
			            <hr>

			            <!-- Tipo de contratos-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>¿A que contrato pertenecera?</label>
				     	        </section>
		                    	<section class="input">
                                        <select class="form-control" name="tipo_contrato" id="tipo_contrato" onchange ="contratos()">
                                        	<option value="0">Seleccionar</option>
                                        	<option value="1">Contrato Ocasional</option>
                                        	<option value="2">Contrato Fijo</option>
                                        </select>
				     	        </section>
		                    </div>


		                <!-- Contrato Ocasional-->

		                    <div class="row mt-3" id="ocasional" style="display: none;">
		                    	<section class="label">
				     	            <label>Contratos Ocasionales</label>
				     	        </section>
		                    	<section class="input">
                                        <select class="form-control" name="id_contrato_ocasional" id="id_contrato_ocasional">
                                        	<option value="0">Seleccionar</option>
                                        	<?php foreach ($listarCO as $lco){ ?>
                                        		<option value="<?php echo $lco['id_contrato_ocasional'] ?>">
                                        			<?php echo $lco['objeto_contrato']; ?>
                                        		</option>
                                        	<?php } ?>
                                        </select>
				     	        </section>
		                    </div>

		                <!-- Contrato Fijo-->

		                    <div class="row mt-3" id="fijo" style="display: none;">
		                    	<section class="label">
				     	            <label>Contratos Fijos</label>
				     	        </section>
		                    	<section class="input">
                                        <select class="form-control" name="id_contrato_fijo" id="id_contrato_fijo">
                                        	<option value="0">Seleccionar</option>
                                        	<?php foreach ($listarCF as $lcf){ ?>
                                        		<option value="<?php echo $lcf['id_contrato'] ?>">
                                        			<?php echo $lcf['objeto_contrato']; ?>
                                        		</option>
                                        	<?php } ?>
                                        </select>
				     	        </section>
		                    </div>

		                <!-- Numero de rercorridos-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Numero de Recorridos</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="number"  name="numero_recorridos" id="numero_recorridos" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Dias laborados-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Dias Laborados Reportados</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="number"  name="dias_laborados" id="dias_laborados" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Dias laborados reportados por el gps-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Dias Laborados Reportados por GPS</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="number"  name="dias_laborados_gps" id="dias_laborados_gps" class="form-control">
				     	        </section>
		                    </div>

		                <!-- Valor generado-->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Valor generado</label>
				     	        </section>
		                    	<section class="input">
                                        <input type="number"  name="valor_generado" id="valor_generado" class="form-control">
				     	        </section>
		                    </div>

	     	   			<!--Fecha movimiento-->

		     	   			<div class="row mt-3 ">
		                    	<section class="label">
		     	                    <label>Fecha del movimiento</label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_movimiento" id="datepicker" class="form-control">
		     	                </section>
		                    </div>

		                <!-- Vehiculo -->

		                    <div class="row mt-3 mb-5 " >
		                    	<section class="label">
				     	            <label>Vehiculo</label>
				     	        </section>
		                    	<section class="input">
						     	    <select class="form-control" name="id_vehiculo" id="id_vehiculo" >
						     	    	<option value="0">Seleccionar</option>
									 	<?php foreach ($listarV as $lv){ ?>
									 		<option value="<?php echo $lv['id_vehiculo'] ?>">
									 			<?php echo utf8_encode($lv['placa']); ?>
									 		</option>
									 	<?php } ?>
									</select>
				     	        </section>
		                    </div>
                        <hr>
            
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $( function() {
	        $( "#datepicker" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        });
	    } );

	    function contratos(){
	    	var tipoContrato = document.getElementById('tipo_contrato').value;

            if (tipoContrato == 1) {

            	document.getElementById('fijo').style.display = 'none';
            	document.getElementById('ocasional').style.display = 'flex';
            }else if (tipoContrato == 2) {

            	document.getElementById('ocasional').style.display = 'none';
				document.getElementById('fijo').style.display = 'flex';
            }else{
            	document.getElementById('ocasional').style.display = 'none';
            	document.getElementById('fijo').style.display = 'none';
            }


	    }

	</script>

</body>
</html>