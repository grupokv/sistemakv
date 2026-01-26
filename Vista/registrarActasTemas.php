<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';

$id_acta = $_GET['id_acta'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Actas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
		<?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
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
	            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Actas</a></li>
	            <li class="breadcrumb-item active" aria-current="page">Registrar Actas</li>
	         </ol>
	    </div>

		<div class="notice notice-sistemakv">
			<strong><i class="fa fa-file-text-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR ACTAS</b></strong>
		</div>

	    <section class="form-usuarios">
	        <div class="formulario mb-5 p-3">
		        <form action="../Controlador/registrarActaTemas.php" method="POST" enctype="multipart/form-data" onsubmit="return validar()">
					
						<!--ID ACTA-->
			        	    <input type="hidden" name="id_acta"  id="id_acta" class="form-control" value="<?php echo $id_acta ?>">
	                    
	                 	<!--TEMA-->
			                <div class="row mt-3">
			        	        <div class="label">
			        		        <label>Tema a tratar</label>
			        	        </div>
			        	        <div class="input">
			        	            <input type="text" name="nombre_tema"  id="nombre_tema" class="form-control" required="required">
			        	        </div>      		
			                </div>

			           	<!--DESCRIPCION-->
			                <div class="row mt-3">
			        	        <div class="label">
			        		        <label>Descripción</label>
			        	        </div>
			        	        <div class="input">
			        	        	<textarea name="descripcion_tema" id="descripcion_tema" class="form-control" required="required"></textarea>
			        	        </div>      		
			                </div>


					<section class="col-12 mt-4 p-1 d-flex justify-content-center">
						<a href="Actas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
						<button type="submit" class="btn btn-outline-info col-3">Continuar</button>
					</section>

	                   
		        </form>
	        </div>
	    </section>
	
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