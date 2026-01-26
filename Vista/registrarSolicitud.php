<?php 

include ("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Cliente.php");



/* VARIABLES MENU*/

$titulo = 'Registrar Solicitud';

$redireccion = 'programacion_solicitudes.php';

$icono = 'fa fa-calendar';





$clientes = new Cliente();

if(($_SESSION['id_usuario'] == 1)or($_SESSION['id_usuario'] == 2)){

	$listar = $clientes->listar();

} else {

	$listar = $clientes->listar_programacion($_SESSION['id_usuario']);	

}



?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

	<title>SistemaKV | Registrar Solicitud</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    

    <?php include("Template/styles.php"); ?>

    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">

</head>

<body>



    <?php include("Template/menu.php"); ?>





	<div aria-label="breadcrumb" class="mt-1"> 

         <ol class="breadcrumb">

            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>

            <li class="breadcrumb-item " aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>

            <li class="breadcrumb-item active" aria-current="page">Registrar Solicitud</li>

         </ol>

    </div>



    <section class="form-usuarios mt1">

        <div class="formulario mb-5">



            <form action="../Controlador/registrarSolicitud.php" method="POST">

			    <?php include("Template/header-form.php"); ?> 

				

					

					        

					<!--ID CLIENTE-->

					    <div class="row mt-3 mb-4">

					        <div class="label">

					            <label>Cliente</label>

					        </div>

					        <div class="input">

					      		<select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente" required="required">

					        		<option value="">Seleccionar Cliente</option>

					        		<?php foreach ($listar as $le){ ?>

					        			<option value="<?php echo $le['id_cliente'] ?>">

					        				<?php $cli = $clientes->listarClientePorId($le['id_cliente']); echo $cli[0]['razon_social'] ?>

					        			</option>

					        		<?php } ?>

					      		</select>

					        </div>

					    </div>





					<div class="row mt-3">

						<div class="label">

							<label>Servicios Idas</label>

						</div>

						<div class="input">

						    <input type="text" name="idas" id="idas" class="form-control" onKeyPress="return solo_numeros(event)" value="0">

						</div>

				    </div>



				    <div class="row mt-3">

						<div class="label">

							<label>Servicios Retornos</label>

						</div>

						<div class="input">

						    <input type="text" name="retornos" id="retornos" class="form-control" onKeyPress="return solo_numeros(event)" value="0">

						</div>

				    </div>



			    <?php include("Template/bottom-form.php"); ?>



            </form>

        </div>

    </section>





    <?php include("Template/scripts.php"); ?>

</body>

</html>



