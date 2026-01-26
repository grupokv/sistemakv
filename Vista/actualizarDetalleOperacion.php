<?php 
include ("../Controlador/Sesion/autenticar.php");
	require_once ('../Modelo/Operacion.php');
    require_once ('../Modelo/Vehiculo.php');
    require_once ('../Modelo/DetalleOperacion.php');

/* VARIABLES MENU*/
$titulo = 'Registrar Detalle';
$redireccion = 'detalles.php';
$icono = 'fa fa-clipboard';

	$id_detalle = $_GET['id_detalle'];

	$operaciones = new Operacion();
    $listarO = $operaciones->listar();

    $vehiculo = new Vehiculo();
    $listarVehiculo = $vehiculo->listar();

    $detalleOperacion = new DetalleOperacion();
    $listarPorId = $detalleOperacion->listarPorId($id_detalle);


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

            <form action="../Controlador/actualizarDetalleOperacion.php" method="POST">
			    <?php include("Template/header-form.php"); ?>
					
                		<input type="hidden" name="id_detalle" id="id_detalle" value="<?php echo $listarPorId[0]['id_detalle']?>" class="form-control">
			    	
						<!--FECHA-->
							<div class="row mt-3">
								<div class="label">
									<label>Fecha Detalle</label>
								</div>
								<div class="input">
								   <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $listarPorId[0]['fecha'] ?>" required="true">
								</div>
						    </div>

					    <!--VEHICULO-->

						    <div class="row mt-3">
								<div class="label">
									<label>Vehiculo</label>
								</div>
								<div class="input">
								   	<select class="form-control display" name="id_vehiculo" id="id_vehiculo" required="true">
					                    <?php foreach ($listarVehiculo as $v) { ?>
					                        <option value="<?php echo $v['id_vehiculo'] ?>" <?php if ($v['id_vehiculo'] == $listarPorId[0]['id_vehiculo']){ ?> selected="selected" <?php } ?> >
					                            <?php echo $v['placa']?>
					                        </option>
					                    <?php } ?>
					                </select>
								</div>
						    </div>

						<!--OPERACION-->
						    <div class="row mt-3">
								<div class="label">
									<label>Operación</label>
								</div>
								<div class="input">
								   <select class="form-control" name="id_operacion" id="id_operacion"  required="true">
					                    <option value="0">Seleccione operación</option>
					                    <?php foreach ($listarO as $o) { ?>
					                        <option value="<?php echo $o['id_operacion'] ?>" <?php if ($o['id_operacion'] == $listarPorId[0]['id_operacion']) { ?> selected="selected" <?php  } ?>>
					                            <?php echo $o['nombre_operacion']?>
					                        </option>
					                     <?php } ?>
					                </select>
								</div>
						    </div>

						<!--PRECIO-->
						    <div class="row mt-3">
								<div class="label">
									<label>Precio</label>
								</div>
								<div class="input">
								    <input type="number" name="precio" id="precio" class="form-control" value="<?php echo $listarPorId[0]['precio'] ?>" required="true">
								</div>
						    </div>

			    <?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

