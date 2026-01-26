<?php 
include("../Controlador/Sesion/autenticar.php");
require("../Modelo/Contrato.php");
$id_contrato = $_GET['id_contrato'];

$titulo = 'Asignar Usuarios al contrato';
$redireccion = 'usuariosContratosFijos.php';
$icono = 'fa fa-user-o';

$contrato = new Contrato();
$usu_contratos = $contrato->listarUsuariosPorContrato($id_contrato);
$cant_usc = count($usu_contratos);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SistemaKV | Asignar usuarios</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
    	<?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style type="text/css">
        	input[readonly] {
			    background-color: #fff !important;
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
		            <li class="breadcrumb-item " aria-current="page"><a href="usuariosContratosFijos.php">Usuarios Fijos</a></li>
					<li class="breadcrumb-item active" aria-current="page">Consultar Usuarios</li>
		         </ol>
		    </div>

	        <div class="notice notice-sistemakv">
	            <strong><i class="fa fa-user mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">ASIGNACIÓN DE USUARIOS</b></strong>
	        </div>

		    <section class="form-usuarios mb-5">
		        <div class="formulario mb-3">
		        	<form action="../Controlador/registrarUsuarioContratoFijo.php" method="POST">
						
						<table class="table mt-4">
							<thead>
								<tr>
									<th style="border: hidden;" class="text-center"><b>Nombres</b></th>
									<th style="border: hidden;" class="text-center"><b>N° de Identificación</b></th>
									<th style="border: hidden;" class="text-center"><b>Opciones</b></th>
								</tr>
							</thead>
							<tbody>
								<?php if($cant_usc > 0){ ?>
								<?php foreach($usu_contratos as $uc){ ?>
								<tr id="fila_<?php echo $uc['id'];?>">
									<td style="border: hidden; padding: 4px;">
										<div class="row">
											<span class="fa fa-user-circle-o mr-3 ml-3" style="font-size: 1.7rem; color: #1b2d3b;"></span>
											<input class="form-control form-control-sm col-9" type="text" name="nom_usu[]" readonly="readonly" value="<?php echo $uc['nombre_usuario'];?>" />
										</div>
									</td>
									<td style="border: hidden; padding: 4px;">
											<input class="form-control form-control-sm col-12" type="text" name="num_usu[]" readonly="readonly" value="<?php echo $uc['numero_documento'];?>" />
									</td>
									<td style="border: hidden; padding: 4px; text-align: center"> 
											<button style="margin: 0px; padding: 0px 4px 0px 4px;" class="btn btn-danger" type="button" onclick="borrar_usuario(<?php echo $uc['id'];?>)"><i class="fa fa-trash"></i></button>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td colspan="3" align="center">SIN USUARIOS ACTUALMENTE</td>
								</tr>	
								<?php } ?>
							</tbody>
						</table>
					
		                <section class="m-5 p-4" style="border:1px dashed #d1d1d1;">

					        <div class="notice notice-sistemakv">
					            <strong><i class="fa fa-user mr-3" style="font-size: 2rem;"></i>AGREGAR NUEVOS USUARIOS</strong>
					        </div>

	 						<div class="row m-5 p-3">

		                        <input type="hidden" name="id_contrato" id="id_contrato" class="form-control" value="<?php echo $id_contrato ?>">
		                    	
		                    	<div class="label">
		                    		<label><b>¿Cuantos usuarios desea agregar al contrato?</b></label>
		                    	</div>
		                    	<div class="input ml-3">
		                    		<input type="text" name="cantidad_usuarios" id="cantidad_usuarios" class="form-control" onkeyup="crearFilaInput()">
		                    	</div>

				            </div>

			                <table id="input-group" class="table">    
			  				</table>
			            </section>

	                    <section class="col-12 mt-4 d-flex justify-content-center">
	                        <a href="usuariosContratosFijos.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
	                        <button type="submit" class="btn btn-outline-info col-3">Guardar</button>
	                    </section>


		            </form>
		        </div>
		    </section>

		</section>

    <!-- FIN CONTENIDO -->

    <!-- ************************** --->
	
	<!-- SCRIPT -->
    
    	<?php include("Template/scripts.php"); ?>

	    <script type="text/javascript">

	    	function crearFilaInput(){

	            var cantidad_usuarios = document.getElementById('cantidad_usuarios').value;

	            if(cantidad_usuarios > 0){
				    var parametros = {
				       "cantidad_usuarios" : cantidad_usuarios
				    };

				    $.ajax({
				        data:  parametros, //datos que se envian a traves de ajax
				        url:   '../Controlador/crearFilaInput.php', //archivo que recibe la peticion
				        type:  'post', //método de envio
				        beforeSend: function () {
				                $("#input-group").html("Procesando, espere por favor...");
				        },
				        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
				                /*alert(response);*/
				                $("#input-group").html(response);
				        }
				    });
	 			}
	    	}
			
			function borrar_usuario(id){
				
				var parametros = {
				       "id" : id
				};
				$.ajax({
				        data:  parametros, //datos que se envian a traves de ajax
				        url:   '../Controlador/borrarRegistroUsuarioFijo.php', //archivo que recibe la peticion
				        type:  'post', //método de envio
				        beforeSend: function () {
				                //$("#input-group").html("Procesando, espere por favor...");
				        },
				        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
				            document.getElementById('fila_'+id).style.display = 'none';
				        }
				    });
			}	
	    </script>

	<!-- FIN SCRIPT -->
    
</body>
</html>
</html>