<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Contrato.php");

$id_contrato = $_GET['id_contrato'];

/**/
$empresa = new Empresa();
$listarE = $empresa->listar();

$usuario = new Usuario();
$listarU = $usuario->listar();

$cliente = new Cliente();
$listarCl = $cliente->listar();

$ciudad = new Ciudad();
$listarCiudad = $ciudad->listar();

$contrato = new Contrato();
$listarTiposContratos = $contrato->listarTiposContratos();
$listarIdContrato = $contrato->listarId($id_contrato);
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Generar Contrato</title>
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
		         <ol class="breadcrumb" style="background-color: #fff;">
		            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Registrar Contrato</li>
		         </ol>
		    </div>


      		<div class="notice notice-sistemakv">
          		<strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR CONTRATO</b></strong>
      		</div>


		    <section class="form-usuarios mt-1 mb-5">

		        <div class="formulario mb-4">

		            <!--FORMULARIO -->

			            <form method="POST" action="../Controlador/actualizarContrato.php" enctype="multipart/form-data">
								
							<?php foreach ($listarIdContrato as $lic){ ?>
								
								<input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $lic['id_responsable'] ?>" class="form-control">

								<input type="hidden" name="id_contrato" id="id_contrato" value="<?php echo $id_contrato ?>" class="form-control">

								<input type="hidden" name="fecha_creacion_contrato" id="fecha_creacion_contrato" value="<?php echo $lic['fecha_creacion_contrato'] ?>" class="form-control">

								<input type="hidden" name="hora_creacion_contrato" id="hora_creacion_contrato" value="<?php echo $lic['hora_creacion_contrato'] ?>" class="form-control">

								<!-- Numero Contrato -->

									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Numero Interno</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="num_interno" id="num_interno" class="form-control" value="<?php echo $lic['id_contrato'] ?>" readonly="readonly">
										</section>
									</div>
								
								<!-- Numero Contrato -->

									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Numero Contrato</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="numero_contrato" id="numero_contrato" class="form-control" value="<?php echo $lic['numero_contrato'] ?>">
										</section>
									</div>

								<!-- Tipo Contrato -->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Tipo Contrato</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_tipo_contrato" id="id_tipo_contrato" class="form-control selectpicker" data-live-search="true">
										        <?php foreach ($listarTiposContratos as $ltc){ ?>
										        	<option value="<?php echo $ltc['id_tipo_contrato'] ?>" <?php if($lic['id_tipo_contrato'] == $ltc['id_tipo_contrato']){ ?> selected="selected" <?php } ?>>
										        		<?php echo utf8_encode($ltc['tipo_contrato']) ?>
										        	</option>
										        <?php } ?>
										    </select>
						     	        </section>
				                    </div>

								 <!-- Objeto Contrato-->

									<div class="row mt-3" id="objetoContrato">
										<section class="label">      
										    <label>Objeto del contrato</label>
										</section>
										<section class="input">
											<textarea name="objeto_contrato" id="objeto_contrato" class="form-control" ><?php echo $lic['objeto_contrato'] ?></textarea>
										</section>
									</div>
								
								<!-- Empresa -->

				                    <div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Empresa contratista</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_empresa" id="id_empresa" class="form-control selectpicker" data-live-search="true"selectpicker" data-live-search="true">
										        <option>Seleccionar</option>
										        <?php foreach ($listarE as $le){ ?>
										        	<option value="<?php echo $le['id_empresa'] ?>" <?php if($lic['id_empresa'] == $le['id_empresa']){ ?> selected="selected" <?php } ?>>
										        		<?php echo $le['nombre_empresa'] ?>
										        	</option>
										        <?php } ?>
										    </select>
						     	        </section>
				                    </div>

				                <!-- Cliente -->

				                    <div class="row  mt-3 ">
				                    	<section class="label">
						     	            <label><b>Cliente contratante</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true"selectpicker" data-live-search="true">
										        <option>Seleccionar</option>
										        <?php foreach ($listarCl as $lcl){ ?>
										        	<option value="<?php echo $lcl['id_cliente'] ?>" <?php if($lic['id_cliente'] == $lcl['id_cliente']){ ?> selected="selected" <?php } ?>>
										        		<?php echo $lcl['razon_social'] ?>
										        	</option>
										        <?php } ?>
										    </select>
						     	        </section>
				                    </div>

				                 <!--Fecha Inicio-->
			                    
				                    <div class="row mt-3 ">
				                    	<section class="label">
				                    	 	<label>Fecha inicial del contrato</label>
				                    	</section>
				                    	<section class="input">
				                    	 	<input type="text" name="fecha_inicial_contrato" id="datepicker" class="form-control" value="<?php echo $lic['fecha_inicial_contrato']; ?>">
				                    	</section>
				                    </div>

								<!-- Fecha final -->

				     	   			<div class="row mt-3 " id="fechaFinal">
				                    	<section class="label">
				     	                    <label><b>Fecha final del contrato</b></label>
				     	                </section>
				                    	<section class="input">
				     	                    <input type="text" name="fecha_final_contrato" id="datepicker1" class="form-control" value="<?php echo $lic['fecha_final_contrato']; ?>">
				     	                </section>
				                    </div>

				                <!-- Ciudad -->

				                    <div class="row mt-3" id="ciudad">
				                    	<section class="label">
						     	            <label><b>Ciudad de emisión del contrato</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <select class="form-control selectpicker" data-live-search="true" name="id_ciudad" id="id_ciudad">
								     	    	<option value="0">Seleccionar</option>
											 	<?php foreach ($listarCiudad as $lciudad){ ?>
											 		<option value="<?php echo $lciudad['id_ciudad'] ?>"  <?php if($lic['id_ciudad'] == $lciudad['id_ciudad']){ ?>selected="selected" <?php } ?>>
											 			<?php echo $lciudad['ciudad']; ?>
											 		</option>
											 	<?php } ?>
											</select>
						     	        </section>
				                    </div>

				                <!-- Doc Contrato -->
		            			
		            				<div class="row mt-3" id="fotocopiaContrato">
				                    	<section class="label">
				     	                    <label><b>Fotocopia del contrato firmado</b></label>
				     	                </section>
				                    	<section class="input">
				                    		<input type="file" name="doc_fotocopia_contrato" id="doc_fotocopia_contrato" class="form-control">
				     	                    <input type="hidden" name="doc_fotocopia_contrato_act" id="doc_fotocopia_contrato_act" class="form-control" value="<?php echo $lic['doc_fotocopia_contrato'] ?>">

				     	                    <?php if ($lic['doc_fotocopia_contrato'] == '') { ?>
								        	    <label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> No hay documentos cargados</label>
								        	<?php } else{ ?>
								        	    <label class="mt-2" for="act_certificados_cursos"><strong>Documento Actual: </strong> <a target="_blank" href="../Documentos/Contratos/<?php  echo $lic['doc_fotocopia_contrato'] ?>"><?php echo $lic['doc_fotocopia_contrato'] ?> <span class="fa fa-eye"></span> </a></label>
								        	<?php }  ?>
				     	                </section>
				               	 	</div>

								<!-- Nombre Responsable -->
									
									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Nombre Responsable</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="nombre_responsable" id="nombre_responsable" class="form-control" value="<?php echo $lic['nombre_responsable'] ?>">
										</section>
									</div>

								<!-- Numero Documento Responsable -->
									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Número de Documento Responsable</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="numero_documento_responsable" id="numero_documento_responsable" class="form-control" value="<?php echo $lic['numero_documento_responsable'] ?>">
										</section>
									</div>

								<!-- Direccion Responsable -->
									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Dirección Responsable</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="direccion_responsable" id="direccion_responsable" class="form-control" value="<?php echo $lic['direccion_responsable'] ?>">
										</section>
									</div>

								<!-- Telefono Responsable -->
									<div class="row mt-3">
				                    	<section class="label">
						     	            <label><b>Teléfono Responsable</b></label>
						     	        </section>
				                    	<section class="input">
								     	    <input name="telefono_responsable" id="telefono_responsable" class="form-control" value="<?php echo $lic['telefono_responsable'] ?>">
										</section>
									</div>

							<?php } ?>
					        	
							<section class="col-12 mt-4 d-flex justify-content-center">
			        			
			        			<a href="contratos.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>

		                        <button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>

		                    </section>

			            </form> 

		            <!-- FIN FORMULARIO -->

		        </div>

		    </section>

		</section>

    <!-- FIN CONTENIDO -->

    <!-- ************************************ -->

    <!-- SCRIPT -->

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

		    $( function(){
	      	   $("#id_vehiculo").chosen(); 
	      	   $("#id_usuario").chosen(); 
	        });

	        function validarTipoContrato(){
	        	var tipoContrato = document.getElementById('id_tipo_contrato').value;

	        	if (tipoContrato > 0) {
	        		document.getElementById('objetoContrato').style.display = 'flex';
	        	}else{
	        		document.getElementById('objetoContrato').style.display = 'none';
	        	}
	        }
		</script>

    <!-- FIN SCRIPT -->

</body>
</html>