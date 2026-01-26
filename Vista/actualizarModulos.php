<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/modulo.php");

$titulo = 'Actualizar Modulos';
$redireccion = 'modulos.php';
$icono = 'fa fa-cubes';


$id_modulo = $_GET['id_modulo'];

if (!isset($id_modulo)) {
    
}else{
    $modulo = new Modulo();
    $listarModId = $modulo->listarPorId($id_modulo);

    $listarModulos = $modulo->listar();
}


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Modulo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="modulos.php">Modulos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Modulos</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarMod.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarModId as $lmi){ ?>

                        <!--ID MODULO-->

                             <input type="hidden" value="<?php echo $lmi['id_modulo'] ?>"  name="id_modulo" id="id_modulo" class="form-control">

                        <!-- ESTADO-->

                            <input type="hidden" value="<?php echo $lmi['estado'] ?>"  name="estado" id="estado" class="form-control">

                        <?php if ($lmi['id_padre'] == 0) { ?>
                                <!--NOMBRE modulo-->
                                    <div class="row mt-3 mb-4">
                                        <div class="label">
                                            <label>Nombre Modulo</label>
                                        </div>
                                        <div class="input">
                                            <input type="text" value="<?php echo $lmi['nombre_modulo'] ?>"  name="nombre_modulo" id="nombre_modulo" class="form-control">
                                            <input type="text" value="<?php echo $lmi['nombre_modulo'] ?>"  name="nombre_modulo_act" id="nombre_modulo_act" class="form-control">

                                        </div>
                                    </div>
                        <?php }else{ ?>
                            
        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Nombre Modulo</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lmi['nombre_modulo'] ?>" name="nombre_modulo" id="nombre_modulo" class="form-control">
                                    <input type="hidden" value="<?php echo $lmi['nombre_modulo'] ?>"  name="nombre_modulo_act" id="nombre_modulo_act" class="form-control">
            		        	</div>
            		        </div>

                        <!--ID PADRE-->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Depende de</label>
                                </div>
                                <div class="input">
                                   <select name="id_padre" id="id_padre" class="form-control selectpicker" data-live-search="true">
                                        <option>Seleccionar</option>
                                        <?php foreach ($listarModulos as $lm){ ?>
                                            <option value="<?php echo $lm['id_modulo'] ?>" <?php if($lm['id_modulo'] == $lmi['id_padre']){ ?>selected="selected" <?php } ?>>
                                                <?php echo ($lm['nombre_modulo']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" value="<?php echo $lmi['id_padre'] ?>"  name="id_padre_act" id="id_padre_act" class="form-control">
                                </div>
                            </div>

                        <!-- LINK -->
                            <div class="row mt-3 mb-4">
                                <div class="label">
                                    <label>Link del Modulo</label>
                                </div>
                                <div class="input">
                                    <input type="text"  value="<?php echo $lmi['link'] ?>"  name="link" id="link" class="form-control">
                                     <input type="hidden" value="<?php echo $lmi['link'] ?>"  name="link_act" id="link_act" class="form-control">
                                </div>
                            </div>

                        <?php } ?>

                    <?php } ?>
                <?php include("Template/bottom-form.php") ?>
	        </form>


        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>