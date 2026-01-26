<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");

$titulo = 'Mi Perfil';
$redireccion = 'inicio.php';
$icono = 'fa fa-user';

$usuario = new Usuario();

$id_usuario = $_SESSION['id_usuario'];
$listarId = $usuario->listarUsuarioPorId($id_usuario);

$ActualizarInfoUsu = 'U';

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Editar Mi Perfil</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--***************************-->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mi Perfil</li>
         </ol>
    </div>


    <!-- CONTENIDO -->
    <section class="form-usuarios mt-1">
        <div class="formulario mb-5">
            <form action="../Controlador/actualizarUsu.php" method="POST">
              <?php include("Template/header-form.php") ?>
                  <?php foreach ($listarId as $liu){ ?>

                        <!-- id_usuario -->
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $liu['id_usuario'] ?>">
                        
                        <!-- ActualizarInfoUsu -->
                        <input type="hidden" name="ActualizarInfoUsu" id="ActualizarInfoUsu" value="<?php echo $ActualizarInfoUsu ?>">

                        <!-- id_perfil -->
                        <input type="hidden" name="id_perfil" id="id_perfil" value="<?php echo $liu['id_perfil'] ?>">
                        <input type="hidden" name="id_perfil_act" id="id_perfil_act" value="<?php echo $liu['id_perfil'] ?>">
                        
                         <!-- ID CARGO -->
                        <input type="hidden" name="id_cargo" id="id_cargo" value="<?php echo $liu['id_cargo'] ?>">
                        <input type="hidden" name="id_cargo_act" id="id_cargo_act" value="<?php echo $liu['id_cargo'] ?>">
                        
                        <!-- estado -->
                        <input type="hidden" name="estado" id="estado" value="<?php echo $liu['estado'] ?>">

                        <!-- CANTIDAD DE INGRESOS -->
                        <input type="hidden" name="cant_ingresos" id="cant_ingresos" value="<?php echo $liu['cant_ingresos'] ?>">

                        <!-- fecha_ultimo_ingreso -->
                        <input type="hidden" name="fecha_ultimo_ingreso" id="fecha_ultimo_ingreso" value="<?php echo $liu['fecha_ultimo_ingreso'] ?>">

                        <!-- NOMBRE -->
                        <div class="row col-12 mb-4 mt-3">
                            <div class="label">    
                                <label>Nombre</label>
                            </div>
                            <div class="input">    
                                <input type="text" value="<?php echo $liu['nombre'] ?>" name="nombre" id="nombre" class="form-control">
                                <input type="hidden" value="<?php echo $liu['nombre'] ?>" name="nombre_act" id="nombre_act" class="form-control">
                            </div>
                        </div>

                        <!-- CORREO ELECTRONICO -->
                        <div class="row col-12 mb-4 mt-3">
                            <div class="label">    
                                <label>Correo electronico</label>
                            </div>
                            <div class="input">    
                                <input type="text" value="<?php echo $liu['correo_electronico'] ?>" name="correo_electronico" id="correo_electronico" class="form-control">
                                <input type="hidden" value="<?php echo $liu['correo_electronico'] ?>" name="correo_electronico_act" id="correo_electronico_act" class="form-control">
                            </div>
                        </div>

                        <!-- USUARIO -->
                        <div class="row col-12 mb-4 mt-3">
                            <div class="label">    
                                <label>Usuario</label>
                            </div>
                            <div class="input">    
                                <input type="text" value="<?php echo $liu['usuario'] ?>" name="nombre_usu" id="nombre_usu" class="form-control" readonly="readonly">
                                <input type="hidden" value="<?php echo $liu['usuario'] ?>" name="nombre_usu_act" id="nombre_usu_act" class="form-control">
                            </div>
                        </div>

                        <!-- CONTRASEÑA -->
                        <div class="row col-12 mb-4 mt-3">
                            <div class="label">    
                                <label>Contraseña</label>
                            </div>
                            <div class="input">  
                                <div class="row">
                                  <section class="col-11">
                                       <input type="password" value="<?php echo base64_decode($liu['clave'])  ?>" name="clave" id="clave" class="form-control"  onKeyUp="validarClaves(); " onBlur="noVacio();">
                                  </section>  
                                  <section class="col-1">
                                        <button type="button" onclick="mostrarClave();" class="btn btn-info" style="float: left;"><span class="fa fa-eye"></span></button>
                                  </section>  
                                
                              

                                  </div> 
                                <input type="hidden" value="<?php echo base64_decode($liu['clave'])  ?>" name="clave_act" id="clave_act" class="form-control">
                            </div>
                        </div>

                        <!--CONFIRMAR CONTRASEÑA -->
                        <div class="row col-12 mb-4 mt-3" id="confirmarClave" style="display: none;">
                            <div class="label">    
                                <label>Confirmar Contraseña</label>
                            </div>
                            <div class="input">    
                                <input type="password"  name="repetirClave" id="repetirClave" class="form-control">

                            </div>
                        </div>


                        
                  <?php } ?>
              <?php include("Template/bottom-form.php") ?> 
            </form>   
        </div>
    </section>
    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
  <script type="text/javascript">

      function validarClaves(){
        var a = document.getElementById('clave').value;
        if(a == '') {
          document.getElementById('confirmarClave').style.display = 'flex';
        }
      }

      function noVacio(){
        var a = document.getElementById('clave').value;
        if(a == '') {
            document.getElementById('clave').value = '<?php echo base64_decode($listarId[0]['clave']);?>';
            document.getElementById('repetirClave').value = '<?php echo base64_decode($listarId[0]['clave']);?>';
        }
      }

      function mostrarClave(){
          document.getElementById('clave').type = 'text';
          document.getElementById('repetirClave').type = 'text';
          setTimeout(function() {                    
              document.getElementById('clave').type = 'password';
              document.getElementById('repetirClave').type = 'password';
          },900);
      }


      $(document).ready(function(){
            $('#repetirClave').keyup(function(){
                  var clave1 = $('#clave').val();
                  var clave2 = $('#repetirClave').val();

                  if (clave2 == clave1) {
                      $('#clave').css("border-color","green");
                      $('#repetirClave').css("border-color","green"); 
 
                  }else{
                      $('#clave').css("border-color","red"); 
                      $('#repetirClave').css("border-color","red"); 
 
                  }
            })
        });


  </script>
</body>
</html>