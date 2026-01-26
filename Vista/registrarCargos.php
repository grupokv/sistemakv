<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Area.php");

$empresa = new Empresa();
$listar = $empresa->listar();

$area = new Area();
$listarA = $area->listar();


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Cargo</title>
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
		            <li class="breadcrumb-item " aria-current="page"><a href="cargos.php">Cargos</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Registrar cargos</li>
		         </ol>
		    </div>

      		<div class="notice notice-sistemakv">
          		<strong><i class="fa fa-briefcase mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REGISTRAR CARGO</b></strong>
      		</div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarCarg.php" method="POST">

				<!--NOMBRE CARGO-->
					<div class="row mt-3">
					    <div class="label">
						    <label>Nombre cargo</label>
					    </div>
					    <div class="input">
					        <input type="text" name="nombre_cargo" id="nombre_cargo" class="form-control">
					    </div>
					</div>
				        
				<!--ID AREA-->
					<div class="row mt-3">
					    <div class="label">
					        <label>Area</label>
					    </div>
					    <div class="input">
					        <select class="form-control selectpicker" data-live-search="true" name="id_area" id="id_area">
					        	<option value="">SELECCIONAR</option>
					        	<?php foreach ($listarA as $la){ ?>
					        		<option value="<?php echo $la['id_area'] ?>">
					        			<?php echo $la['nombre_area'] ?>
					        		</option>
					        	<?php } ?>
					        </select>
					    </div>
					</div>

				<!--ID EMPRESA-->
					<div class="row mt-3">
					    <div class="label">
					        <label>Empresa</label>
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
        			<a href="cargos.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                    <button type="submit" id="buttonsKV" class="btn col-3">Registrar</button>
                </section>

            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
</body>
</html>

