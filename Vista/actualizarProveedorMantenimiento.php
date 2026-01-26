<?php

include ("../Controlador/Sesion/autenticar.php"); 
require_once("../Modelo/ProveedorMantenimiento.php");

$titulo = 'Actualizar Proveedor';
$redireccion = 'proveedores_mantenimiento.php';
$icono = 'fa fa-building-o';


$id = $_GET['id'];

if (!isset($id)) {
}else{
   $objE = new ProveedorMantenimiento();
   $listarId = $objE->listarPorId($id);
}
?>

 <!DOCTYPE html>
<html>
<head>
	<title>SistemaKV | Actualizar proveedor</title>
	<!--ESTILOS-->
	<?php include("../Vista/Template/styles.php"); ?>
	<link rel="stylesheet" type="text/css" href="../Resources/css/registrarUsuario.css">
	<!--FIN ESTILOS-->

</head>
<body>
	<!--MENU-->
	<?php include("../Vista/Template/menu.php"); ?>
	<!--FIN MENU-->

	<!--CONTENIDO-->
	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="proveedores_mantenimiento.php">Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar proveedor</li>
         </ol>
    </div>


    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            
            <!-- Formulario -->
            <?php foreach ($listarId as $li){ ?>

	        	<form action="../Controlador/actualizarProv.php" method="POST" enctype="multipart/form-data">
	                
	                <?php include("Template/header-form.php") ?>

	                    <div id="tabs">
		                    
					        <!-- EMPRESA -->
			                    <div id="tabs-1">


					        		<!--ID EMPRESA-->

							       		<input type="hidden" name="id" id="id" class="form-control" value="<?php echo $li['id_proveedor']; ?>">
					        
							        <!--ESTADO-->

							        	<input type="hidden" name="estado" id="estado" class="form-control" value="<?php echo $li['estado']; ?>">

							        <!--NOMBRE EMPRESA-->
								        <div class="row mt-3 ">
								        	<div class="label">
									            <label>Razón Social</label>
								        	</div>
								        	<div class="input">
								        		<input type="text" name="nombre_empresa" value="<?php echo $li['razon_social'] ?>" id="nombre_empresa" class="form-control">
								        		<input type="hidden" name="nombre_empresa_act" value="<?php echo $li['razon_social'] ?>" id="nombre_empresa_act" class="form-control">
								        	</div>
								        </div>
								        
							        <!--NIT-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Nit</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="nit_empresa" value="<?php echo $li['nit'] ?>" id="nit_empresa" class="form-control" >
								                <input type="hidden" name="nit_empresa_act" value="<?php echo $li['nit'] ?>" id="nit_empresa_act" class="form-control" >
								            </div>
								        </div>

							        <!--DIRECCION-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Direccion</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="direccion" value="<?php echo $li['direccion'] ?>" id="direccion" class="form-control" >
								                <input type="hidden" name="direccion_act" value="<?php echo $li['direccion'] ?>" id="direccion_act" class="form-control" >
								            </div>
								        </div>

							        <!--TELEFONO-->
								        <div class="row mt-3 ">
								        	<div class="label">
								                <label>Telefono</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="telefono" value="<?php echo $li['telefono'] ?>" id="telefono" class="form-control" >
								                <input type="hidden" name="telefono_act" value="<?php echo $li['telefono'] ?>" id="telefono_act" class="form-control" >
								            </div>
								        </div>

								    <!--LOGO-->
								        <div class="row mt-3 mb-4 ">
								        	<div class="label">
								                <label>Correo Electronico</label>
								            </div>
								        	<div class="input">
								                <input type="text" name="email" id="email" class="form-control" value="<?php echo $li['email'];?>">
								                <input type="hidden" name="email_act" value="<?php echo $li['email'] ?>" id="email_act" class="form-control">
								            </div>
								        </div>

								    
							    </div>

			        <?php include("Template/bottom-form.php") ?>	 
		        </form>
		<?php } ?>
        </div>
    </section>
	<!--FIN CONTENIDO-->

<!--SCRIPTS-->
    <?php include("../Vista/Template/scripts.php");  ?>

<!--SCRIPTS-->
</body>
</html>