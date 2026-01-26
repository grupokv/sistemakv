<?php 
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Area.php");
require_once("../Modelo/Cargo.php");
include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Actualizar Cargo';
$redireccion = 'cargos.php';
$icono = 'fa fa-briefcase';


$empresa = new Empresa();
$listar = $empresa->listar();

$area = new Area();
$listarA = $area->listar();

$id_cargo = $_GET['id_cargo'];

if (!isset($id_cargo)) {
}else{
   $cargo = new Cargo();
   $listarCargoId = $cargo->listarCargosPorId($id_cargo);

}


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Cargo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="cargos.php">Cargos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar cargos</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
	        <form action="../Controlador/actualizarCarg.php" method="POST">
	        	<?php foreach ($listarCargoId as $lci){ ?>
	        		<?php include("Template/header-form.php") ?>
				        <!--ID CARGO-->

				        	<input type="hidden" value="<?php echo $lci['id_cargo']; ?>" name="id_cargo" id="id_cargo" class="form-control">
			        		
				        <!--NOMBRE CARGO-->
					        <div class="row mt-3 ">
					        	<div class="label">
						            <label>Nombre cargo</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $lci['nombre_cargo'] ?>" name="nombre_cargo" id="nombre_cargo" class="form-control">

					        		<input type="hidden" value="<?php echo $lci['nombre_cargo'] ?>" name="nombre_cargo_act" id="nombre_cargo_act" class="form-control">
					        	</div>
					        </div>
				        
				        <!--ID AREA-->
					        <div class="row mt-3 ">
					        	<div class="label">
					                <label>Area</label>
					            </div>
					        	<div class="input">
					                <select class="form-control selectpicker" data-live-search="true" name="id_area" id="id_area">
					        			<option>Seleccionar </option>
					        			<?php foreach ($listarA as $la){ ?>
					        				<option value="<?php echo $la['id_area'] ?>" <?php if ($la['id_area'] == $lci['id_area']) { ?> selected="selected" <?php  } ?>>
					        					<?php echo $la['nombre_area'] ?>
					        				</option>
					        			<?php } ?>
					        		</select>

					        		<input type="hidden" value="<?php echo $lci['id_area'] ?>" name="id_area_act" id="id_area_act" class="form-control">
					            </div>
					        </div>

			       		<!--ID EMPRESA-->
					        <div class="row mt-3  mb-5">
					        	<div class="label">
					                <label>Empresa</label>
					            </div>
					        	<div class="input">
					                <select class="form-control selectpicker" data-live-search="true" name="id_empresa" id="id_empresa">
					        			<option>Seleccionar </option>
					        			<?php foreach ($listar as $le){ ?>
					        				<option value="<?php echo $le['id_empresa'] ?>" <?php if ($le['id_empresa'] == $lci['id_empresa']) { ?> selected="selected" <?php  } ?>>
					        					<?php echo $le['nombre_empresa'] ?>
					        				</option>
					        			<?php } ?>
					        		</select>

					        		<input type="hidden" value="<?php echo $lci['id_empresa'] ?>" name="id_empresa_act" id="id_empresa_act" class="form-control">
					            </div>
					        </div>
                    <?php include("Template/bottom-form.php") ?>
	        	<?php } ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>