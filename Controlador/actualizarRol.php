<?php 
require_once("../Modelo/Rol.php");
require_once("../Modelo/Modulo.php");

$id_usuario = $_POST['id_usuario'];

$rol = new Rol();

$modulo = new Modulo();
$listar = $modulo->listar();

/*Eliminar permimos del usuario*/
$eliminar = $rol->eliminarPorId($id_usuario);

/*Registrar Nuevos permisos del usuario*/

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
        $registrar = $rol->registrar($id_modulo, $id_usuario, $consulta, $edicion, $agregacion, $eliminacion);
    }

    header('Location: ../Vista/actualizarRoles.php?us=' . $id_usuario);
}

 ?>