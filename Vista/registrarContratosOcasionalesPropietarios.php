<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/BitacoraTransaccion.php");
require_once("../Modelo/ConceptosCobro.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");

$id_responsable = $_SESSION['id_usuario'];


/* VARIABLES MENU*/
$titulo = 'Generar Contrato Ocasional';
$redireccion = 'inicioPropietarios.php';
$icono = 'fa fa-file-text-o';

$concepto = new ConceptoCobro();

/**/
$usuario = new Usuario();
$listarU = $usuario->listar();

$ciudad = new Ciudad();
$listar = $ciudad->listar();

$vehiculo = new Vehiculo();
$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);

$vehiculo = new Vehiculo();
$listarVehiculosPorConductor = $vehiculo->listarVehiculosPorConductor($listarConductorPorId[0]['id_conductor']);


$cliente = new Cliente();
$listarClUsuarioRegistro = $cliente->listarClientesAncladosPorPropietario($_SESSION['id_usuario']);


$transacciones = new Transacciones();
$transaccionesPendPorUsu = $transacciones->historialTransaccionesPendientesPorUsuario($_SESSION['id_usuario']);

$cantTPU = count($transaccionesPendPorUsu);

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Generar Contrato Ocasional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- FIN STYLES -->
	    <?php include("Template/styles.php"); ?>
      	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

	    <style>
	    	

	        .ajs-button{
	            border-radius: 5px;
	            background-color: #5e99b1;
	            color: #fff;
	            box-shadow: none;
	            border:0px;
	        }

	        .ajs-header{
	            color: #1b2d3b !important;
	        }

	    </style>
    <!-- STYLES -->

</head>
<body>

	<!-- MENU -->
      	<?php include("Template/header.php"); ?>
      	<?php include("Template/newMenu.php"); ?>
    <!-- FIN MENU -->
    
	<!-- ************************** -->

	<!-- CONTENIDO -->

	  	<section class="home_content"> 

		    <div aria-label="breadcrumb" class="mt-1"> 
		         <ol class="breadcrumb" style="background-color: #fff;">
		            <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
		            <li class="breadcrumb-item " aria-current="page"><a href="contratosOcasionalesPropietarios.php">Contratos Ocasionales</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato Ocasional</li>
		         </ol>
		    </div>

		    <div class="notice notice-sistemakv">
              	<strong><i class="fa fa-id-card-o  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">GENERAR PLANILLA OCASIONAL</b></strong>
          	</div>

		    <section class="form-usuarios mt-1 mb-4">
		        <div class="formulario mb-5">
		            <!--FORMULARIO -->

			            <form method="POST" action="../Controlador/registrarContraOcasionalPropietarios.php" enctype="multipart/form-data">
			            	    
			            	    <input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $id_responsable ?>" class="form-control">
					        	
					            <div id="input_validation"></div> 

					            <!-- VEHÍCULO -->

					                    <div class="row mt-3 mb-3 ">
					                    	<section class="label">
							     	            <label><b>Vehículo</b></label>
							     	        </section>
					                    	<section class="input">
									     	    <select class="form-control selectpicker" data-live-search="true" name="id_vehiculo" id="id_vehiculo" required class="form-control" onchange="validarDocsConductor(this.value); validarEmpresaVehiculo(this.value); validarDocsYCarteraPorVehiculo(this.value);">
											        <option value="">SELECCIONAR</option>
											        <?php foreach ($buscarVehiculoPorPropietario as $lvp){ 

											        	$hoy = date('Y-m-d');
														$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
														$fecha2 = date('Y-m-d',$fecha2);
														$docs_vacios = $vehiculo->documentosvencidosPorId($lvp['id_vehiculo'],$hoy,$fecha2);
														
		                                                $pagos_pendientes = $concepto->pagosPendientesPorVehiculo($lvp['id_vehiculo']);
		                                                $cant_carteraPendiente = count($pagos_pendientes);
														
															if((count($docs_vacios) > 0) || ($cant_carteraPendiente > 0)){ ?>

													        	<option value="<?php echo $lvp['id_vehiculo'] ?>" style="color:red;font-weight:bolder">
													        		<strong>
														        		<?php
														        			$listarVId = $vehiculo->listarPorId($lvp['id_vehiculo']);
																			echo $listarVId[0]['placa'];
														        		?>
													        		</strong>
													        	</option>
													        <?php }else{ ?>
																<option value="<?php echo $lvp['id_vehiculo'] ?>">
													        		<?php
													        			$listarVId = $vehiculo->listarPorId($lvp['id_vehiculo']);
																		echo $listarVId[0]['placa'];
													        		?>
													        	</option>
												        	<?php } ?>

											        <?php } ?>
											    </select>
							     	        </section>
					                    </div>
				                    	
		                    	<!-- CONDUCTORES-->
					                <div class="row ml-5 mb-3" class="mensaje_conductor" id="mensaje_conductor">
				                        <div class="col-12 ml-5">
				                            
				                        </div>
				                    </div>

					            <!-- EMPRESA -->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Empresa contratista</b></label>
						     	        </section>
				                    	<section class="input" id="input_empresa">

						     	        </section>
				                    </div>

				                <!-- CLIENTE -->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label><b>Cliente contratante</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true" required="required">
										        <option value="">SELECCIONAR</option>
										        <?php foreach ($listarClUsuarioRegistro as $lclur){ 
										        	$listarClienteID = $cliente->cliente_ID($lclur['id_cliente']); ?>
										        	<option value="<?php echo $listarClienteID[0]['id_cliente'] ?>">
										        		<?php echo $listarClienteID[0]['razon_social'] ?>
										        	</option>
										        <?php } ?>
										    </select>
						     	        </section>
				                    </div>

				                    <?php if (count($listarClUsuarioRegistro) <= 0 ){ ?>
					                    <section class="col-12 d-flex justify-content-center mt-4">
					                    		<div class="col-11 alert alert-danger text-center" role="alert">
												   Debe crear un cliente para continuar con la creación
												</div>
					                    </section>
				                    <?php } ?>

				                <!-- OBJETO DEL CONTRATO-->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label><b>Objeto del contrato</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <textarea name="objeto_contrato" id="objeto_contrato" class="form-control" readonly="readonly">SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS</textarea> 
						     	        </section>
				                    </div>

				                <!-- ORIGEN -->

				                	<div class="row mt-3" id="orig">
				                    	<section class="label">
						     	            <label><b>Origen</b></label>
						     	        </section>
				                    	<section class="input">
		                                      <select class="form-control selectpicker" data-live-search="true" name="origen" id="origen" required="required">
			                                      	<option value="">SELECCIONAR</option>
												 	<?php foreach ($listar as $lc){ ?>
												 		<option value="<?php echo $lc['id_ciudad'] ?>">
												 			<?php echo $lc['ciudad'] ?>
												 		</option>
												 	<?php } ?>
		                                      </select>
						     	        </section>
				                    </div>

				                <!-- DESTINO -->

				                    <div class="row mt-3" id="dest">
				                    	<section class="label">
						     	            <label><b>Destino</b></label>
						     	        </section>
				                    	<section class="input">
		                                        <select class="form-control selectpicker" data-live-search="true" name="destino"  id="destino" onchange="validarCiudadOrigenDestino(this.value)" required="required">
			                                      	<option value="">SELECCIONAR</option>
												 	<?php foreach ($listar as $lc){ ?>
												 		<option value="<?php echo $lc['id_ciudad'] ?>">
												 			<?php echo $lc['ciudad'] ?>
												 		</option>
												 	<?php } ?>
		                                      </select>
						     	        </section>
				                    </div>

				                <!-- CIUDAD -->
				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Ciudad emición del contrato</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select class="form-control selectpicker" data-live-search="true" name="id_ciudad" id="id_ciudad"  required="required">
											 	<option value="">SELECCIONAR</option>
											 	<?php foreach ($listar as $lc){ ?>
											 		<option value="<?php echo $lc['id_ciudad'] ?>">
											 			<?php echo $lc['ciudad'] ?>
											 		</option>
											 	<?php } ?>
											</select>
						     	        </section>
				                    </div>

				                <!-- FECHA INICIO-->
			                    
				                    <div class="row mt-3 ">
				                    	<section class="label">
				                    	 	<label><b>Fecha inicial del contrato</b></label>
				                    	</section>
				                    	<section class="input">
				                    	 	<input type="text" name="fecha_inicial_contrato_ocasional" id="datepicker" class="form-control" required="required">
				                    	</section>
				                    </div>

				                <!-- VALOR CONTRATO -->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Valor aproximado del contrato</b></label>
						     	        </section>
					                   	<section class="input">
					                   		<select name="valor_contrato" id="valor_contrato" class="form-control selectpicker" data-live-search="true" required="required">
					                   			<option value="">SELECCIONAR</option>
					                   			<option value="50000">$50.000 COP</option>
					                   			<option value="100000">$100.000 COP</option>
					                   			<option value="150000">$150.000 COP</option>
					                   			<option value="200000">$200.000 COP</option>
					                   			<option value="250000">$250.000 COP</option>
					                   			<option value="300000">$300.000 COP</option>
					                   			<option value="350000">$350.000 COP</option>
					                   			<option value="400000">$400.000 COP</option>
					                   			<option value="450000">$540.000 COP</option>
					                   			<option value="500000">$500.000 COP</option>
					                   			<option value="550000">$550.000 COP</option>
					                   			<option value="600000">$600.000 COP</option>
					                   			<option value="650000">$650.000 COP</option>
					                   			<option value="700000">$700.000 COP</option>
					                   			<option value="750000">$750.000 COP</option>
					                   			<option value="800000">$800.000 COP</option>
					                   			<option value="850000">$850.000 COP</option>
					                   			<option value="900000">$900.000 COP</option>
					                   			<option value="950000">$950.000 COP</option>
					                   			<option value="1000000">$1.000.000 COP</option>
					                   			<option value="1500000">$1.500.000 COP</option>
					                   			<option value="2000000">$2.000.000 COP</option>
					                   			<option value="2500000">$2.500.000 COP</option>
					                   			<option value="3000000">$3.000.000 COP</option>
					                   			<option value="3500000">$3.500.000 COP</option>
					                   			<option value="4000000">$4.000.000 COP</option>
					                   			<option value="4500000">$4.500.000 COP</option>
					                   			<option value="5000000">$5.000.000 COP</option>
					                   			<option value="5500000">$5.500.000 COP</option>
					                   			<option value="6000000">$6.000.000 COP</option>
					                   			<option value="+6000000">Mas de $6.000.000 COP</option>
					                   			
					                   		</select>
							     	    </section>
				                    </div>

				                <!-- TIPO CONVENIO -->
				                    <input type="hidden" class="form-control" name="tipo_extracto" id="tipo_extracto" style="border-style: dashed;" value="N/A"  readonly="readonly" onkeyup="solo_numeros(this.value);">

				                <!-- CONTRATO FIRMADO -->
				                    <div class="row mt-3 mb-5">
				                    	<section class="label">  
				                            <label><b>Contrato Firmado (Documento)</b></label>
				                        </section>
					                   	<section class="input"> 
					                   		<input type="file" class="form-control" name="contrato_firmado" id="contrato_firmado" style="border-style: dashed;" required="true">
				                       </section>
				                    </div>
								
								<section class="col-12 mt-4 d-flex justify-content-center">
				        			
				        			<a href="contratosOcasionalesPropietarios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
			                        <button type="submit" id="buttonsKV" class="btn col-3">Continuar</button>
			                    </section>

			            </form> 
		        </div>
		    </section>

		</section>

	<!-- CONTENIDO -->
    
	<!-- ************************** -->


	<!-- MODAL DECRETO ORIGEN Y DESTINO -->

			<div class="modal fade" id="myModal" tabindex="-1">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-body text-center">
					        <div class="col-12" style="height: auto;">
					        	<i style="color: #d62d2d; font-size: 6rem;" class="fa fa-exclamation-circle"></i>
					        	<h4 class="modal-title" style="color: #a1a1a1; "><strong>AVISO</strong></h4>
				        	</div>
					        <div class="col-12 mt-4">
				        		<p>De acuerdo al decreto <strong>431 de 2017 artículo 6, literal 4</strong>, El traslado puede tener origen y destino en un mismo municipio, siempre cuando se realice en vehículos de más de 9 pasajeros. </p>
				        		<strong>Anexo: </strong><a href="../Documentos/DECRETO 431-14-03-2017.pdf" target="_blank">Decreto 431 de 2017</a>
				        	</div>
				      	</div>
				      	<div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
					        <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
				        </div>
				    </div>
			  	</div>
			</div>
	
	<!-- MODAL VALIDACIÓN DOCS Y CARTERA -->

	    <div class="modal fade" id="ModalValidation" tabindex="-1">
		  	<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-body text-center">
				        <div class="col-12" style="height: auto;">
				        	<i style="color: #d62d2d; font-size: 6rem;" class="fa fa-exclamation-circle"></i>
				        	<h4 class="modal-title" style="color: #a1a1a1; "><strong>DOCUMENTACIÓN O CARTERA PENDIENTE</strong></h4>
			        	</div>
				        <div class="col-12 mt-4" id="validationDocVencida" style="display:none;">
			        		<p>El vehiculo tiene documentación vencida, no se podrá emitir fuec con el vehículo hasta tener todo al día.</p>
			        	</div>
			        	
				        <div class="col-12 mt-4" id="validationCartera" style="display:none;">
			        		<p>El vehiculo tiene cartera pendiente, no se podrá emitir fuec con el vehículo hasta tener los pagos al día</p>
			        	</div>
			        	
				        <div class="col-12 mt-4" id="validationDocYCartera" style="display:none;">
			        		<p>El vehiculo tiene documentación vencida y cartera pendiente, no se podrá emitir fuec con el vehículo hasta tener todo al día.</p>
			        	</div>
			      	</div>
			      	<div class="col-12 modal-footer d-flex justify-content-center" style="border: 0px;">
				        <button type="button" class="col-3 btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
			        </div>
			    </div>
		  	</div>
		</div>

	<!-- ************************** -->


	<!-- SCRIPT -->

    <?php include("Template/scripts.php"); ?>

	<script type="text/javascript">

		function modalAviso(){
			if (<?php echo $cantTPU; ?> > 0) {
				alertify.alert('TRANSACCIÓN EN CURSO', '¡Actualmente tiene una transaccion con estado pendiente! \n no podra avanzar hasta terminar el debido proceso de la transacción o intentarlo nuevamente mas tarde \n  Si desea validar el estado de la misma dirijirse a la sección de historial de transacciones.', function(){ window.history.back(); });  
			} 
        }

        $(window).on("load", modalAviso());

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

        function validarCiudadOrigenDestino(destino){
        	origen = $('#origen').val();
        	cant_pasajeros = $('#pasajeros_vehiculo').val();
        	
        	if (cant_pasajeros < 9) {
	        	if (destino == origen) {
	        		$("#myModal").modal("show");
	        		$('#destino').prop('selectedIndex',0);
	        	}
        	}
        }

        function validarEmpresaVehiculo(id_vehiculo){

        	var parametros = {
        		"id_vehiculo" : id_vehiculo,
        	};

        	$.ajax({
                data:  parametros,
        		url:   '../Controlador/validarEmpresaPorVehiculo.php',
        		type: 'POST',
                beforeSend: function () {
                    $("#input_empresa").html("<option value=''>Procesando, espere por favor...</option>");
        		},
                success:  function (response) {
                	$("#input_empresa").html(response); 
        		}
        	});
        }

        function validarDocsConductor(id_vehiculo){
            var parametros = {
                "id_vehiculo" : id_vehiculo,
            };

            $.ajax({
                data:  parametros,
                url:   '../Controlador/VerificarDocConductorPorVehiculo.php',
                type:  'POST',
                beforeSend: function () {
                },
                success:  function (response) {
                    $("#mensaje_conductor").html(response);
                    
                    var con = document.getElementById('verificarDocsConductor').value;
                    if(con >= 1){
                        $("#id_cliente").attr("disabled","disabled");   
                        $("#id_empresa").attr("disabled","disabled");   
        			    $("#origen").attr("disabled","disabled");                      
                        $("#destino").attr("disabled","disabled");                          
                        $("#id_ciudad").attr("disabled","disabled");                          
                        $("#datepicker").attr("disabled","disabled");                      
                        $("#valor_contrato").attr("disabled","disabled");  
                        $('#guardar').attr("disabled", true);
                    }else{
                        $("#id_cliente").attr("disabled",false);   
                        $("#id_empresa").attr("disabled",false);   
        			    $("#origen").attr("disabled",false);                      
                        $("#destino").attr("disabled",false);                          
                        $("#id_ciudad").attr("disabled",false);                          
                        $("#datepicker").attr("disabled",false);                      
                        $("#valor_contrato").attr("disabled",false);  
                        $('#guardar').attr("disabled", false);
                        
                    }
                }
            });
        }

        function validarDocsYCarteraPorVehiculo(id_vehiculo){
        	
        	var parametros = {
        		"id_vehiculo" : id_vehiculo,
        	};


        	$.ajax({
        		data: parametros,
        		url: '../Controlador/validarDocsYCarteraPorVehiculo.php',
        		type: 'POST',
        		beforeSend: function(){
        		},
        		success: function(response){
        			$('#input_validation').html(response);
        			
        			var validacion = document.getElementById('validacion_doc_cartera').value;
        			
        			if((validacion == 1) || (validacion == 2) || (validacion == 3)){
                        $('#ModalValidation').modal('show');
                  
                        $("#id_cliente").attr("disabled","disabled");   
                        $("#id_empresa").attr("disabled","disabled");   
        			    $("#origen").attr("disabled","disabled");                      
                        $("#destino").attr("disabled","disabled");                          
                        $("#id_ciudad").attr("disabled","disabled");                          
                        $("#datepicker").attr("disabled","disabled");                      
                        $("#valor_contrato").attr("disabled","disabled");  
                        $('#guardar').attr("disabled", true);  
                    }else{
                        $('#ModalValidation').modal('hide');
                        
                        $("#id_cliente").attr("disabled",false);   
                        $("#id_empresa").attr("disabled",false);   
        			    $("#origen").attr("disabled",false);                      
                        $("#destino").attr("disabled",false);                          
                        $("#id_ciudad").attr("disabled",false);                          
                        $("#datepicker").attr("disabled",false);                      
                        $("#valor_contrato").attr("disabled",false);  
                        $('#guardar').attr("disabled", false);
                    }
                    
                    if(validacion == 1){
                        document.getElementById('validationDocVencida').style.display = 'flex';  
                        document.getElementById('validationCartera').style.display = 'none';  
                        document.getElementById('validationDocYCartera').style.display = 'none';   
                    }else if(validacion == 2){
                        document.getElementById('validationCartera').style.display = 'flex';
                        document.getElementById('validationDocVencida').style.display = 'none';  
                        document.getElementById('validationDocYCartera').style.display = 'none'; 
                    }else if(validacion == 3){
                        document.getElementById('validationDocYCartera').style.display = 'flex';
                        document.getElementById('validationDocVencida').style.display = 'none';  
                        document.getElementById('validationCartera').style.display = 'none'; 
                    }else{
                        document.getElementById('validationDocVencida').style.display = 'none';
                        document.getElementById('validationCartera').style.display = 'none';
                        document.getElementById('validationDocYCartera').style.display = 'none';
                    }

        		}
        	});
        }
	</script>

	<!-- FIN SCRIPT -->

</body>
</html>