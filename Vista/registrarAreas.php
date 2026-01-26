<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");

$empresa = new Empresa();
$listar = $empresa->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Area</title>
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

    <!-- ************************************ -->

    <!-- CONTENIDO -->

	    <section class="home_content">

			<div aria-label="breadcrumb" class="mt-1"> 
		         <ol class="breadcrumb" style="background-color: #fff;">
		            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
		            <li class="breadcrumb-item " aria-current="page"><a href="Areas.php">Areas</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Registrar areas</li>
		         </ol>
		    </div>

      		<div class="notice notice-sistemakv">
          		<strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR ÁREA</b></strong>
      		</div>


		    <section class="form-usuarios mt1">
		        <div class="formulario mb-5">

		            <form action="../Controlador/registrarArea.php" method="POST">

						<!--NOMBRE AREA-->
							<div class="row mt-3">
								<div class="label">
									<label><b>Nombre Área</b></label>
								</div>
								<div class="input">
								    <input type="text" name="nombre_area" id="nombre_area" class="form-control">
								</div>
						    </div>
							        
						<!--ID EMPRESA-->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label><b>Empresa</b></label>
						        </div>
						        <div class="input">
						      		<select class="form-control selectpicker" data-live-search="true" name="id_empresa" id="id_empresa">
						        		<option value="">SELECCIONAR</option>
						        		<?php foreach ($listar as $le){ ?>
						        			<option value="<?php echo $le['id_empresa'] ?>">
						        				<?php echo $le['nombre_empresa'] ?>
						        			</option>
						        		<?php } ?>
						      		</select>
						        </div>
						    </div>

						<section class="col-12 mt-4 d-flex justify-content-center">
		        			
		        			<a href="areas.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>

	                        <button type="submit" id="buttonsKV" class="btn col-3">Registrar</button>

	                    </section>

		            </form>

		        </div>
		    </section>

		</section>

    <!-- FIN CONTENIDO -->

    <!-- ************************************ -->

    <!-- SCRIPT -->
    	<?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->
</body>
</html>

