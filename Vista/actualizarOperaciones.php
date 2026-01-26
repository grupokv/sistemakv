<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operacion.php");

/* VARIABLES MENU*/
$titulo = 'Actualizar Operación';
$redireccion = 'operaciones.php';
$icono = 'fa fa-briefcase';

$id_operacion = $_GET['id_operacion'];
$operacion = new Operacion();

$listarOpeId = $operacion->listarPorId($id_operacion);

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Operación</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="../Vista/inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="operaciones.php">Operaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Operación</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/actualizarOperacion.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 

			    		<input type="hidden" name="id_operacion" id="id_operacion" value="<?php echo $listarOpeId[0]['id_operacion'] ?>">
					<!--NOMBRE OPERACIÓN-->
						<div class="row mt-3">
							<div class="label">
								<label>Nombre Operación</label>
							</div>
							<div class="input">
							    <input type="text" name="nombre_operacion" id="nombre_operacion" class="form-control" value="<?php echo $listarOpeId[0]['nombre_operacion']?>">
							</div>
					    </div>
					<!--DESCRIPCION-->
					    <div class="row mt-3 mb-3">
							<div class="label">
								<label>Descripción</label>
							</div>
							<div class="input">
							    <textarea name="descripcion" id="descripcion" class="form-control"><?php echo $listarOpeId[0]['descripcion'] ?></textarea>
							</div>
					    </div>
					        
				<?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

