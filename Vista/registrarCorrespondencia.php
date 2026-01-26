<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");
require_once("../Modelo/Usuario.php");

/* VARIABLES MENU*/
$titulo = 'Registrar Correspondencia';
$redireccion = 'correspondencia.php';
$icono = 'fa fa-inbox';
$id = '';

$correspondencia = new Correspondencia();
$tipos = $correspondencia->listarTipos();

$usuario = new Usuario();
$listadoUsuarios = $usuario->listarUsuariosInternosEmpresa();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Registrar Correspondencia</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="correspondencia.php">Correspondencia</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar Correspondencia</li>
         </ol>
    </div>

    <section class="form-usuarios">
        <div class="formulario mb-5">
            <form action="../Controlador/registrarCorrespondencia.php" method="POST">
				<?php include("Template/header-form.php"); ?> 
					
						<div class="row mt-3">
						    <div class="label">
						        <label>Tipo</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="id_tipo" id="id_tipo" required="required">
						        	<option>Seleccionar Tipo</option>
						        	<?php foreach ($tipos as $la){ ?>
						        		<option value="<?php echo $la['id_tipo'] ?>">
						        			<?php echo $la['detalle'] ?>
						        		</option>
						        	<?php } ?>
						        </select>
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
							    <label>Detalle</label>
						    </div>
						    <div class="input">
						        <input type="text" name="detalle" id="detalle" class="form-control">
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
							    <label>Fecha Recibido</label>
						    </div>
						    <div class="input">
						        <input type="text" name="fecha_recibido" id="fecha_recibido" class="form-control" required="required">
						    </div>
						</div>
					        
					    <div class="row mt-3">
						    <div class="label">
							    <label>Remitente</label>
						    </div>
						    <div class="input">
						        <input type="text" name="remitente" id="remitente" class="form-control" required="required">
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
							    <label>Destino</label>
						    </div>
						    <div class="input">
						        <input type="text" name="destino" id="destino" class="form-control" required="required">
						    </div>
						</div>

						<div class="row mt-3">
						    <div class="label">
						        <label>Usuario Destino</label>
						    </div>
						    <div class="input">
						        <select class="form-control selectpicker" data-live-search="true" name="us_destino" id="us_destino">
						        	<option>Seleccionar </option>
						        	<?php foreach ($listadoUsuarios as $le){ ?>
						        		<option value="<?php echo $le['id_usuario'] ?>">
						        			<?php echo $le['nombre'] ?>
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
    <script type="text/javascript">


        $( function() {
	        $( "#fecha_recibido" ).datepicker({
	        	dateFormat: "yy-mm-dd",
	        	maxDate: 0
	        });
	    } );
    </script>
</body>
</html>

