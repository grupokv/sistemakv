<?php 
include_once '../Controlador/Sesion/autenticar.php';
require '../Modelo/Usuario.php';

$titulo = 'Actualizar Información Personal';
$redireccion = 'inicioPropietarios.php';
$icono = 'fa fa-address-card-o';

$id_usuario = $_GET['id_usuario'];

if (!isset($id_usuario)) {
  
}else{
  $usuario = new Usuario();
  $listarUsuId = $usuario->listarUsuarioPorId($id_usuario);
}

 ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
	<title>SistemaKV | Actualizar Información Personal</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php include 'Template/styles.php'; ?>
</head>
<body>
	<?php include 'Template/menu.php'; ?>

	<div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="conductores.php">Conductores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar conductor</li>
         </ol>
    </div>

    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
	        <form action="../Controlador/actualizarUsu.php" method="POST" onsubmit="return validar()"> 
	        	<?php include("Template/header-form.php") ?>

                  	<?php foreach ($listarUsuId as $lui){ ?>
						<!-- ID USUARIO -->

	                        <input type="hidden" value="<?php echo $lui['id_usuario'] ?>" name="id_usuario" id="id_usuario" class="form-control">

	                    <!-- ESTADO -->

	                          <input type="hidden" value="<?php echo $lui['estado'] ?>" name="estado" id="estado" class="form-control">

	                    <!-- CANT_INGRESOS -->

	                          <input type="hidden" value="<?php echo $lui['cant_ingresos'] ?>" name="cant_ingresos" id="cant_ingresos" class="form-control">

	                    <!-- FECHA ULTIMO INGRESO -->

	                          <input type="hidden" value="<?php echo $lui['fecha_ultimo_ingreso'] ?>" name="fecha_ultimo_ingreso" id="fecha_ultimo_ingreso" class="form-control">	                   

	                    <!-- CARGO -->

	                        <input type="hidden" value="<?php echo $lui['id_cargo'] ?>" name="id_cargo_act" id="id_cargo_act" class="form-control" required="true">

	                    <!-- PERFIL -->

	                        <input type="hidden" value="<?php echo $lui['id_perfil'] ?>" name="id_perfil_act" id="id_perfil_act" class="form-control" required="true">
	                       
	                    <!-- NOMBRE -->
	                        <div class="row col-12 mb-4 mt-3">
	                            <div class="label">    
	                                <label>Nombre</label>
	                            </div>
	                            <div class="input">    
	                                <input type="text" value="<?php echo $lui['nombre'] ?>" name="nombre" id="nombre" class="form-control">
	                                <input type="hidden" value="<?php echo $lui['nombre'] ?>" name="nombre_act" id="nombre_act" class="form-control">
	                            </div>
	                        </div>

	                    <!-- CORREO ELECTRONICO -->
	                        <div class="row col-12 mb-4 ">
	                            <div class="label">    
	                                <label>Correo electronico</label>
	                            </div>
	                            <div class="input">    
	                                <input type="text" value="<?php echo $lui['correo_electronico'] ?>"  name="correo_electronico" id="correo_electronico" class="form-control">

	                                <input type="hidden" value="<?php echo $lui['correo_electronico'] ?>" name="correo_electronico_act" id="correo_electronico_act" class="form-control">
	                            </div>
	                        </div>

	                    <!-- USUARIO -->
	                        <div class="row col-12 mb-4 " style="display: none;">
	                            <div class="label">    
	                                <label>Usuario</label>
	                            </div>
	                            <div class="input">    
	                                <input type="text" value="<?php echo $lui['usuario'] ?>"  name="nombre_usu" id="nombre_usu"  class="form-control">
	                                <input type="hidden" value="<?php echo $lui['usuario'] ?>"  name="nombre_usu_act" id="nombre_usu_Act"  class="form-control">
	                            </div>
	                        </div>

	                    <!-- CONTRASEÑA -->
	                        <div class="row col-12 mb-4 ">
	                            <div class="label">    
	                                <label>Contraseña</label>
	                            </div>
	                            <div class="input">  

	                                <input type="password" value="<?php echo base64_decode($lui['clave']) ?>" name="clave" id="clave" class="form-control" required="true">

	                                <input type="hidden" value="<?php echo base64_decode($lui['clave']) ?>" name="clave_act" id="clave_act" class="form-control" required="true">

	                            </div>
	                        </div>

	                    <!--CONFIRMAR CONTRASEÑA -->
	                        <div class="row col-12 mb-4 ">
	                            <div class="label">    
	                                <label>Confirmar Contraseña</label>
	                            </div>
	                            <div class="input">  
	                                <input type="password" value="<?php echo base64_decode($lui['clave']) ?>" name="confirmarClave" id="confirmarClave" class="form-control" required="true">
	                                <strong><span id="error2" style="padding: 10px;"></span></strong>
	                            </div>
	                        </div>
                    <?php } ?>
                <?php include("Template/bottom-form.php"); ?>
	        </form>
	    </div>
	</section>

	<?php include 'Template/scripts.php'; ?>
	<script type="text/javascript">
		function validar(){
        	document.getElementById('guardar').innerHTML = 'Por favor espere';
    		document.getElementById('guardar').disabled = true;

        	return true;
        }

        $(document).ready(function(){
            $('#confirmarClave').keyup(function(){
                  var clave1 = $('#clave').val();
                  var clave2 = $('#confirmarClave').val();

                  if (clave2 == clave1) {
                      $('#error2').text(' Coinciden ').css('color', 'green');
                      $('#error2').removeClass();
                      $('#error2').addClass('fa fa-check').css('color', 'green');
                  }else{
                      $('#error2').text(' No coinciden ').css('color', 'red');
                      $('#error2').removeClass();
                      $('#error2').addClass('fa fa-times').css('color', 'red');
                  }
            })
        });
	</script>
</body>
</html>