<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Cliente-Convenio.php");

/* VARIABLES MENU*/
$titulo = 'Cargar Convenio';
$redireccion = 'convenios.php';
$icono = 'fa fa-file-text-o';

$empresa = new Empresa();
$listarE = $empresa->listar();

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarActivos();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();

$cliente = new Cliente_Convenio();
$listarCl = $cliente->listar();

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Cargar Convenio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
   
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="convenios.php">Convenio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cargar Convenio</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form action="../Controlador/cargarConvenio.php" method="POST" enctype="multipart/form-data">	
			        <?php include("Template/header-form.php"); ?> 

			        	<!-- Documento-->
		
		                    <div class="row mt-5">
		                    	<section class="label">
				     	            <label>Fotocopia del convenio</label>
				     	        </section>
		                    	<section class="input">
						     	    <input type="file" name="doc_convenio"  id="doc_convenio" class="form-control" >
				     	        </section>
		                    </div>

	                    <!-- Empresa-->
		
		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Empresa Contratista</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_empresa" id="id_empresa" data-live-search="true"  class="form-control selectpicker">
								        <option>SELECCIONAR</option>
								        <?php foreach ($listarE as $le){ ?>
								        	<option value="<?php echo $le['id_empresa'] ?>">
								        		<?php echo $le['nombre_empresa'] ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

		                <!-- Cliente-->

		                    <div class="row  mt-3">
		                    	<section class="label">
				     	            <label>Empresa Colaboradora</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_cliente" id="id_cliente" data-live-search="true" class="form-control selectpicker">
								        <option>SELECCIONAR</option>
								        <?php foreach ($listarCl as $lcl){ ?>
								        	<option value="<?php echo $lcl['id_cliente'] ?>">
								        		<?php echo $lcl['razon_social'] ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

	                    <!-- Ciudad -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label>Ciudad del Convenio</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_ciudad_convenio" id="id_ciudad_convenio" data-live-search="true"  class="form-control selectpicker">
								        <option>SELECCIONAR</option>
								        <?php foreach ($listarC as $lc){ ?>
								        	<option value="<?php echo $lc['id_ciudad'] ?>">
								        		<?php echo $lc['ciudad'] ?>
								        	</option>
								        <?php } ?>
								    </select>
								</section>
		                    </div>

					    <!-- Vehiculo -->

		                    <div class="row mt-3 mb-3" id="vehiculo">
		                    	<section class="label">
				     	            <label>Vehiculo</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true">
								        <option>SELECCIONAR</option>
								        <?php foreach ($listarV as $lv){ 

											$documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
											if (count($documentosvencidosPorId)>0) {?>
												<option value="<?php echo $lv['id_vehiculo'] ?>"disabled style="color:red;font-weight:bolder">
								        			<?php echo $lv['placa'] ?>
								        		</option>
											<?php } else { ?>
												<option value="<?php echo $lv['id_vehiculo'] ?>">
								        			<?php echo $lv['placa'] ?>
								        		</option>
											<?php } ?>
								        	
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

	                    <!--Fecha Inicio-->
	                    
		                    <div class="row mt-3">
		                    	<section class="label">
		                    	 	<label>Desde </label>
		                    	</section>
		                    	<section class="input">
		                    	 	<input type="text" name="fecha_inicio_convenio" id="datepicker" class="form-control">
		                    	</section>
		                    </div>

	     	   			<!--Fecha final-->

		     	   			<div class="row mt-3 mb-5	">
		                    	<section class="label">
		     	                    <label>Hasta: </label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_final_convenio" id="datepicker1" class="form-control">
		     	                </section>
		                    </div>

           					
                        <hr>
            
                        <!--Botones-->

					       
			        <?php include("Template/bottom-form.php"); ?> 
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $( function() {
	        $( "#datepicker" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	        $( "#datepicker1" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });

	    } );

	</script>
	
</body>
</html>