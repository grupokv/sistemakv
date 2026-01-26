<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Segmento.php");

$titulo = 'Actualizar Segmentos';
$redireccion = 'segmentos.php';
$icono = 'fa fa-cubes';

$id_segmento = $_GET['id_segmento'];

if (!isset($id_segmento)) {
    
}else{
    $segmento = new Segmento();
    $listarId = $segmento->listarPorId($id_segmento);
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar segmento</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="segmentos.php">Segmentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar segmentos</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarSeg.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_segmento'] ?>"  name="id_segmento" id="id_segmento" class="form-control">

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Detalle segmento</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['detalle'] ?>"  name="detalle" id="detalle" class="form-control">
                                    <input type="hidden" value="<?php echo $lis['detalle'] ?>"  name="detalle_act" id="detalle_act" class="form-control">
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