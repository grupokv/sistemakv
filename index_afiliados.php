<?php

session_start();
date_default_timezone_set('America/Bogota');
require_once("Modelo/Conexion/conexionBD.php");
require_once("Modelo/Usuario.php");

/*PAGINA DE REFERENCIA*/
$_SERVER['HTTP_REFERER'];
/*PAGINA DE REFERENCIA*/

$conexion = new Conexion();
$objUsuario = new Usuario();

$mensaje = "";

if (($_POST)) {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $correo = $_POST['correo'];
    $claveEncriptada = base64_encode($clave);
    $login = $conexion->iniciarSesion($usuario, $claveEncriptada);

    if (empty($usuario) || empty($clave)) {
       $mensaje =  "¡Hay campos vacios en el formulario!";
    }else{
        if ($login) {
          $_SESSION['id_usuario'] = $login[0]['id_usuario'];
          $_SESSION['sesion'] = $usuario;
          $_SESSION['nombre'] = $login[0]['nombre'];
          $_SESSION['id_perfil'] = $login[0]['id_perfil'];

          $actualizarUltimoIngreso = $objUsuario->actualizarUltimoIngreso($_SESSION['id_usuario'], $login[0]['cant_ingresos'] + 1 , date('Y-m-d H:i:s'));

            if ($login[0]['estado'] == 0) {

                ?>

                <div class="modal" id="modal" tabindex="-1" role="dialog" style="display: block;">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">

                          <span class="fa fa-info" style="font-size: 2.2rem; border-radius: 50%; border: 2px solid red; color: red; width: 40px; height: 38px;" ></span>

                          <p class="mt-2"><strong>¡Este usuario esta bloqueado!</strong></p>

                          <p class="mt-2">Por favor comuniquese con la persona indicada para tener nuevamente el acceso a la plataforma.</p>

                          <p class="mt-4"><strong>CONTACTO</strong></p>

                          

                          <div class="row">

                              <section class="col-6">

                                <label>Correo Electronico</label>

                                <p>correo@rtsas.com</p>

                              </section>

                              <section class="col-6">

                                <label>Dirección</label>

                                <p>Cll. 73 #75-55, Bogotá</p>

                              </section>

                          </div>



                          <div class="row">

                              <section class="col-6">

                                <label>Telefono</label>

                                <p>123456789</p>

                              </section>

                              <section class="col-6">

                                <label>Ciudad</label>

                                <p>Bogotá, Colombia.</p>

                              </section>

                          </div>

                          

                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-primary" onclick="cerrar();">Aceptar</button>

                        </div>

                    </div>

                  </div>
                </div>

                <?php
            }else{
                echo ("<script LANGUAGE='JavaScript'>window.location.href='Vista/inicioPropietarios.php';</script>");
            }
        }else{
           $mensaje = "¡Usuario o Contraseña incorrectos! por favor intentalo de nuevo.";
        }
    }

    

    if ($correo != "") {

          $random = rand(100000000, 999999999);
          $claveGenerada = $random;
          $claveE = base64_encode($random);

          $recuperar = $objUsuario->recuperarContraseña($correo, $claveE, $claveGenerada);
          $mensaje = "¡Contraseña generada exitosamente! por favor verifique su correo electronico.";
    }

}else{

      $mensaje = "";

    }





 ?>



<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <title>Iniciar Sesión</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- styles -->

  <link rel="stylesheet" href="Resources/css/bootstrap.min.css">

  <link rel="stylesheet" href="Resources/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="Resources/css/alertify.min.css">

  <link rel="stylesheet" href="Resources/css/login.css">

  <link href="https://fonts.googleapis.com/css?family=Raleway:100" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">

  <style>

  body{

    overflow-x: hidden;

  }

  </style>

</head>

<body>


  <!-- contenido -->

  <div class="row">

      <!---->

      <section class="col seccion">

      </section>

      <!---->

      <section class="col seccion2 d-flex justify-content-around mt-5">

        <form action="" method="POST" >

          <div class="login mt-3">

            

              <h1 class="text-center mt-2">Inicio Sesión Afiliados</h1>

              <div class="row justify-content-center">

                 <h4 class="ml-5 logo" id="k">KING</h4>  

                 <h4 class="ml-1 mr-3 logo" id="v">VISION</h4> 

              </div>

              <hr>

              <div class="row">

                  <section class="col-12">

                      <label for="">Usuario</label>

                  </section>

                  <section class="col-12">

                      <input type="text" class="form-control mb-3" name="usuario" id="usuario">

                  </section>

              </div>

              <div class="row">

                  <section class="col-12">

                      <label for="">Contraseña</label> 

                  </section>

                  <section class="col-12">     

                      <input type="password" class="form-control mb-1" name="clave" id="clave">

                  </section>

              </div>

              <a href="" data-toggle="modal" data-target="#exampleModal">¿Olvidaste tu contraseña?</a>





              <!-- Modal -->



              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog" role="document">

                 <form action="" method="POST">

                  <div class="modal-content">

                   <div class="modal-header">

                      <h5 class="modal-title" id="exampleModalLabel">RECUPERAR CONTRASEÑA</h5>

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                     </button>

                    </div>

                    <div class="modal-body">

                        <p>¿Olvidaste tu contraseña? Por favor, introduzca la dirección de correo electrónico con la cual se registro y a continuación te enviaremos una nueva.</p>

                        <label>Correo electronico</label>

                        <input type="email" name="correo" id="correo" class="form-control">

                    </div>

                    <div class="modal-footer">  

                      <button class="btn btn-ingresar">Recuperar contraseña</button>

                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>

                    </div>

                   </form>

                  </div>

                </div>

              </div>



              <button class="btn btn-ingresar mt-4 btn-block">Ingresar</button>
              <a href="index.php" class="btn btn-outline-danger mt-4 btn-block">Regresar</a>



                



              <hr>

              <div class="text-center">
                <a href=""><i class="fa fa-video-camera"></i> Video Instructivo Modulo Afiliados </a>
              </div>
              
              <div class="mensaje text-center" style="color: #B40404;">

                <p><?php echo $mensaje; ?></p>

              </div>



                



          </div>

        </form>

      </section>

  </div>



  

  <!-- script -->

  <script src="Resources/js/jquery.min.js"></script>

  <script src="Resources/js/popper.min.js"></script>

  <script src="Resources/js/bootstrap.min.js"></script>

  <script src="Resources/js/alertify.min.js"></script>



  <script type="text/javascript">

     function cerrar(){

       document.getElementById('modal').style.display = 'none';

     }



  </script>

 

</body>

</html>