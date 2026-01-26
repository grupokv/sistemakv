<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");

$titulo = 'Actualizar Categoria Mantenimiento';
$redireccion = 'categorias_mantenimiento.php';
$icono = 'fa fa-cog';

$id = $_GET['id'];

if (!isset($id)) {
    
}else{
    $categoria = new Categoria_Mantenimiento();
    $listarId = $categoria->listarPorId($id);
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar categoria mantenimiento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="categorias_mantenimiento.php">Categorias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar categoria</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarCategoriaMantenimiento.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_categoria'] ?>"  name="id" id="id" class="form-control">

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Detalle Categoria</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['detalle_categoria'] ?>"  name="nombre_cat" id="nombre_cat" class="form-control">
                                    <input type="hidden" value="<?php echo $lis['detalle_categoria'] ?>"  name="nombre_cat_act" id="nombre_cat_act" class="form-control">
            		        	</div>
            		        </div>

                    <?php } ?>
                <?php include("Template/bottom-form.php") ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>