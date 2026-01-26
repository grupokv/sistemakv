<?php 

include ("../Controlador/Sesion/autenticar.php");

/* VARIABLES MENU*/
$titulo = 'Buscar Servicio';
$redireccion = 'programacion_solicitudes.php';
$icono = 'fa fa-bus';

 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Buscar Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
    <style>
    .ui-datepicker-calendar{
    	display:none;
    }
	</style>
</head>
<body>



    <?php include("Template/menu.php"); ?>

    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Filtro</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Vista/resultadoBusquedaServicio.php">	
			        <?php include("Template/header-form.php"); ?> 
					
						  	<div class="row mt-4 mb-4 ">
                              	<div class="label">    
                                  	<label>Filtro Por</label>
                              	</div>
                              	<div class="input">    
                                  	<select class="form-control" name="filtro" id="filtro" required="required">
                                  	    <option value="">Seleccionar</option>
										<option value="1">Por Contacto</option>
                                  	    <option value="2">Por Solicitante</option>
										<option value="3">Por Origen</option>
										<option value="4">Por Destino</option>
                                  	</select>
                             	</div>
                         	 </div>
							 
							 <div class="row mt-4 mb-4 ">
                              	<div class="label">    
                                  	<label>Texto</label>
                              	</div>
                              	<div class="input">    
                                  	<input type="text" name="dato" id="dato" class="form-control" required="required">
                             	 </div>
                         	 </div>
	                    
                   		<hr>
            
                    <div class="row justify-content-center botones-form mt-2 mb-5">
						<div class="boton mt-2">
								<a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Volver</a>
						</div>

						<div class="boton mt-2">
							<button type="submit" class="btn btn-primary btn-block" id="guardar">Filtrar</button>
						</div>
					</div>
	            </form> 
        </div>
    </section>



    <?php include("Template/scripts.php"); ?>

</body>
</html>