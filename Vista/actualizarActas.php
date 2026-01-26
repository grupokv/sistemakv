<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Actas.php';

$id_acta  = $_GET['id_acta'];

$usuario = new Usuario();
$acta = new Acta();

$listarTodosUsuarios = $usuario->listarUsuariosInternosEmpresa();
$listarActaId = $acta->listarActasId($id_acta);
$idInvitados = $acta->listarIdInvitados($id_acta);
$listarInvitadosActa = $acta->listarInvitadosActaId($id_acta);

$usuarios_internos = array();

foreach ($listarInvitadosActa as $lia) {
	array_push($usuarios_internos, $lia['id_usuario_interno']);
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Actas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
		<?php include("Template/styles.php"); ?>
      	<link rel="stylesheet" href="../Resources/css/stylesHeader.css">

      	<style type="text/css">

      		.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #1b2d3b !important;
	            border: #fff;
	        }
            .modal-backdrop.show {
                opacity: .5;
                z-index:-1 !important;
            }
            .modal.show .modal-dialog {
                -webkit-transform: none;
                transform: none;
                z-index: 2000;
                margin-top: 4% !important;
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
					<li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
					<li class="breadcrumb-item " aria-current="page"><a href="actas.php">Actas</a></li>
					<li class="breadcrumb-item active" aria-current="page">Actualizar Actas</li>
				</ol>
			</div>

			<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-file-text  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR ACTA</b></strong>
          	</div>

    	<section class="form-usuarios">
        	<div class="formulario mb-5">
	        	<form action="../Controlador/actualizarActa.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
				
					<div id="tabs" class="mt-3">
	                    <ul>
	                      <li><a href="#tabs-1">Información </a></li>
	                      <li><a href="#tabs-2">Invitados </a></li>
	                    </ul>

	                    <!-- INFORMACION BASICA-->
	                        <div id="tabs-1">

								<?php foreach ($listarActaId as $lai){ ?>

									<input type="hidden" name="id_acta" id="id_acta" value="<?php echo $lai['id_acta']; ?>">
									<input type="hidden" name="id_responsable" id="id_responsable" value="<?php echo $lai['id_responsable']; ?>">
									<input type="hidden" name="fecha_hora_creacion" id="fecha_hora_creacion" value="<?php echo $lai['fecha_hora_creacion']; ?>">
									
									<!--CLIENTE-->
										<div class="row mt-3">
											<div class="label">
												<label>Nombre del cliente</label>
											</div>
											<div class="input">
												<input type="text" name="cliente"  id="cliente" class="form-control form-control-sm" value="<?php echo $lai['cliente'] ?>">
											</div>      		
										</div>

									<!-- EMPRESA -->
										<div class="row mt-3">
											<div class="label">
												<label>Empresa</label>
											</div>
											<div class="input">
												<select name="empresa" id="empresa" class="form-control form-control-sm selecpicker" datal-live-search="true" required="required">
													<option value="">SELECCIONAR</option>
													<option value="1" <?php if($lai['empresa'] == 1){ ?> selected="selected" <?php } ?>>ORGANIZACIÓN ORT SAS</option>
													<option value="2" <?php if($lai['empresa'] == 2){ ?> selected="selected" <?php } ?>>LINEAS PREMIUM SAS</option>
													<option value="3" <?php if($lai['empresa'] == 3){ ?> selected="selected" <?php } ?>>KING VISION</option>
												</select>
											</div>      		
										</div>

									<!--NOMBRE-->
										<div class="row mt-3">
											<div class="label">
												<label>Titulo del Acta</label>
											</div>
											<div class="input">
												<input type="text" name="nombre_acta"  id="nombre_acta" class="form-control form-control-sm" required="required" value="<?php echo $lai['nombre_acta'] ?>">
											</div>      		
										</div>

									<!--FECHA REUNION-->
										<div class="row mt-3">
											<div class="label">
												<label>Fecha de Reunión</label>
											</div>
											<div class="input">
												<input type="text" name="fecha_reunion"  id="datepicker" class="form-control form-control-sm" required="required" value="<?php echo $lai['fecha_reunion'] ?>">
											</div>      		
										</div>

									<!--HORA INICIAL Y FINAL-->
										<div class="row mt-3">
											<div class="label">
												<label>Hora Inicial y Final </label>
											</div>
											<div class="row">
												<div class="col-6">
													<div class="input-group clockpicker">
														<?php 
															$hora_inicial = explode(":", $lai['hora_inicial_acta']);
															$hora = $hora_inicial[0];
															$minuto = $hora_inicial[1];
															$segundo = $hora_inicial[2];
														?>
														<input type="text" name="hora_inicial_acta" class="form-control form-control-sm" required="required" value="<?php echo $hora . ':' . $minuto ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
												</div>
												<div class="col-6">
													<div class="input-group clockpicker">
														<?php 
															$hora_final = explode(":", $lai['hora_final_acta']);
															$horaF = $hora_final[0];
															$minutoF = $hora_final[1];
															$segundoF = $hora_final[2];
														?>
														<input type="text" name="hora_final_acta" class="form-control form-control-sm" required="required" value="<?php echo  $horaF . ':' . $minutoF ?>">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
												</div>
												
												
											</div>      		
										</div>
								

								<?php } ?>

							</div>


	                    <!-- FIN INFORMACION BASICA-->

	                    <!-- ****************** -->

	                    <!-- USUARIOS-->
	                        <div id="tabs-2">

	                        	<!--USUARIOS EXTERNOS-->

	                        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
	                                    <p>Invitados Externos</p>
	                                </div>

								<!--Asist Personas Externas-->
									<div class="row mt-3 mb-4">
			        	                <div class="label">
			        		                <label>¿Asistieron personas externas?</label>
			        	                </div>
			        	                <div class="input">
			        	                	<select name="AsistPersonasE" id="AsistPersonasE" class="form-control form-control-sm" onchange="validarAsistPersonas();" title="SELECCIONAR">
			        	                		<option value="S">SI</option>
			        	                		<option value="N">NO</option>
			        	                	</select>
			        	                </div>      		
			                        </div>

								<!--Cant personas-->
			                        <div class="row mt-3 mb-4" id="cant" style="display: none;">
			        	                <div class="label">
			        		                <label>¿Cuantas personas?</label>
			        	                </div>
			        	                <div class="input">
			        	                    <input type="number" name="cant_usuarios_externos"  id="cant_usuarios_externos" class="form-control form-control-sm" onkeyup="crearFilaInput()">
			        	                </div>      		
			                        </div>

			                    <table id="input-group" class="table">
	                        	
	      						</table>

	      						<?php if (count($listarInvitadosActa) > 0){ ?>
	      							<table class="table">	
			      						<thead>
			      							<tr>
			      								<th style="border: hidden;" class="text-center">Nombres y Apellidos</th>
			      								<th style="border: hidden;" class="text-center">Numero de Identificación</th>
			      							</tr>
			      						</thead>
			      						<tbody>

	      								<?php 
	      								$i = 1; 

		      								foreach ($listarInvitadosActa as $lia){ ?>
		      									<?php if (($lia['nombre_usuario_externo'] != '') && ($lia['id_usuario_interno'] == 0)){ ?>

													<tr id="invitado_<?php echo $lia['id_invitado'];  ?>">
														<td style="border: hidden; padding: 4px;">
															<div class="row">
																<span class="fa fa-user-circle-o mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>
																<input class="form-control form-control-sm col-9" type="text" name="nombre_usuario_act" value="<?php echo $lia['nombre_usuario_externo'] ?>" readonly="true" required/>
															</div>
														</td>

														<td style="border: hidden; padding: 4px;">
															<input class="form-control form-control-sm col-12" type="text" name="numero_documento_act" value="<?php echo $lia['numero_documento_externo'] ?>" readonly="true" required/>
														</td>

														<td style="border: hidden; padding: 4px;">
															<a type="button" class="btn btn-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-trash" style="color:#fff;" data-toggle="modal" data-target="#exampleModal<?php echo $lia['id_invitado'];?>"></span></a>
														</td>	

														<!-- Modal -->
														<div class="modal fade" id="exampleModal<?php echo $lia['id_invitado'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														  	<div class="modal-dialog" role="document">
															    <div class="modal-content">
															        <div class="modal-header">
															            <h5 class="modal-title text-center" id="exampleModalLabel">CONFIRMAR ELIMINACIÓN</h5>
															        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          		<span aria-hidden="true">&times;</span>
															            </button>
															        </div>
																    <div class="modal-body">
																        <p class="text-center">¿Está seguro de eliminar este invitado?, una vez eliminado no podra revertir el proceso.</p>
																        <div id="input-message" class="text-center">
																        	
																        </div>
																	</div>
																    <div class="modal-footer">
																        <a class="btn btn-danger" id="cancelar" data-dismiss="modal" style="color: #fff;">Cancelar</a>
																        <a type="button" id="eliminar" onclick="eliminarUE(<?php echo $lia['id_acta'] . ',' . $lia['id_invitado'];  ?>);" class="btn btn-success" style="color: #fff;" >Eliminar Invitado</a>
																    </div>	
														    	</div>
														    </div>
														</div>
														<!--fin modal-->

													</tr>
		      									<?php }
		      									$i++;  
		      								} ?>
		      							</tbody>
		      						</table>
	      						<?php }else{ ?>
									<div class="text-center"><p>No hay usuarios externos registrados actualmente</p></div>
	      						<?php } ?>
								
							
								<!--USUARIOS INTERNOS-->
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
											<p>Invitados Internos</p>
									</div>

									<div class="row mt-3 mb-4" id="cant">
										<div class="label">
											<label>Seleccione Los Invitados</label>
										</div>
										<div class="input">
											<select multiple="multiple" id="id_invitado" name="id_invitado[]">
												<?php foreach ($listarTodosUsuarios as $lu){ ?>
													<option value="<?php echo $lu['id_usuario']; ?>" <?php if(in_array($lu['id_usuario'], $usuarios_internos)){?> selected="selected" <?php } ?>>
														<?php echo $lu['nombre']; ?>
													</option>
												<?php } ?>
											</select> 
										</div>      		
									</div> 

							</div>
	                    	    
	                    <!-- FIN USUARIOS -->
					
					</div>	
	               
					<section class="col-12 mt-4 d-flex justify-content-center">
						<a href="Actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
						<button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
					</section>

				</form>
        	</div>
    	</section>

	<!-- CONTENIDO -->

	<!-- ************************** -->

	<!-- SCRIPT -->

    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

    	$( function() {
            $( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'});
            $( "#id_invitado" ).multiSelect();
            
        } );

    	$( function() {
          $( "#tabs" ).tabs();
        } ); 

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

		$('.clockpicker').clockpicker({
		    placement: 'top',
		    align: 'left',
		    donetext: 'Aplicar'
		});

		$('.clockpicker1').clockpicker({
		    placement: 'top',
		    align: 'left',
		    donetext: 'Aplicar'
		});

		function validarAsistPersonas(){
				var asist = document.getElementById('AsistPersonasE').value;

				if (asist == 'S') {
					document.getElementById('cant').style.display = 'flex';
				}else{
					document.getElementById('cant').style.display = 'none';
				}
		}

		function crearFilaInput(){

            var cantidad_usuarios = document.getElementById('cant_usuarios_externos').value;

			    var parametros = {
			       "cantidad_usuarios" : cantidad_usuarios
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/crearCamposUsuExternos.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			                $("#input-group").html("<p>Procesando, espere por favor...</p>");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
			                //alert(response);
			                $("#input-group").html(response);
			        }
			    });    	
		}

		function eliminarUE(id_acta, id_invitado){
			//alert(id_acta);
				var parametros = {
			       "id_acta" : id_acta,
			       "id_invitado" : id_invitado
			    };

			    $.ajax({
			        data:  parametros, //datos que se envian a traves de ajax
			        url:   '../Controlador/eliminarUsuarioExternoActa.php', //archivo que recibe la peticion
			        type:  'post', //método de envio
			        beforeSend: function () {
			            $("#input-message").html("<p>Procesando, espere por favor...</p>");
			        },
			        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

			            $("#exampleModal"+id_invitado).modal('hide');
			            document.getElementById('invitado_'+id_invitado).style.display = "none";
			        }
			    });    	
		}

    </script>
	
	<!-- SCRIPT -->

</body>
</html>
