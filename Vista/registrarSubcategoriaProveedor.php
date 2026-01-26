<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Subcategoria_Mantenimiento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar costos por proveedor';
$redireccion = 'proveedores_mantenimiento.php';
$icono = 'fa fa-users';


$subcategoriaMantenimiento = new Subcategoria_Mantenimiento();
$listar = $subcategoriaMantenimiento->listar();

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Area</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="proveedores_mantenimiento.php">Registro costos por servicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Costos Proveedores</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/registrarsubcateProve.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 
				
					<input type="hidden" name="id_proveedor" id="id_proveedor" value="<?php echo $_GET['id'] ?>">

					<!--ID EMPRESA-->
					    <div class="row mt-3 mb-4">
					        <div class="label">
					            <label>Sub Categoria</label>
					        </div>
					        <div class="input">
					      		<select class="form-control selectpicker" data-live-search="true" name="id_subcategoria" id="id_subcategoria">
					        		<option>Seleccionar Operación</option>
					        		<?php foreach ($listar as $l){ ?>
					        			<option value="<?php echo $l['id_subcategoria'] ?>">
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
							    <input type="text" name="costo" id="costo" class="form-control">
							</div>
					    </div>
			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

