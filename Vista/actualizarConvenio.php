<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/Convenio.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Convenios';
$redireccion = 'convenios.php';
$icono = 'fa fa-file-text-o';

$id_convenio = $_GET['id_convenio'];

$empresa = new Empresa();
$listarE = $empresa->listar();

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listar();

$ciudad = new Ciudad();
$listarC = $ciudad->listar();

$cliente = new Cliente_Convenio();
$listarCl = $cliente->listar();

$convenio = new Convenio();
$listarConvenioPorId = $convenio->listarId($id_convenio);

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Convenio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
  	<!-- STYLES -->
	    <?php include("Template/styles.php"); ?>
	    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  	<!--FIN STYLES -->
   
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
	            <li class="breadcrumb-item active" aria-current="page">Actualizar Convenio</li>
	         </ol>
	    </div>

      	<div class="notice notice-sistemakv">
          	<strong><i class="fa fa-car mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR CONVENIOS</b></strong>
      	</div>


	    <section class="form-usuarios mt-1">
	        <div class="formulario mb-5">
	            <form method="POST" action="../Controlador/actualizarConvenios.php">	
					<?php foreach ($listarConvenioPorId as $lcpi){ 
							$listarConductorPorVehiculo = $vehiculo->listarConductoresPorId($lcpi['id_vehiculo']);

							$conds = array();
							$conductores = explode(",", $lcpi['id_conductor']);
							
						?>

						<!-- ID CONVENIO -->

							<input type="hidden" name="id_convenio" id="id_convenio" value="<?php echo $lcpi['id_convenio']; ?>">

						<!-- FECHA CREACIÓN -->

							<input type="hidden" name="fecha_creacion_convenio" id="fecha_creacion_convenio" value="<?php echo $lcpi['fecha_creacion_convenio']; ?>">

						<!-- HORA CREACIÓN -->

							<input type="hidden" name="hora_creacion_convenio" id="hora_creacion_convenio" value="<?php echo $lcpi['hora_creacion_convenio']; ?>">

						<!-- RESPONSABLE-->

							<input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $lcpi['id_responsable']; ?>">

						<!-- EMPRESA-->

		                    <div class="row mt-5">
		                    	<section class="label">
				     	            <label><b>Empresa Contratista</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
								        <?php foreach ($listarE as $le){ ?>
								        	<option value="<?php echo $le['id_empresa']; ?>" <?php if($le['id_empresa'] == $lcpi['id_empresa']){ ?> selected = "selected" <?php } ?> >
								        		<?php echo $le['nombre_empresa'] ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

						<!-- CLIENTE -->

		                    <div class="row  mt-3">
		                    	<section class="label">
				     	            <label><b>Empresa Colaboradora</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
								        <?php foreach ($listarCl as $lcl){ ?>
								        	<option value="<?php echo $lcl['id_cliente'] ?>" <?php if($lcpi['id_cliente'] == $lcl['id_cliente']){ ?> selected = "selected" <?php } ?>>
								        		<?php echo $lcl['razon_social'];
								        		 ?>
								        	</option>
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

		                <!-- CIUDAD -->

		                    <div class="row mt-3">
		                    	<section class="label">
				     	            <label><b>Ciudad del Convenio</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_ciudad" id="id_ciudad" class="form-control selectpicker" data-live-search="true">
								        <option value="">SELECCIONAR</option>
								        <?php foreach ($listarC as $lc){ ?>
								        	<option value="<?php echo $lc['id_ciudad'] ?>" <?php if($lcpi['id_ciudad_convenio'] == $lc['id_ciudad']) { ?> selected = "selected" <?php } ?>>
								        		<?php echo $lc['ciudad'] ?>
								        	</option>
								        <?php } ?>
								    </select>
								</section>
		                    </div>

		                <!-- VEHÍCULO -->

		                    <div class="row mt-3 mb-3" id="vehiculo">
		                    	<section class="label">
				     	            <label><b>Vehiculo</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_vehiculo" id="id_vehiculo" class="form-control selectpicker" data-live-search="true" onchange="listarConductoresPorVehiculo(this.value, 0); listarContratosPorVehiculo(this.value, 0);">
								        <option value="">SELECCIONAR</option>
								        <?php foreach ($listarV as $lv){ 

											$documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
											if (count($documentosvencidosPorId)>0) {?>
												<option value="<?php echo $lv['id_vehiculo'] ?>"disabled style="color:red;font-weight:bolder" <?php if($lcpi['id_vehiculo'] == $lv['id_vehiculo']) { ?> selected="selected" <?php } ?>>
								        			<?php echo $lv['placa'] ?>
								        		</option>
											<?php } else { ?>
												<option value="<?php echo $lv['id_vehiculo'] ?>" <?php if($lcpi['id_vehiculo'] == $lv['id_vehiculo']) { ?> selected="selected" <?php } ?>>
								        			<?php echo $lv['placa'] ?>
								        		</option>
											<?php } ?>
								        	
								        <?php } ?>
								    </select>
				     	        </section>
		                    </div>

		                <!-- CONDUCTOR -->

		                    <div class="row mt-3 mb-3" id="conductor">
		                    	<section class="label">
				     	            <label><b>Conductores del vehiculo</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_conductor" id="id_conductor" multiple="multiple" class="form-control selectpicker" data-live-search="true">
						     	    	<!-- <?php foreach ($listarConductorPorVehiculo as $lcv){ ?>
                                            <option value="<?php echo $lcv['id_conductor'] ?>" <?php if(in_array($lcv['id_conductor'], $conductores)){ ?> selected="selected" <?php } ?> >
                                                <?php echo $lcv['nombre_conductor']; ?>
                                            </option>
                                        <?php } ?> -->
								    </select>
				     	        </section>
		                    </div>

	                	<!-- CONTRATOS -->

		                    <div class="row mt-3 mb-3" id="contratos">
		                    	<section class="label">
				     	            <label><b>Contratos del vehiculo</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <select name="id_contrato" id="id_contrato" class="form-control" onchange="validarObjetoContrato(this.value);">
								        <option value="0">Seleccionar</option>
								    </select>
				     	        </section>
		                    </div>

		                <!-- OBJETO -->

		                    <div class="row mt-3 mb-3" id="ObjContrato">
		                    	<section class="label">
				     	            <label><b>Objeto del Contrato</b></label>
				     	        </section>
		                    	<section class="input">
						     	    <textarea class="form-control" name="objeto_contrato_conv" id="objeto_contrato_conv"><?php echo $lcpi['objeto']; ?></textarea>
				     	        </section>
		                    </div>

		                <!--FECHA INICIO -->
                    
		                    <div class="row mt-3">
		                    	<section class="label">
		                    	 	<label><b>Desde:</b></label>
		                    	</section>
		                    	<section class="input">
		                    	 	<input type="text" name="fecha_inicio_convenio" id="datepicker" class="form-control" value="<?php echo $lcpi['fecha_inicio_convenio']; ?>">
		                    	</section>
		                    </div>

     	   				<!--FECHA FINAL -->

		     	   			<div class="row mt-3 mb-5	">
		                    	<section class="label">
		     	                    <label><b>Hasta:</b></label>
		     	                </section>
		                    	<section class="input">
		     	                    <input type="text" name="fecha_final_convenio" id="datepicker1" class="form-control" value="<?php echo $lcpi['fecha_final_convenio'] ?>">
		     	                </section>
		                    </div>

	                    <section class="col-12 mt-4 d-flex justify-content-center">
	                        <a href="convenios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                        <button type="submit" class="btn btn-outline-info col-3">Registrar</button>
	                    </section>	

					<?php } ?>
	            </form> 
	        </div>
	    </section>



    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">


        $(function(){
	        $("#datepicker").datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	        $("#datepicker1").datepicker({
	        	dateFormat: "yy-mm-dd",
	        	minDate: 0
	        });
	    });


        function listarConductoresPorVehiculo(id_vehiculo, id_conductor){
            var parametros = {
                "id_vehiculo" : id_vehiculo,
                "id_conductor" : id_conductor
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarConductoresVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                	$("#id_conductor").html('<option value=""> Cargando Conductores</option>');
                },
                success:  function (response) {
                    $("#id_conductor").html(response);
                }
            })
        }

        function validarObjetoContrato(id_contrato){
        	var parametros = {
                "id_contrato" : id_contrato
            };
            $.ajax({
                data: parametros,
                url: '../Controlador/listarObjetoPorContratoVehiculo.php',
                type: 'POST',
                beforeSend: function () {
                	$("#objeto_contrato_conv").html('Cargando, por favor espere..');
                },
                success:  function (response) {
                    $("#objeto_contrato_conv").html(response);
                }
            });
        }

        function listarContratosPorVehiculo(id_vehiculo, id_contrato){
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
                success: function (response) {
                    $("#id_contrato").html(response);
                }
            })
        }

        listarConductoresPorVehiculo(<?php echo $listarConvenioPorId[0]['id_vehiculo']; ?>, 0);

        listarContratosPorVehiculo(<?php echo $listarConvenioPorId[0]['id_vehiculo']; ?>, <?php echo $listarConvenioPorId[0]['id_contrato']; ?>);
        
	</script>
	
</body>
</html>