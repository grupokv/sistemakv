<?php 
require_once("../Modelo/Cliente.php");
require_once("../Modelo/CargoCliente.php");
include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Actualizar Cargo Cliente';
$redireccion = 'cargo_cliente.php';
$icono = 'fa fa-briefcase';


$cliente = new Cliente();
$listar = $cliente->listar();
$id_cargo = $_GET['id_cargo'];

if (!isset($id_cargo)) {
}else{
   $cargo = new CargoCliente();
   $listarCargoId = $cargo->listarCargosPorId($id_cargo);

}


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Cargo Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="cargo_cliente.php">Cargos Cliente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar cargo cliente</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
	        <form action="../Controlador/actualizarCargoCliente.php" method="POST">
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
					        		<input type="text" value="<?php echo $lci['detalle'] ?>" name="nombre_cargo" id="nombre_cargo" class="form-control">
					        	</div>
					        </div>
				        
				        <!--ID AREA-->
					        <div class="row mt-3 ">
					        	<div class="label">
					                <label>Cliente</label>
					            </div>
					        	<div class="input">
					                <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente">
					        			<option>Seleccionar </option>
					        			<?php foreach ($listar as $la){ ?>
					        				<option value="<?php echo $la['id_cliente'] ?>" <?php if ($la['id_cliente'] == $lci['id_cliente']) { ?> selected="selected" <?php  } ?>>
					        					<?php echo $la['razon_social'] ?>
					        				</option>
					        			<?php } ?>
					        		</select>
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