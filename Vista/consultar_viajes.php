<?php 







include ("../Controlador/Sesion/autenticar.php");







/* VARIABLES MENU*/







$titulo = 'Consultar Viajes';







$redireccion = 'inicioPasajeros.php';







$icono = 'fa fa-bus';















 ?>















<!DOCTYPE html>







<html>







<head>







    <meta charset="utf-8">







	<title>SistemaKV | Consultar Viajes</title>







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







         </ol>







    </div>























    <section class="form-usuarios mt-1">







        <div class="formulario mb-5">







            <!--FORMULARIO -->















	            <form method="POST" action="../Vista/listadoViajesDisponibles.php">	







			        <?php include("Template/header-form.php"); ?> 







					







						<!-- Fecha inicial -->







                          	<div class="row mt-4 mb-4 ">







                              	<div class="label">    







                                  	<label>Fecha</label>







                              	</div>







                              	<div class="input">    







                                  	<input type="date" name="fecha" id="datepicker" class="form-control">







                             	 </div>







                         	 </div>	                    







                   		<hr>







            







                    <!--Botones-->    







			        <div class="row justify-content-center botones-form mt-2 mb-5">

	<div class="boton mt-2">

			<a href="<?php echo $redireccion ?>" class="btn btn-danger btn-block">Cancelar</a>

	</div>



	<div class="boton mt-2">

		<button type="submit" class="btn btn-primary btn-block" id="guardar">Consultar</button>

	</div>

</div>






	            </form> 







        </div>







    </section>































    <?php include("Template/scripts.php"); ?>



</body>







</html>