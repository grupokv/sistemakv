<?php 
	include ("../Controlador/Sesion/autenticar.php");
    require_once ('../Modelo/DetalleGastoPersonal.php');

/* VARIABLES MENU*/
$titulo = 'Actualizar Operación Personal';
$redireccion = 'detalles.php';
$icono = 'fa fa-clipboard';

	$id_detalle_gasto = $_GET['id_detalle_gasto'];


    $detalleOperacionPersonal = new DetalleGastoPersonal();
    $listarDGPorId = $detalleOperacionPersonal->listarDGPorId($id_detalle_gasto);


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar detalle</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="Areas.php">Areas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar areas</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/actualizarDetalleGastoPersonal.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 
					
                		<input type="hidden" name="id_detalle_gasto" id="id_detalle_gasto" value="<?php echo $listarDGPorId[0]['id_detalle_gasto']?>" class="form-control">
                		<input type="hidden" name="estado" id="estado" value="<?php echo $listarDGPorId[0]['estado']?>" class="form-control">
			    	
						<!--DESCRIPCION-->
							<div class="row mt-3">
								<div class="label">
									<label>Descripción</label>
								</div>
								<div class="input">
								   <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $listarDGPorId[0]['descripcion'] ?>" required="true">
								</div>
						    </div>

						<!--NOMBRE PERSONA - ENTIDAD-->
							<div class="row mt-3">
								<div class="label">
									<label>Nombre de persona o entidad</label>
								</div>
								<div class="input">
								   <input type="text" name="nombre_persona" id="nombre_persona" class="form-control" value="<?php echo $listarDGPorId[0]['nombre_persona'] ?>" required="true">
								</div>
						    </div>

						<!--FECHA DETALLE-->
							<div class="row mt-3">
								<div class="label">
									<label>Fecha Detalle</label>
								</div>
								<div class="input">
								   <input type="text" name="fecha_detalle" id="fecha_detalle" class="form-control" value="<?php echo $listarDGPorId[0]['fecha_detalle'] ?>" required="true">
								</div>
						    </div>

					   	<!--PRECIO-->
						    <div class="row mt-3">
								<div class="label">
									<label>Precio</label>
								</div>
								<div class="input">
								    <input type="number" name="precio" id="precio" class="form-control" value="<?php echo $listarDGPorId[0]['precio'] ?>" required="true">
								</div>
						    </div>

			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

