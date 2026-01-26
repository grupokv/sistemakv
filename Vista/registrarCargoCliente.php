<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
/* VARIABLES MENU*/
$titulo = 'Registrar Cargo Cliente';
$redireccion = 'cargo_cliente.php';
$icono = 'fa fa-briefcase';


$cliente = new Cliente();
$listar = $cliente->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Cargo Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="cargo_cliente.php">Cargos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar cargo cliente</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarCargoCliente.php" method="POST">
				<?php include("Template/header-form.php"); ?> 
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
						        <label>Cliente</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente">
						        	<option>Seleccionar </option>
						        	<?php foreach ($listar as $la){ ?>
						        		<option value="<?php echo $la['id_cliente'] ?>">
						        			<?php echo $la['razon_social'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>
				<?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
</body>
</html>

