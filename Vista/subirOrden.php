<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/General.php");
require_once("../Modelo/OrdenServicio.php");

/* VARIABLES MENU*/
$titulo = 'Cargar Comprobante Orden';
$redireccion = 'ordenes_servicio.php';
$icono = 'fa fa-wrench';

$id = base64_decode($_GET['id']);

$orden = new OrdenServicio();
$detalle = $orden->listarPorId($id);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Cargar Comprobante Orden</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>
    
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="ordenes_servicio.php">Ordenes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cargar Comprobante</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <!--FORMULARIO -->

	            <form method="POST" action="../Controlador/comprobanteOrden.php" enctype="multipart/form-data">
	            	<?php include("Template/header-form.php"); ?>

	            	<input type="hidden" name="id" id="id" value="<?php echo $id;?>" >

    	        		<div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Valor Final Orden</label>
                            </div>
                            <div class="input">
                                <input type="text" name="valor" id="valor" class="form-control" required="required" onKeyPress="return solo_numeros(event)">
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Factura</label>
                            </div>
                            <div class="input">
                                <input type="file" name="factura" id="factura" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="label">
                                <label>Fecha Realización</label>
                            </div>
                            <div class="input">
                                <input type="date" name="fecha" id="fecha" class="form-control" required="required">
                            </div>
                        </div>
                        <hr>
            
                        <?php include("Template/bottom-form.php"); ?>
	            </form> 
        </div>
    </section>

    <?php include("Template/scripts.php"); ?>

</body>
</html>