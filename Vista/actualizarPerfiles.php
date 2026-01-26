<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Perfil.php");

$titulo = 'Actualizar Perfiles';
$redireccion = 'perfiles.php';
$icono = 'fa fa-user-o';

$id_perfil = $_GET['id_perfil'];

if (!isset($id_perfil)) {
}else{

   $objPerfil = new Perfil();
   $listarPerfilId = $objPerfil->listarPerfilesPorId($id_perfil);

}
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Perfil</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
</head>
<body>

    <?php include("Template/menu.php"); ?>


	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="perfiles.php">Perfiles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar perfiles</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarPerfil.php" method="POST">
                <?php include("Template/header-form.php") ?>
                  <?php foreach ($listarPerfilId as $lpi){ ?>
                        <!--ID AREA-->

                          <input type="hidden" value="<?php echo $lpi['id_perfil'] ?>" name="id_perfil" id="id_perfil" class="form-control">
    	        	
        		            <!--NOMBRE AREA-->
          		            <div class="row mt-3 mb-4">
          		        	    <div class="label">
          			                <label>Nombre Perfil</label>
          		        	    </div>
          		        	    <div class="input">
          		        		      <input type="text" value="<?php echo $lpi['nombre_perfil'] ?>" name="nombre_perfil" id="nombre_perfil" class="form-control">
                                <input type="hidden" name="nombre_perfil_act" id="nombre_perfil_act" value="<?php echo $lpi['nombre_perfil'] ?>" class="form-control">
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