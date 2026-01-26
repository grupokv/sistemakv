<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Cliente-Convenio.php");

/* VARIABLES MENU*/

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
	<title>SistemaKV | Generar Convenio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
   
</head>
<body>


    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>



    <section class="home_content">  
    	<div aria-label="breadcrumb" class="mt-1"> 
            <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="convenios.php">Convenios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Convenio</li>
            </ol>
        </div>
        
        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i>REGISTRAR CONVENIO</strong>
        </div>

    <section class="form-usuarios mt-1 mb-4">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/registrarConve.php">	

	                    <!-- Empresa-->

		                    <div class="row mt-5">
		                    	<section class="label">
				     	            <label>Empresa Contratista</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
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
						     	    <select name="id_cliente" id="id_cliente"  class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
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
						     	    <select name="id_ciudad" id="id_ciudad" class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
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
						     	    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true" onchange="listarConductoresPorVehiculo(this.value); ocultarConductoresContratos(); listarContratosPorVehiculo(this.value, 0);">
								        <option value="">SELECCIONAR</option>
								        <?php foreach ($listarV as $lv){ ?>
												<option value="<?php echo $lv['id_vehiculo'] ?>">
								        			<?php echo $lv['placa'] ?>
								        		</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

		                <!-- Conductor -->

		                    <div class="row mt-3 mb-3" id="conductor" style="display: none;" >
		                    	<section class="label">
				     	            <label>Conductores del vehiculo</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_conductor[]" id="id_conductor" class="form-control" multiple="multiple">
								    </select>
				     	        </section>
		                    </div>

		                <!-- Contratos -->

		                    <div class="row mt-3 mb-3" id="contratos" style="display: none;" >
		                    	<section class="label">
				     	            <label>Contratos del vehiculo</label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_contrato[]" id="id_contrato" class="form-control" onchange="validarObjetoContrato(this.value);" multiple="multiple">
								        <option value="">SELECCIONAR</option>
								    </select>
				     	        </section>
		                    </div>

		                    <div class="row mt-3 mb-3" id="ObjContrato" style="display: none;" >
		                    	<section class="label">
				     	            <label>Objeto del Contrato</label>
				     	        </section>
		                    	<section class="input">
						     	    <textarea class="form-control" name="objeto_contrato_conv" id="objeto_contrato_conv"></textarea>
				     	        </section>
		                    </div>

	                    <!-- Fecha Inicio -->
	                    
		                    <div class="row mt-3">
		                    	<section class="label">
		                    	 	<label>Desde: </label>
		                    	</section>
		                    	<section class="input">
		                    	 	<input type="text" name="fecha_inicio_convenio" id="datepicker" class="form-control">
		                    	</section>
		                    </div>

	     	   			<!-- Fecha final -->

		     	   			<div class="row mt-3 mb-5	">
		                    	<section class="label">
		     	                    <label>Hasta: </label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_final_convenio" id="datepicker1" class="form-control">
		     	                </section>
		                    </div>

	                    <section class="col-12 mt-4 d-flex justify-content-center">
	                        <a href="convenios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                        <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
	                    </section>	

	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $( function(){
        });

        $( function() {
	        $( "#datepicker" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        });
	        $( "#datepicker1" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        });
	    } );

        function listarConductoresPorVehiculo(id_vehiculo){
        	//alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarConductoresVehiculo.php',
                type: 'post',
                beforeSend: function () {
                	$("#id_conductor").html('<option value=""> Cargando Conductores</option>');
                },
                success:  function (response) { 
					$('#id_conductor').empty();
                    $("#id_conductor").append(response);
    				$('#id_conductor').trigger("chosen:updated");
  	  				$("#id_conductor").chosen(); 
                }
            })

        }

        function listarContratosPorVehiculo(id_vehiculo, id_contrato){
        	//alert(id_vehiculo);
            var parametros = {
                "id_vehiculo" : id_vehiculo,
                "id_contrato" : id_contrato
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarContratosVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                	$("#id_contrato").html('<option value=""> Cargando Contratos</option>');
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    //alert(response);
					$('#id_contrato').empty();
                    $("#id_contrato").append(response);
    				$('#id_contrato').trigger("chosen:updated");
  	  				$("#id_contrato").chosen(); 
                }
            })

        }

        function ocultarConductoresContratos(){
        	var vehiculo = document.getElementById('vehiculo').value;

        	if (vehiculo == '') {
        		document.getElementById('conductor').style.display = 'none';
        		document.getElementById('contratos').style.display = 'none';
        	}else{
        		document.getElementById('conductor').style.display = 'flex';
        		document.getElementById('contratos').style.display = 'flex';
        	}
        }

        function validarObjetoContrato(id_contrato){

        	var count = $("#id_contrato :selected").length;
        	var parametros = {
                "id_contrato" : id_contrato,
                "cantContratos" : count,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/listarObjetoPorContratoVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                	$("#objeto_contrato_conv").html('Cargando, por favor espere..');
                },
                success:  function (response) { 
                    //alert(response);
                    document.getElementById("ObjContrato").style.display = 'flex';
                    $("#objeto_contrato_conv").html(response);
                }
            });
        }



	</script>
	
</body>
</html>