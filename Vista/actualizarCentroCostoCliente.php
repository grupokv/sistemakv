<?php 
require_once("../Modelo/Cliente.php");
require_once("../Modelo/CentroCostoCliente.php");
include ("../Controlador/Sesion/autenticar.php");

$titulo = 'Actualizar Centro Costo Cliente';
$redireccion = 'centro_costo_cliente.php';
$icono = 'fa fa-briefcase';


$cliente = new Cliente();
$listarC = $cliente->listar();
$id = $_GET['id'];

if (!isset($id)) {
}else{
   $cc = new CentroCostoCliente();
   $listar = $cc->listarPorId($id);

}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Centro Costo Cliente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="centro_costo_cliente.php">Centro Costo Cliente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Centro Costo</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
	        <form action="../Controlador/actualizarCentroCostoCliente.php" method="POST">
	        	<?php foreach ($listar as $lci){ ?>
	        		<?php include("Template/header-form.php") ?>
				        <!--ID CARGO-->

				        <input type="hidden" value="<?php echo $lci['id_centro_costo']; ?>" name="id" id="id" class="form-control">
			        		
				        <!--NOMBRE CARGO-->
					        <div class="row mt-3 ">
					        	<div class="label">
						            <label>Nombre</label>
					        	</div>
					        	<div class="input">
					        		<input type="text" value="<?php echo $lci['detalle'] ?>" name="nombre" id="nombre" class="form-control">
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
					        			<?php foreach ($listarC as $la){ ?>
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