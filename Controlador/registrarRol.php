<?php 
require_once("../Modelo/Rol.php");
require_once("../Modelo/Modulo.php");

/*MODULO*/
$modulo = new Modulo();
$listar = $modulo->listar();

/*ROL*/
$rol = new Rol();


$num_modulo = count($listar);
$id_usuario = $_POST['id_usu'];

foreach($listar as $lm){

    $id_modulo = $lm['id_modulo'];

    if ($_POST['agregacion_'.$lm['id_modulo']] == '1'){
        $agregacion = 1;
    } else {
        $agregacion = 0;
    }

    if ($_POST['eliminacion_'.$lm['id_modulo']] == '1'){
        $eliminacion = 1;
    } else {
        $eliminacion = 0;
    }

    if ($_POST['consulta_'.$lm['id_modulo']] == '1'){
        $consulta = 1;
    } else {
        $consulta = 0;
    }

    if ($_POST['edicion_'.$lm['id_modulo']] == '1'){
        $edicion = 1;
    } else {
        $edicion = 0;
    }
    
    if(($consulta != 0)||($agregacion != 0)||($eliminacion != 0)||($edicion != 0)){
        //echo $consulta.'/'.$edicion.'/'.$agregacion.'/'.$eliminacion;
        $registrar = $rol->registrar($id_modulo, $id_usuario, $consulta, $edicion, $agregacion, $eliminacion);

    }
    header('Location: ../Vista/usuarios.php');
}

 ?>