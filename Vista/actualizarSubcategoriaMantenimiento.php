<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");
require_once("../Modelo/Subcategoria_Mantenimiento.php");

$titulo = 'Actualizar Subcategoria Mantenimiento';
$redireccion = 'categorias_mantenimiento.php';
$icono = 'fa fa-cog';

$id = $_GET['id'];

if (!isset($id)) {
    
}else{
    $categoria = new Categoria_Mantenimiento();
    $subcategoria = new Subcategoria_Mantenimiento();
    $listarId = $subcategoria->listarPorId($id);
    $listadoCat = $categoria->listar();
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
	        <form action="../Controlador/actualizarSubcategoriaMantenimiento.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_subcategoria'] ?>"  name="id" id="id" class="form-control">
                            <input type="hidden" value="<?php echo $lis['id_categoria'] ?>"  name="id_cat_act" id="id_cat_act" class="form-control">
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Categoria</label>
                                </div>
                                <div class="input">
                                    <select name="id_cat" id="id_cat" required="required" class="form-control">
                                        <option value="">Seleccione</option>
                                        <?php foreach($listadoCat as $lp){ ?>
                                        <option value="<?php echo $lp['id_categoria'];?>" <?php if($lis['id_categoria'] == $lp['id_categoria']) { ?> selected="selected" <?php } ?> >
                                            <?php echo $lp['detalle_categoria'];?>
                                        </option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Detalle Categoria</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['detalle_subcategoria'] ?>"  name="nombre_cat" id="nombre_cat" class="form-control">
                                    <input type="hidden" value="<?php echo $lis['detalle_subcategoria'] ?>"  name="nombre_cat_act" id="nombre_cat_act" class="form-control">
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