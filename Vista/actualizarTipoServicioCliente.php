<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicioCliente.php");
/* VARIABLES MENU*/

$id = $_GET['id'];

$titulo = 'Actualizar Tipo Servicio';
$redireccion = 'tipo_servicio_cliente.php';
$icono = 'fa fa-briefcase';

$cliente = new Cliente();
$listarC = $cliente->listar();
$tipo_vehiculo = new TipoVehiculo();
$listarV = $tipo_vehiculo->listar();

$tipo = new TipoServicioCLiente();
$datos = $tipo->listarPorId($id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Tipo Servicio CLiente</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="tipo_servicio_cliente.php">Tipo Servicio Cliente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Tipo</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/actualizarTipoServicioCliente.php" method="POST">
				<?php include("Template/header-form.php"); ?>
					<input type="hidden" value="<?php echo $id;?>" name="id"/> 
					<!--NOMBRE CARGO-->
						<div class="row mt-3">
						    <div class="label">
							    <label>Nombre</label>
						    </div>
						    <div class="input">
						        <input type="text" name="detalle" id="detalle" value="<?php echo $datos[0]['detalle'];?>" class="form-control">
						    </div>
						</div>
					        
					
						<div class="row mt-3">
						    <div class="label">
						        <label>Cliente</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_cliente" id="id_cliente">
						        	<option>Seleccionar </option>
						        	<?php foreach ($listarC as $la){ ?>
						        		<option value="<?php echo $la['id_cliente'] ?>" <?php if($datos[0]['id_cliente'] == $la['id_cliente']){ ?> selected="selected" <?php } ?> >
						        			<?php echo $la['razon_social'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
						        <label>Tipo Vehiculo</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_tipo_vehiculo" id="id_tipo_vehiculo">
						        	<option>Seleccionar </option>
						        	<?php foreach ($listarV as $lv){ ?>
						        		<option value="<?php echo $lv['id_tipo_vehiculo'] ?>"<?php if($datos[0]['id_tipo_vehiculo'] == $lv['id_tipo_vehiculo']){ ?> selected="selected" <?php } ?> >
						        			<?php echo $lv['nombre_tipo_vehiculo'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>
				<?php include("Template/bottom-form.php"); ?>
            </form>
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>
</body>
</html>

