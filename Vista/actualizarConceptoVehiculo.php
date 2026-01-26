<?php 
require_once("../Modelo/Cotizador.php");
//include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Conceptos Generales Cotizador';
$redireccion = '';
$icono = 'fa fa-briefcase';

$id = $_GET['id'];

$cotizacion = new Cotizador();
$listar = $cotizacion->listarTipoPorId($id);

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
            
	        <form action="../Controlador/actualizarConceptosVehiculosCotizador.php" method="POST">
	        	
	        		<?php include("Template/header-form.php") ?>

				        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" class="form-control">
			        		
				        
					  	<div class="row mt-3 ">
					        	<div class="label">
						            <label>Tipo Vehiculo</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['tipo_vehiculo']; ?>" name="tipo" id="tipo" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['tipo_vehiculo']; ?>" name="tipo_act" id="tipo_act" class="form-control">
					        	</div>
					        </div>
	
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Rendimiento Por Galon</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['rendimiento_kms']; ?>" name="rendimiento" id="rendimiento" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['rendimiento_kms']; ?>" name="rendimiento_act" id="rendimiento_act" class="form-control">
					        	</div>
					        </div>	

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Valor Peaje</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['valor_peaje']; ?>" name="peaje" id="peaje" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['valor_peaje']; ?>" name="peaje_act" id="peaje_act" class="form-control">
					        	</div>
					        </div>	
					
						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Valor Parqueadero</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['valor_parqueadero']; ?>" name="parqueadero" id="parqueadero" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['valor_parqueadero']; ?>" name="parqueadero_act" id="parqueadero_act" class="form-control">
					        	</div>
					        </div>		

						<div class="row mt-3 ">
					        	<div class="label">
						            <label>Valor Lavado</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $listar[0]['valor_lavado']; ?>" name="lavado" id="lavado" class="form-control">

					        		<input type="hidden" value="<?php echo $listar[0]['valor_lavado']; ?>" name="lavado_act" id="lavado_act" class="form-control">
					        	</div>
					        </div>	        
				        
                    <?php include("Template/bottom-form.php") ?>
	        	
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>