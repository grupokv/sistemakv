<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");

$categorias = new Categoria_Mantenimiento();
$listado = $categorias->listar();

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>SistemaKV | Categorias Mantenimiento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

        <section class="home_content">

            <div aria-label="breadcrumb" class="mt-1"> 
                <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categorias Mantenimiento</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">CATEGORIAS MANTENIMIENTO</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarCategoriaMantenimiento.php" class="btn" id="buttonsKV">Nueva Categoria <i class="fa fa-plus"></i></a>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>ID CATEGORIA</th>
                            <th>DETALLE</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listado as $lc){ ?>
            				<tr>
            					<td><?php echo $lc['id_categoria'] ?></td>
                                <td><?php echo $lc['detalle_categoria'] ?></td>
            					<td>
            						<!--Editar-->
            					    <a href="actualizarCategoriaMantenimiento.php?id=<?php echo $lc['id_categoria']; ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar categoria"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
            					</td>
            				</tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>
            
    <!-- FIN CONTENIDO -->


    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->
</body>
</html>