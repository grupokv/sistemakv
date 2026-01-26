<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Programacion.php");

$ids = $_GET['ids'];

/* VARIABLES MENU*/
$titulo = 'Actualizar Solicitud';
$redireccion = 'programacion_solicitudes.php';
$icono = 'fa fa-calendar';

$programacion = new Programacion();
$clientes = new Cliente();

$detalle_solicitud = $programacion->solicitudPorId($ids);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Solicitud</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="programacion_solicitudes.php">Solicitudes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Solicitud</li>
         </ol>
    </div>

    <section class="form-usuarios mt1">
        <div class="formulario mb-5">

            <form action="../Controlador/actualizarSolicitud.php" method="POST">
			    <?php include("Template/header-form.php"); ?> 
				
					<input type="hidden" name="id_solicitud" value="<?php echo $ids;?>">
					        
					<!--ID CLIENTE-->
					    <div class="row mt-3 mb-4">
					        <div class="label">
					            <label>Cliente</label>
					        </div>
					        <div class="input">
					      		<?php $datoscliente = $clientes->cliente_ID($detalle_solicitud[0]['id_cliente']); echo $datoscliente[0]['razon_social'];?>
					        </div>
					    </div>


					<div class="row mt-3">
						<div class="label">
							<label>Servicios Idas</label>
						</div>
						<div class="input">
						    <input type="text" name="idas" id="idas" class="form-control" onKeyPress="return solo_numeros(event)" value="<?php echo $detalle_solicitud[0]['servicios_ida']; ?>">
						</div>
				    </div>

				    <div class="row mt-3">
						<div class="label">
							<label>Servicios Retornos</label>
						</div>
						<div class="input">
						    <input type="text" name="retornos" id="retornos" class="form-control" onKeyPress="return solo_numeros(event)" value="<?php echo $detalle_solicitud[0]['servicios_retorno'];?>">
						</div>
				    </div>

			    <?php include("Template/bottom-form.php"); ?>

            </form>
        </div>
    </section>


    <?php include("Template/scripts.php"); ?>
</body>
</html>

