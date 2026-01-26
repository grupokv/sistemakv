<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';

$usuario = new Usuario();
$listarTodosUsuarios = $usuario->listarUsuariosInternosEmpresa();

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
    
    <!-- STYLES -->
		<?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

		<style type="text/css">
	    	.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
	            background: #5e99b1 !important;
	            border: #fff;
	        }

			.ms-container{
				width: 700px;
			}

	    </style>

    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
		<?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

	<section class="home_content">

		<div aria-label="breadcrumb" class="mt-1"> 
			<ol class="breadcrumb" style="background-color: #fff;">
				<li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
				<li class="breadcrumb-item " aria-current="page"><a href="Actas.php">Actas</a></li>
				<li class="breadcrumb-item active" aria-current="page">Registrar Actas</li>
			</ol>
		</div>

		<div class="notice notice-sistemakv">
			<strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR ACTAS</b></strong>
		</div>

		<section class="form-usuarios mb-4">
			<div class="formulario">
				<form action="../Controlador/registrarActaeInvitados.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
					
					<div id="tabs" class="mt-4">
						<ul>
						<li><a href="#tabs-1">Información </a></li>
						<li><a href="#tabs-2">Invitados </a></li>
						</ul>

						<!-- INFORMACION BASICA-->
							<div id="tabs-1">

								<!--CLIENTE-->
									<div class="row mt-3">
										<div class="label">
											<label>Nombre del cliente</label>
										</div>
										<div class="input">
											<input type="text" name="cliente"  id="cliente" class="form-control form-control-sm">
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
												<option value="1">ORGANIZACIÓN ORT SAS</option>
												<option value="2">LINEAS PREMIUM SAS</option>
												<option value="3">KING VISION</option>
											</select>
										</div>      		
									</div>

								<!--NOMBRE-->
									<div class="row mt-3">
										<div class="label">
											<label>Titulo del Acta</label>
										</div>
										<div class="input">
											<input type="text" name="nombre_acta"  id="nombre_acta" class="form-control form-control-sm" required="required">
										</div>      		
									</div>

								<!--FECHA REUNION-->
									<div class="row mt-3">
										<div class="label">
											<label>Fecha de Reunión</label>
										</div>
										<div class="input">
											<input type="text" name="fecha_reunion"  id="datepicker" class="form-control form-control-sm" required="required">
										</div>      		
									</div>

								<!--NOMBRE-->
									<div class="row mt-3">
										<div class="label">
											<label>Hora Inicial y Final </label>
										</div>
										<div class="row">
											<div class="col-6">
												<div class="input-group clockpicker">
													<input type="text" name="hora_inicial_acta" class="form-control form-control-sm" required="required">
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-time"></span>
													</span>
												</div>
											</div>
											<div class="col-6">
												<div class="input-group clockpicker">
													<input type="text" name="hora_final_acta" class="form-control form-control-sm" required="required">
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-time"></span>
													</span>
												</div>
											</div>
											
											
										</div>      		
									</div>
							</div>
						<!-- FIN INFORMACION BASICA-->

						<!-- ****************** -->

						<!-- INVITADOS -->
							<div id="tabs-2">

								<!--USUARIOS EXTERNOS-->

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
										<p>Invitados Externos</p>
									</div>

									<!-- Asist Personas Externas -->
										<div class="row mt-3 mb-4">
											<div class="label">
												<label>¿Asistieron personas externas?</label>
											</div>
											<div class="input">
												<select name="AsistPersonasE" id="AsistPersonasE" class="form-control" onchange="validarAsistPersonas();">
													<option value="">SELECCIONAR</option>
													<option value="S">SI</option>
													<option value="N">NO</option>
												</select>
											</div>      		
										</div>

									<!-- Cant personas -->
										<div class="row mt-3 mb-4" id="cant" style="display: none;">
											<div class="label">
												<label>¿Cuantas personas?</label>
											</div>
											<div class="input">
												<input type="number" name="cant_usuarios_externos"  id="cant_usuarios_externos" class="form-control" onkeyup="crearFilaInput()">
											</div>      		
										</div>

									<table id="input-group" class="table">
								
									</table>
							
								<!--USUARIOS INTERNOS-->
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #1b2d3b; color: #fff; border-radius: 3px;">
											<p>Invitados Internos</p>
									</div>

									<div class="col-12 mt-3 mb-4">
										<label class="mb-4">Seleccione Los Invitados</label>
									</div>

									<div class="col-12 mt-3 mb-4 d-flex justify-content-center" id="cant">
										<select class="form-control" multiple="multiple" id="id_invitado" name="id_invitado[]">
											<?php foreach ($listarTodosUsuarios as $lu){ ?>
												<option value="<?php echo utf8_encode($lu['id_usuario']); ?>"><?php echo $lu['nombre']; ?></option>
											<?php } ?>
										</select> 	
									</div>
								
							</div>
						<!-- FIN INVITADOS -->

					</div>

					
					<section class="col-12 mt-4 mb-3 p-3 d-flex justify-content-center">
						<a href="Actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
						<button type="submit" class="btn btn-outline-info col-3">Continuar</button>
					</section>

				</form>
			</div>
		</section>

	</section>

    <!-- SCRIPT -->
		<?php include("Template/scripts.php"); ?>
		<script type="text/javascript">

			$( function() {
				$("#datepicker").datepicker({ dateFormat:'yy/mm/dd'});
				$("#id_invitado").multiSelect();
			});

			

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

		</script>
    <!-- FIN SCRIPT -->

</body>
</html>