<?php 
require_once("../Modelo/General.php");

$id_referenciador = base64_decode($_GET['id_referenciador']);



?>
<!DOCTYPE html>
<html>
<head>    
	<meta charset="utf-8">	
	<title>SistemaKV | Data Operativa</title>    
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">        
	<?php include("Template/styles.php"); ?>    

	<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">   

	<style type="text/css" media="screen">      

		::-webkit-input-placeholder{
			font-size:10px;
		}
		::-moz-placeholder {
			font-size:10px;
		}
		:-ms-input-placeholder { 
			font-size:10px;
		}
		:-moz-placeholder { 
			font-size:10px;
		}


		option {
			color: #6c757d;
		}


		select { 
			color: #6c757d !important;
		}

	</style>

</head>

<body>    
	<section class="form-usuarios">        
		<div class="formulario mb-5">
			<form action="../Controlador/guardar_encuesta_notificacionPositiva.php" method="post">
				<table class="table table-condensed table-striped" style="font-size:0.7rem; margin-top: 30px;"> 
					<tbody>
						<tr>
							<td style="font-weight:bold; color:#989898;">
								<input type="hidden" name="id_referenciador" id="id_referenciador" value="<?php echo $id_referenciador; ?>">
								<div class="form-group">
									<label for="nombres">Nombres del Trabajador</label>
									<input type="text" class="form-control form-control-sm" id="nombres" name="nombres" required="required" placeholder="Nombres">
								</div>
								<div class="form-group">
									<label for="apellidos">Apellidos del Trabajador</label>
									<input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos" required="required" placeholder="Apellidos">
								</div>
								<div class="form-group">
									<label for="telefono">Teléfono</label>
									<input type="text" class="form-control form-control-sm" id="telefono" name="telefono" required="required" placeholder="TELEFONO">
								</div>
								<div class="form-group">
									<label for="direccion">Dirección</label>
									<input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required="required" placeholder="DIRECCION">
								</div>
								<div class="form-group">
									<label for="correo_electronico">Correo Electrónico</label>
									<input type="text" class="form-control form-control-sm" id="correo_electronico" name="correo_electronico" required="required" placeholder="CORREO ELECTRONICO">
								</div>
								<div class="form-group">
									<label for="cant_personas_contacto">¿Con cuantas personas a tenido contacto en los ultimos días?</label>
									<input type="number" class="form-control form-control-sm" id="cant_personas_contacto" name="cant_personas_contacto" required="required" placeholder="Cantidad de Personas" onkeyup="crearFilaInput();">
								</div>
							</td>
							
						</tr>						
					</tbody>                 
				</table> 
				<table id="input-group" class="table table-condensed table-striped">
					
				</table> 
				<table class="table table-condensed table-striped">
						<tr align="center">
							<td colspan="4"><button type="submit" class="btn btn-sm btn-success">ENVIAR</button></td>
						</tr>
				</table> 
			</form>
		</div>    
	</section>    

<?php include("Template/scripts.php"); ?>

<script>

function crearFilaInput(){

    var cant_personas_contacto = document.getElementById('cant_personas_contacto').value;

    if(cant_personas_contacto > 0){
	    var parametros = {
	       "cant_personas_contacto" : cant_personas_contacto
	    };

	    $.ajax({
	        data:  parametros, //datos que se envian a traves de ajax
	        url:   '../Controlador/crearFilaInputEncuesta.php', //archivo que recibe la peticion
	        type:  'post', //método de envio
	        beforeSend: function () {
	                $("#input-group").html("Procesando, espere por favor...");
	        },
	        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
	                /*alert(response);*/
	                $("#input-group").html(response);
                    document.getElementById('botones').style.display = "flex";
	        }
	    });
	}
}


</script>

</body>
</html>