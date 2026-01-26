<?php 
require_once("../Modelo/Cotizador.php");
//include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Conceptos Generales Cotizador';
$redireccion = '';
$icono = 'fa fa-briefcase';

$cotizacion = new Cotizador();
$listar = $cotizacion->listarDatosGenerales();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Conceptos Generales Cotizador</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
	        <form action="../Controlador/actualizarConceptosGeneralesCotizador.php" method="POST">
	        	
	        		<?php include("Template/header-form.php") ?>

				        <input type="hidden" value="<?php echo '1'; ?>" name="id" id="id" class="form-control">
			        		
				        
					  	<div class="row mt-3 ">
					        	<div class="label">
						            <label>Precio Galon Combustible</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['galon_combustible']; ?>" name="galon" id="galon" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['galon_combustible']; ?>" name="galon_act" id="galon_act" class="form-control">
					        	</div>
					        </div>
	
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Valor Dia Alimentacion</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['alimentacion_dia']; ?>" name="alimentacion" id="alimentacion" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['alimentacion_dia']; ?>" name="alimentacion_act" id="alimentacion_act" class="form-control">
					        	</div>
					        </div>	

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Valor Dia Hospedaje</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['hospedaje_dia']; ?>" name="hospedaje" id="hospedaje" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['hospedaje_dia']; ?>" name="hospedaje_act" id="hospedaje_act" class="form-control">
					        	</div>
					        </div>	
					
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Porcentaje Utilidad</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo ($listar[0]['porc_pernotado']-100); ?>" name="utilidad" id="utilidad" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['porc_pernotado']; ?>" name="utilidad_act" id="utilidad_act" class="form-control">
					        	</div>
					        </div>		        
				        
                    <?php include("Template/bottom-form.php") ?>
	        	
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>