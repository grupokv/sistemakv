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

$listarTemasActa = $acta->listarTemaActaId($id_acta);



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
					<li class="breadcrumb-item " aria-current="page"><a href="actas.php">Actas</a></li>
					<li class="breadcrumb-item active" aria-current="page">Actualizar Actas</li>
				</ol>
			</div>

			<div class="notice notice-sistemakv" style="background-color: #fff;">
              	<strong><i class="fa fa-file-text  mr-3" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTUALIZAR ACTA</b></strong>
          	</div>

			<section class="form-usuarios">
				<div class="formulario mb-5">
					<form action="../Controlador/actualizarTemaActa.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
				
						<input type="hidden" name="id_acta" id="id_acta" value="<?php echo $id_acta; ?>">
								
						<!--TEMAS-->
							<div class="row mt-3 mb-4">
								<div class="label">
									<label>¿Que desea realizar con los temas?</label>
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

						<!--ACTUALIZAR-->
							<div class="row mt-3 mb-4" id="actualizar" style="display: none;">
								<div class="label">
									<label>Elija el tema a actualizar</label>
								</div>
								<div class="input">
									<select name="id_agendaAct" id="id_agendaAct" class="form-control form-control-sm" onchange="listarTemasActualizar(this.value);">
										<option value="">SELECCIONAR</option>
										<?php foreach ($listarTemasActa as $lta){ ?>
											<option value="<?php echo $lta['id_agenda']; ?>"><?php echo $lta['nombre_tema'] ?></option>
										<?php } ?>
									</select>
								</div>      		
							</div>

						<!--ELIMINAR-->
							<div class="row mt-3 mb-4" id="eliminar" style="display: none;" >
								<div class="label">
									<label>Elija el tema a eliminar</label>
								</div>
								<div class="input">
									<select name="id_agenda" id="id_agenda" class="form-control form-control-sm" onchange="eliminarSituaciones(this.value, <?php echo $id_acta ?>);">
										<option value="">SELECCIONAR</option>
										<?php foreach ($listarTemasActa as $lta){ ?>
											<option value="<?php echo $lta['id_agenda']; ?>"><?php echo $lta['nombre_tema'] ?></option>
										<?php } ?>
									</select>
								</div>      		
							</div>

							<div class="msjAlertaEliminar" id="msjAlertaEliminar">
								
							</div>

						<!-- TEMA -->
							<div class="row mt-3" id="registrar" style="display: none;">
								<div class="label">
									<label>Tema a tratar</label>
								</div>
								<div class="input">
									<input type="text" name="nombre_tema"  id="nombre_tema" class="form-control form-control-sm" >
								</div>      		
							</div>

						<!-- DESCRIPCION -->
							<div class="row mt-3" id="registrar1" style="display: none;">
								<div class="label">
									<label>Descripción</label>
								</div>
								<div class="input">
									<textarea name="descripcion_tema" id="descripcion_tema" class="form-control form-control-sm"></textarea>
								</div>      		
							</div>

							<div id="datosTemasActualizar">
								
							</div>

						<section class="col-12 mt-4 d-flex justify-content-center">
							<a href="actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
							<button type="submit" id="buttonsKV" class="btn col-3">Actualizar</button>
						</section>
	                    	    
	        		</form>
        		</div>
    		</section>
		
		</section>

	<!-- CONTENIDO -->

	<!-- ************************** -->

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
        	}else if (opcion == 'R') {
				document.getElementById('registrar').style.display = 'flex';
				document.getElementById('registrar1').style.display = 'flex';
        		document.getElementById('eliminar').style.display = 'none';
        		document.getElementById('actualizar').style.display = 'none';
        		document.getElementById('update1').style.display = 'none';
        		document.getElementById('update').style.display = 'none';
        	}else if(opcion == 'E'){
        		document.getElementById('eliminar').style.display = 'flex';
        		document.getElementById('registrar').style.display = 'none';
				document.getElementById('registrar1').style.display = 'none';
        		document.getElementById('actualizar').style.display = 'none';
        	}else{
        		document.getElementById('eliminar').style.display = 'none';
        		document.getElementById('actualizar').style.display = 'none';
        		document.getElementById('registrar').style.display = 'none';
        		document.getElementById('registrar1').style.display = 'none';
        		document.getElementById('update').style.display = 'none';
        		document.getElementById('update1').style.display = 'none';
        	}
        }

        function listarTemasActualizar(id_tema){
        	var parametros = {
                "id_tema" : id_tema,
              };

              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarTemasActaId.php',
                  type:  'post',
                  beforeSend: function () {
                  },
                  success:  function (response) {
                      $("#datosTemasActualizar").html(response);
                      
                  }
              });
        }

        function eliminarSituaciones(id_agenda, id_acta){
        	alert(id_acta + ' - ' + id_agenda);
        	var parametros = {
                "id_agenda" : id_agenda,
                "id_acta" : id_acta,
              };

              $.ajax({
                  data:  parametros,
                  url:   '../Controlador/listarModalEliminarTemasId.php',
                  type:  'post',
                  beforeSend: function () {
                  },
                  success:  function (response) {
                  	//alert(response);

                    $("#msjAlertaEliminar").html(response);
                  }
              });
        }

    </script>

</body>
</html>
