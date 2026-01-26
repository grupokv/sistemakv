<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Subcategoria_Mantenimiento.php");
require_once("../Modelo/ProveedorMantenimiento.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar costos por proveedor';
$redireccion = 'proveedores_mantenimiento.php';
$icono = 'fa fa-users';


$subcategoriaMantenimiento = new Subcategoria_Mantenimiento();
$listar = $subcategoriaMantenimiento->listar();

$proveedorMantenimiento = new  ProveedorMantenimiento();
$listarPorId = $proveedorMantenimiento-> listarSPPorId($_GET['id']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar costos por proveedor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Areas.php">Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Costos Proveedores</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/registrarsubcateProve.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 

			    	<?php foreach ($listarPorId as $lsppi){ ?>

						<input type="hidden" name="id" id="id" value="<?php echo $_GET['id'] ?>">

						<!--ID EMPRESA-->
						    <div class="row mt-3 mb-4">
						        <div class="label">
						            <label>Sub Categoria</label>
						        </div>
						        <div class="input">
						      		<select class="form-control" name="id_subcategoria" id="id_subcategoria">
						        		<?php foreach ($listar as $l){ ?>
						        			<option value="<?php echo $l['id_subcategoria'] ?>" <?php if($lsppi['id_subcategoria'] == $l['id_subcategoria']) { ?> selected="selected" <?php } ?>>
						        				<?php echo $l['detalle_subcategoria'] ?>
						        			</option>
						        		<?php } ?>
						      		</select>
						        </div>
						    </div>

						<!--NOMBRE AREA-->
							<div class="row mt-3">
								<div class="label">
									<label>Costo del servicio</label>
								</div>
								<div class="input">
								    <input type="text" name="costo" id="costo" class="form-control" value="<?php echo $lsppi['costo'] ?>">
								</div>
						    </div>
			    	<?php } ?>
				
			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

