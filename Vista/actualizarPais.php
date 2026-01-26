<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Pais.php");

$titulo = 'Actualizar Pais';
$redireccion = 'paises.php';
$icono = 'fa fa-map';

$id_pais = $_GET['id_pais'];

if (!isset($id_pais)) {
    
}else{
    $pais = new Pais();
    $listarId = $pais->listarPorId($id_pais);
}

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar pais</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="paises.php">Paises</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar pais</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarPais.php" method="POST">
                <?php include("Template/header-form.php") ?>
    	        	<?php foreach ($listarId as $lis){ ?>

                        <!--ID MODULO-->

                            <input type="hidden" value="<?php echo $lis['id_pais'] ?>"  name="id_pais" id="id_pais" class="form-control">

        		        <!--NOMBRE AREA-->
            		        <div class="row mt-3 mb-4">
            		        	<div class="label">
            			            <label>Nombre Pais</label>
            		        	</div>
            		        	<div class="input">
            		        		<input type="text" value="<?php echo $lis['pais'] ?>"  name="nombre_pais" id="nombre_pais" class="form-control">
                                    <input type="hidden" value="<?php echo $lis['pais'] ?>"  name="nombre_pais_act" id="nombre_pais_act" class="form-control">
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