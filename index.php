<?php

session_start();
date_default_timezone_set('America/Bogota');
require_once("Modelo/Conexion/conexionBD.php");
require_once("Modelo/Usuario.php");

$conexion = new Conexion();

$objUsuario = new Usuario();

$mensaje = "";

if ($_POST) {
    
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $correo = $_POST['correo'];
    $claveEncriptada = base64_encode($clave);
    $login = $conexion->iniciarSesion($usuario, $claveEncriptada);
    
    //print_r($login);
    
    if (empty($usuario) || empty($clave)) {
         echo ("<script LANGUAGE='JavaScript'>alert('Faltan datos.');window.history.back();</script>");
    }else{
        if (count($login)>0) {
            
            
            $_SESSION['id_usuario'] = $login[0]['id_usuario'];
            $_SESSION['sesion'] = $usuario;
            $_SESSION['nombre'] = $login[0]['nombre'];
            $_SESSION['id_perfil'] = $login[0]['id_perfil'];

            $actualizarUltimoIngreso = $objUsuario->actualizarUltimoIngreso($_SESSION['id_usuario'], $login[0]['cant_ingresos'] + 1 , date('Y-m-d H:i:s'));
            
            if ($login[0]['estado'] == 1) { 
                
                if ($login[0]['id_perfil'] == 3) {
                  echo ("<script LANGUAGE='JavaScript'>window.location.href='Vista/inicioConductores.php';</script>");
                }else if ($login[0]['id_perfil'] == 2) {
                  echo ("<script LANGUAGE='JavaScript'>window.location.href='Vista/inicioPropietarios.php';</script>");
                }else if ($login[0]['id_perfil'] == 8) {
                  echo ("<script LANGUAGE='JavaScript'>window.location.href='Vista/inicioConductores.php';</script>");
                }else{
					        echo ("<script LANGUAGE='JavaScript'>window.location.href='Vista/inicio.php';</script>");
                }
                
            }else{
               echo ("<script LANGUAGE='JavaScript'>alert('Este usuario se encuentra actualmente inactivo.');window.history.back();</script>");
            }
            
        }
        else{
               echo ("<script LANGUAGE='JavaScript'>alert('Los datos no son validos.');window.history.back();</script>");
            }

    }

  
    /*if ($correo != "") {
        $random = rand(100000000, 999999999);
        $claveGenerada = $random;
        $claveE = base64_encode($random);

        $recuperar = $objUsuario->recuperarContraseña($correo, $claveE, $claveGenerada);
        $mensaje = "¡Contraseña generada exitosamente! por favor verifique su correo electronico.";
    }*/


/*}else{ header('Location: intranet/index.php'); } ?>*/
}else{ ?>

    <html>
      <head>
        <title>SISTEMA KV</title>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=http://www.intranetgroupkv.com">
      </head>
      <body>
          Esta página redirecciona a intranetgroupkv.com
      </body>
    </html>
    
<?php } ?>