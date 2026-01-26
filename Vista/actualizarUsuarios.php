<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Perfil.php");
require_once("../Modelo/Cargo.php");
require_once("../Modelo/Usuario.php");

$titulo = 'Actualizar Usuarios';
$redireccion = 'usuarios.php';
$icono = 'fa fa-user-o';


$perfil = new Perfil();
$listarP = $perfil->listar();

$cargo = new Cargo();
$listarC = $cargo->listarCargos();

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
  <title>SistemaKV | Actualizar usuarios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/registrarUsuario.css">
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="usuarios.php">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar usuarios</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
      <strong>
        <i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">ACTUALIZAR USUARIO</b>
      </strong>
    </div>

    <section class="form-usuarios mt-1 mb-4">
        <div class="formulario mb-3">
            
            <!-- Formulario -->
            <form method="POST" action="../Controlador/actualizarUsu.php">
                <?php foreach ($listarUsuId as $lui){ ?>
                      
                    <!-- ID USUARIO -->
                        <input type="hidden" value="<?php echo $lui['id_usuario'] ?>" name="id_usuario" id="id_usuario" class="form-control">

                    <!-- ESTADO -->
                        <input type="hidden" value="<?php echo $lui['estado'] ?>" name="estado" id="estado" class="form-control">

                    <!-- CANT_INGRESOS -->
                        <input type="hidden" value="<?php echo $lui['cant_ingresos'] ?>" name="cant_ingresos" id="cant_ingresos" class="form-control">

                    <!-- FECHA ULTIMO INGRESO -->
                        <input type="hidden" value="<?php echo $lui['fecha_ultimo_ingreso'] ?>" name="fecha_ultimo_ingreso" id="fecha_ultimo_ingreso" class="form-control">
                       
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

                    <!-- CARGO -->
                        <div class="row col-12 mb-4 ">
                            <div class="label">    
                                <label for="speed">Cargo</label>
                            </div>
                            <div class="input">
                                  <select class="form-control selectpicker" data-live-search="true" name="id_cargo" id="id_cargo">
                                    <?php foreach ($listarC as $lc){ ?>
                                      <option value="<?php echo $lc['id_cargo'] ?>"  <?php if($lc['id_cargo'] == $lui['id_cargo']) { ?>  selected="selected" <?php } ?>>
                                        <?php echo $lc['nombre_cargo'] ?>
                                      </option>
                                    <?php } ?>
                                  </select>

                                  <input type="hidden" value="<?php echo $lui['id_cargo'] ?>" name="id_cargo_act" id="id_cargo_act" class="form-control" required="true">
                            </div>
                        </div>

                    <!-- PERFIL -->
                        <div class="row col-12 mb-4 ">
                            <div class="label">    
                                <label for="speed1">Perfil</label>
                            </div>
                            <div class="input">    
                                <select class="form-control selectpicker" data-live-search="true" name="id_perfil" id="id_perfil">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarP as $lp){ ?>
                                        <option value="<?php echo $lp['id_perfil'] ?>" <?php if($lp['id_perfil'] == $lui['id_perfil']) { ?>  selected="selected" <?php } ?>>
                                            <?php echo $lp['nombre_perfil'] ?>
                                        </option>
                                    <?php } ?>
                                  </select>

                                   <input type="hidden" value="<?php echo $lui['id_perfil'] ?>" name="id_perfil_act" id="id_perfil_act" class="form-control" required="true">
                            </div>
                        </div>


                    <section class="col-12 mt-4 mb-4 d-flex justify-content-center">
                        <a href="usuarios.php" class="btn btn-outline-danger col-3 mr-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-info col-3">Actualizar</button>
                    </section>
          
                <?php } ?>
            </form>
        </div>
    </section>

    <!-- FIN CONTENIDO -->


    <!-- script -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        $( function() {
            $( "#datepicker" ).datepicker();
        } ); 

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