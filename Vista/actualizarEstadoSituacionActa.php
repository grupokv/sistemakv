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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Estado Situacion</title>
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
					<li class="breadcrumb-item active" aria-current="page">Actualizar Estado Situacion</li>
				</ol>
			</div>
			
			<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-file-text  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR ESTADO SITUACION</b></strong>
          	</div>

			<section class="form-usuarios">
				<div class="formulario mb-5">
					<form action="../Controlador/actualizarEstadoSituacionActa.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
						
						<input type="hidden" name="id_acta" id="id_acta" value="<?php echo $id_acta; ?>">								
								
							
	                    	    <div class="row mt-3" id="registrar">
	                    	        <table border="1" class="table table-hover table-sm display text-center" style="width:100%">
	                    	           <tr align="center">
	                    	               <th width="50%">ACTIVIDAD</th>
	                    	               <th width="30%">RESPONSABLE</th>
	                    	               <th>ESTADO</th>
	                    	           </tr>
	                    	           <?php foreach ($listarSituacionActaId as $lsai){ ?>
	                    	           <input type="hidden" name="id_situacion[]" id="id_situacion" value="<?php echo $lsai['id_situacion'];?>"/>
	                    	           <tr>
	                    	               <td>
	                    	                   <?php echo $lsai['solucion_situacion'];?>
	                    	               </td>
	                    	               <td>
	                    	                   <?php $users = explode(",",$lsai['id_responsable']); ?>
	                    	                   <?php 
	                    	                        for($i=0;$i<=count($users);$i++){
	                    	                            $datos_usu = $usuario->listarUsuarioPorId($users[$i]);
	                    	                            echo $datos_usu[0]['nombre'].'<br/>';
	                    	                        }     
	                    	                   ?>
	                    	               </td>
	                    	               <td>
	                    	                   <?php if($lsai['estado_solucion'] != '2'){ ?>
	                    	                   <select class="form-control form-control-sm" id="estado_solucion_<?php echo $lsai['id_situacion'];?>" name="estado_solucion_<?php echo $lsai['id_situacion'];?>">
                		        	        		<option value="0">SELECCIONAR</option>}
                		        	        		option
                                                    <?php foreach ($listarEstadoSituacion as $est){ ?>
                                                        <option value="<?php echo $est['id_estado']; ?>" <?php if($lsai['estado_solucion'] == $est['id_estado']) { ?> selected="selected" <?php } ?>><?php echo $est['detalle']; ?></option>
                                                    <?php } ?>
                                               </select>
                                               <?php } else { echo "CERRADA"; } ?>
	                    	               </td>
	                    	           </tr>
	                    	           <?php } ?>
	                    	        </table>
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
				}else if (opcion == 'R') {
					document.getElementById('registrar').style.display = 'flex';
					document.getElementById('registrar1').style.display = 'flex';
					document.getElementById('registrar2').style.display = 'flex';
					document.getElementById('registrar3').style.display = 'flex';
					document.getElementById('registrar4').style.display = 'flex';
					document.getElementById('registrar5').style.display = 'flex';
					document.getElementById('actualizar').style.display = 'none';
					document.getElementById('eliminar').style.display = 'none';
					document.getElementById('update').style.display = 'none';
					document.getElementById('update1').style.display = 'none';
					document.getElementById('update2').style.display = 'none';
					document.getElementById('update3').style.display = 'none';
					document.getElementById('update4').style.display = 'none';
					document.getElementById('update5').style.display = 'none';
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
				}else{

					document.getElementById('actualizar').style.display = 'none';
					document.getElementById('eliminar').style.display = 'none';
					document.getElementById('registrar').style.display = 'none';
					document.getElementById('registrar1').style.display = 'none';
					document.getElementById('registrar2').style.display = 'none';
					document.getElementById('registrar3').style.display = 'none';
					document.getElementById('registrar4').style.display = 'none';
					document.getElementById('registrar5').style.display = 'none';
					document.getElementById('update').style.display = 'none';
					document.getElementById('update1').style.display = 'none';
					document.getElementById('update2').style.display = 'none';
					document.getElementById('update3').style.display = 'none';
					document.getElementById('update4').style.display = 'none';
					document.getElementById('update5').style.display = 'none';
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
