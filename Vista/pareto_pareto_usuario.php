<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';

$id_acta = $_GET['id_acta'];

/* VARIABLES MENU*/
$titulo = 'Pareto Usuario';
$redireccion = '';
$icono = 'fa fa-line-chart';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Pareto Usuario</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="pareto_actual.php">Pareto</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pareto Usuario</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="" method="POST" onsubmit="return validar()">
				<?php include("Template/header-form.php"); ?> 
				
                 	<!--USUARIO-->
		                <div class="row mt-3">
		        	        <div class="label">
		        		        <label>Usuario</label>
		        	        </div>
		        	        <div class="input">
								<select name="usuario" id="usuario" class="form-control selectpicker" data-live-search="true">
									<option value="0">SELECCIONAR</option>
								</select>
		        	        </div>      		
		                </div>
                   
			    <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
    <script type="text/javascript">

        function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }


    </script>
</body>
</html>