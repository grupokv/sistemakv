<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Subcategoria Mantenimiento';
$redireccion = 'subcategorias_mantenimiento.php';
$icono = 'fa fa-cog';

$categorias = new Categoria_Mantenimiento();
$listadoCat = $categorias->listar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Subcategoria Mantenimiento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="subcategorias_mantenimiento.php">Subcategorias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Subcategoria</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
	        <form action="../Controlador/registrarSubcategoriaMantenimiento.php" method="POST">
	        	<?php include("Template/header-form.php"); ?>
                    <!--NOMBRE AREA-->
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Categoria</label>
                            </div>
                            <div class="input">
                                <select name="id_cat" id="id_cat" required="required" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Seleccione</option>
                                    <?php foreach($listadoCat as $lp){ ?>
                                    <option value="<?php echo $lp['id_categoria'];?>"><?php echo $lp['detalle_categoria'];?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Detalle subcategoria</label>
                            </div>
                            <div class="input">
                                <input type="text" name="nombre_cat" id="nombre_cat" class="form-control" required="required">
                            </div>
                        </div>
                <?php include("Template/bottom-form.php"); ?>
	        </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>