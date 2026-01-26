<?php 
require_once("../Modelo/Area.php");
require_once("../Modelo/EmpresaEnt.php");
include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Actualizar Area';
$redireccion = 'areas.php';
$icono = 'fa fa-users';

$empresa = new Empresa();
$listar = $empresa->listar();

$id_area = $_GET['id_area'];

if (!isset($id_area)) {
}else{
   $area = new Area();
   $listarPorId = $area->listarPorId($id_area);

}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar areas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="empresas.php">Areas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar areas</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
           
	        <form action="../Controlador/actualizarArea.php" method="POST">
	        	<?php foreach ($listarPorId as $li){ ?>
	        		<?php include("Template/header-form.php"); ?>
	        	
		        	<!--ID AREA-->
			        <input type="hidden" name="id_area" id="id_area" value="<?php echo $li['id_area'] ?>" class="form-control">

		        	
			        <!--NOMBRE AREA-->
			        <div class="row mt-3">
			        	<div class="label">
				            <label>Nombre area</label>
			        	</div>
			        	<div class="input">
			        		<input type="text" name="nombre_area" id="nombre_area" value="<?php echo $li['nombre_area'] ?>" class="form-control">
			        		<input type="hidden" name="nombre_area_act" id="nombre_area_act" value="<?php echo $li['nombre_area'] ?>" class="form-control">
			        	</div>
			        </div>
			        
			        <!--ID EMPRESA-->
			        <div class="row mt-3 mb-4">
			        	<div class="label">
			                <label>Empresa</label>
			            </div>
			        	<div class="input">
			        		<select class="form-control selectpicker" data-live-search="true" name="id_empresa" id="id_empresa" >
			        			<?php foreach ($listar as $le){ ?>
			        				<option value="<?php echo $le['id_empresa'] ?>" <?php if ($le['id_empresa'] == $li['id_empresa']) { ?> selected="selected" <?php  } ?>>
			        					<?php echo $le['nombre_empresa'] ?>
			        				</option>
			        			<?php } ?>
			        		</select>

			        		<input type="hidden" name="id_empresa_act" id="id_empresa_act" value="<?php echo $li['id_empresa'] ?>" class="form-control">
			            </div>
			        </div>

	        	<?php } ?>

	        	<?php include("Template/bottom-form.php"); ?>

	        </form>


        </div>
    </section>
    <label>Nombre: </label>
    <input type="text" name="nombre">
    <br>
    <label>Apellido: </label>
    <input type="text" name="apellido">


    <?php include("Template/scripts.php"); ?>


</body>
</html>