<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Actas.php';

/* VARIABLES MENU*/
$titulo = 'Actualizar Actas';
$redireccion = 'actas.php';
$icono = 'fa fa-file-text';

$id_acta  = $_GET['id_acta'];

$acta = new Acta();
$usuario = new Usuario();


$listarSituacionActaId = $acta->listarSituacionActaId($id_acta);
$listarEstadoSituacion = $acta->listarEstadoSituacion();
$listarTodosUsuarios = $usuario->listarUsuariosInternosEmpresa();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Actas</title>
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

	<!-- ************************** -->

	<!-- CONTENIDO -->

	  	<section class="home_content"> 

			<div aria-label="breadcrumb" class="mt-1"> 
				<ol class="breadcrumb" style="background-color: #fff;">
					<li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
					<li class="breadcrumb-item " aria-current="page"><a href="Actas.php">Actas</a></li>
					<li class="breadcrumb-item active" aria-current="page">Actualizar Actas</li>
				</ol>
			</div>
			
			<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-file-text  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR ACTA</b></strong>
          	</div>

			<section class="form-usuarios">
				<div class="formulario mb-5">
					<form action="../Controlador/actualizarSituacionActa.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
						
						<input type="hidden" name="id_acta" id="id_acta" value="<?php echo $id_acta; ?>">								
								
							<!-- SITUACIONES -->
								<div class="row mt-3 mb-4">
									<div class="label">
										<label>¿Que desea realizar con las situaciones?</label>
									</div>
									<div class="input">
										<select name="ra" id="ra" class="form-control form-control-sm" onchange="validarOpcionTema();">
											<option value="">SELECCIONAR</option>
											<option value="R">REGISTRAR NUEVO</option>
											<option value="A">ACTUALIZAR EXISTENTE</option>
											<option value="E">ELIMINAR EXISTENTE</option>
										</select>
									</div>      		
								</div>

							<!-- ACTUALIZAR -->
								<div class="row mt-3 mb-4" id="actualizar" style="display: none;">
									<div class="label">
										<label>Elija la situación a actualizar</label>
									</div>
									<div class="input">
										<select name="id_situacion" id="id_situacion" class="form-control form-control-sm" onchange="listarSituacionActualizar(this.value);">
											<option value="">SELECCIONAR</option>
											<?php foreach ($listarSituacionActaId as $lsai){ ?>
												<option value="<?php echo $lsai['id_situacion']; ?>"><?php echo $lsai['descripcion_situacion'] ?></option>
											<?php } ?>
										</select>
									</div>      		
								</div>

							<!--ELIMINAR-->
								<div class="row mt-3 mb-4" id="eliminar" style="display: none;">
									<div class="label">
										<label>Elija la situación a eliminar</label>
									</div>
									<div class="input">
										<select name="id_situacion" id="id_situacion" class="form-control form-control-sm" onchange="eliminarSituaciones(this.value, <?php echo $id_acta; ?>);" >
											<option value="">SELECCIONAR</option>
											<?php foreach ($listarSituacionActaId as $lsai){ ?>
												<option value="<?php echo $lsai['id_situacion']; ?>"><?php echo $lsai['descripcion_situacion'] ?></option>
											<?php } ?>
										</select>
									</div>      		
								</div>
			                        
								<div class="msjAlertaEliminar" id="msjAlertaEliminar">
									
								</div>

							<!--SITUACIÓN-->
								<div class="row mt-3" id="registrar"  style="display: none;">
									<div class="label">
										<label>Situación - Problema</label>
									</div>
									<div class="input">
										<textarea type="text" name="descripcion_situacion"  id="descripcion_situacion" class="form-control form-control-sm"></textarea>
									</div>      		
								</div>

							<!--SOLUCION-->
								<div class="row mt-3" id="registrar1"  style="display: none;">
									<div class="label">
										<label>Solución</label>
									</div>
									<div class="input">
										<textarea name="solucion_situacion" id="solucion_situacion" class="form-control form-control-sm"></textarea>
									</div>      		
								</div>

							<!--RESPONSABLE-->
								<div class="row mt-3" id="registrar2"  style="display: none;">
									<div class="label">
										<label>Responsable(s)</label>
									</div>
									<div class="input">
										<select  class="form-control form-control-sm selectpicker" multiple="multiple" data-live-search="true" id="id_responsable" name="id_responsable[]">
											<option value="">SELECCIONAR</option>
											<?php foreach ($listarTodosUsuarios as $lu){ ?>
												<option value="<?php echo $lu['id_usuario']; ?>"><?php echo $lu['nombre']; ?></option>
											<?php } ?>
										</select> 
									</div>      		
								</div>
								
								<div class="row mt-3" id="registrar6"  style="display: none;">
        		        	        <div class="label">
        		        		        <label>Estado Solucion</label>
        		        	        </div>
        		        	        <div class="input">
        		        	        	<select class="form-control form-control-sm selectpicker" data-live-search="true" id="estado_solucion" name="estado_solucion">
        		        	        		<option value="">SELECCIONAR</option>}
        		        	        		option
                                            <?php foreach ($listarEstadoSituacion as $est){ ?>
                                                <option value="<?php echo $est['id_estado']; ?>"><?php echo $est['detalle']; ?></option>
                                            <?php } ?>
                                        </select> 
        		        	        </div>      		
        		                </div>

							<!--REPORTAR A-->
								<div class="row mt-3" id="registrar3"  style="display: none;">
									<div class="label">
										<label>Reportar a</label>
									</div>
									<div class="input">
										<select class="form-control form-control-sm" id="id_reportar_a" name="id_reportar_a">
											<option value="">SELECCIONAR</option>}
											option
											<?php foreach ($listarTodosUsuarios as $lu){ ?>
												<option value="<?php echo $lu['id_usuario']; ?>"><?php echo $lu['nombre']; ?></option>
											<?php } ?>
										</select> 
									</div>      		
								</div>

							<!--FECHA LIMITE-->
								<div class="row mt-3" id="registrar4"  style="display: none;">
									<div class="label">
										<label>Fecha Limite</label>
									</div>
									<div class="input">
											<input type="text" name="fecha_limite" id="datepicker" class="form-control form-control-sm" >
									</div>      		
								</div>

								<!--PRIORIDAD-->
									<div class="row mt-3" id="registrar5"  style="display: none;">
										<div class="label">
											<label>Prioridad</label>
										</div>
										<div class="input">
											<select name="prioridad" id="prioridad" class="form-control form-control-sm">
												<option value="0">SELECCIONAR</option>
												<option value="1">BAJA</option>
												<option value="2">MEDIA</option>
												<option value="3">ALTA</option>
											</select>
										</div>      		
									</div>

									<div id="datosSituacionesActualizar">
								
									</div>
	                    	    

							<section class="col-12 mt-4 d-flex justify-content-center">
								<a href="Actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
								<button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
							</section>
	                    	    
					</form>
				</div>
			</section>

		</section>

	<!-- CONTENIDO -->
	
	<!-- ************************** -->


	<!-- SCRIPT -->
		<?php include("Template/scripts.php"); ?>
		
		<script type="text/javascript">

			function cerrar_modal(){
				document.getElementById('modal').style.display = "none";
			}

			function validar(){
				document.getElementById('guardar').innerHTML = 'Por favor espere';
				document.getElementById('guardar').disabled = true;

				return true;
			}

			function validarOpcionTema(){
				var opcion = document.getElementById('ra').value;

				if (opcion == 'A') {
					document.getElementById('actualizar').style.display = 'flex';
					document.getElementById('eliminar').style.display = 'none';
					document.getElementById('registrar').style.display = 'none';
					document.getElementById('registrar1').style.display = 'none';
					document.getElementById('registrar2').style.display = 'none';
					document.getElementById('registrar3').style.display = 'none';
					document.getElementById('registrar4').style.display = 'none';
					document.getElementById('registrar5').style.display = 'none';
					document.getElementById('registrar6').style.display = 'none';
				}else if (opcion == 'R') {
					document.getElementById('registrar').style.display = 'flex';
					document.getElementById('registrar1').style.display = 'flex';
					document.getElementById('registrar2').style.display = 'flex';
					document.getElementById('registrar3').style.display = 'flex';
					document.getElementById('registrar4').style.display = 'flex';
					document.getElementById('registrar5').style.display = 'flex';
					document.getElementById('registrar6').style.display = 'flex';
					document.getElementById('actualizar').style.display = 'none';
					document.getElementById('eliminar').style.display = 'none';
					document.getElementById('update').style.display = 'none';
					document.getElementById('update1').style.display = 'none';
					document.getElementById('update2').style.display = 'none';
					document.getElementById('update3').style.display = 'none';
					document.getElementById('update4').style.display = 'none';
					document.getElementById('update5').style.display = 'none';
					document.getElementById('update6').style.display = 'none';
				}else if (opcion == 'E') {
					/*MOSTRAR*/
						document.getElementById('eliminar').style.display = 'flex';
					/*OCULTAR*/
						document.getElementById('actualizar').style.display = 'none';
						document.getElementById('registrar').style.display = 'none';
						document.getElementById('registrar1').style.display = 'none';
						document.getElementById('registrar2').style.display = 'none';
						document.getElementById('registrar3').style.display = 'none';
						document.getElementById('registrar4').style.display = 'none';
						document.getElementById('registrar5').style.display = 'none';
						document.getElementById('registrar6').style.display = 'none';
				}else{

					document.getElementById('actualizar').style.display = 'none';
					document.getElementById('eliminar').style.display = 'none';
					document.getElementById('registrar').style.display = 'none';
					document.getElementById('registrar1').style.display = 'none';
					document.getElementById('registrar2').style.display = 'none';
					document.getElementById('registrar3').style.display = 'none';
					document.getElementById('registrar4').style.display = 'none';
					document.getElementById('registrar5').style.display = 'none';
					document.getElementById('registrar6').style.display = 'none';
					document.getElementById('update').style.display = 'none';
					document.getElementById('update1').style.display = 'none';
					document.getElementById('update2').style.display = 'none';
					document.getElementById('update3').style.display = 'none';
					document.getElementById('update4').style.display = 'none';
					document.getElementById('update5').style.display = 'none';
					document.getElementById('update6').style.display = 'none';
				}
			}

			function listarSituacionActualizar(id_situacion){
				var parametros = {
					"id_situacion" : id_situacion,
				};

				$.ajax({
					data:  parametros,
					url:   '../Controlador/listarSituacionesActaId.php',
					type:  'post',
					beforeSend: function () {
					},
					success:  function (response) {
						//alert(response);
						$("#datosSituacionesActualizar").html(response);
						$("#act_id_responsable").selectpicker('refresh');
					}
				});
			}

			function eliminarSituaciones(id_situacion, id_acta){
				//alert(id_acta + ' - ' + id_situacion);
				var parametros = {
					"id_situacion" : id_situacion,
					"id_acta" : id_acta,
				};

				$.ajax({
					data:  parametros,
					url:   '../Controlador/eliminarSituacionesId.php',
					type:  'post',
					beforeSend: function () {
					},
					success:  function (response) {
						//alert(response);

						$("#msjAlertaEliminar").html(response);
					}
				});
			}

			$( function() {
				$( "#datepicker" ).datepicker({ dateFormat:'yy/mm/dd'}); 
				$( "#datepicker1" ).datepicker({ dateFormat:'yy/mm/dd'});
				
			} );
		</script>
	<!-- SCRIPT -->

</body>
</html>
