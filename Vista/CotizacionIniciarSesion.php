<?php
session_start();
date_default_timezone_set('America/Bogota');

require('../Modelo/CotizadorKV.php');
if($_POST){
    
    if(($_POST['usuario'] != '')and($_POST['clave'] != '')){
        
        $cotizadorkv = new CotizadorKV();
        
        $iniciar = $cotizadorkv->iniciar_sesion($_POST['usuario'],$_POST['clave']);
        //print_r($iniciar);
        if(count($iniciar) > 0){
            $_SESSION['id_user'] = $iniciar[0]['id_usuario'];
            echo ("<script LANGUAGE='JavaScript'>
            window.location.href='CotizacionNuevo.php';
            </script>");
        } else {
            echo ("<script LANGUAGE='JavaScript'>
            alert('Usuario y/o Clave incorrectos, intente de nuevo');
            window.location.href='CotizacionKV.php';
            </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        window.location.href='CotizacionKV.php';
        </script>");
    }
} else {
    echo ("<script LANGUAGE='JavaScript'>
    window.location.href='CotizacionKV.php';
    </script>");
}
?>