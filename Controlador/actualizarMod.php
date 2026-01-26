<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Modulo.php");
require_once("../Modelo/General.php");
   

    $id_mod = $_POST['id_modulo'];
    $nombre_modulo = mb_strtoupper($_POST['nombre_modulo']);
    $nombre_modulo_act = mb_strtoupper($_POST['nombre_modulo_act']);
	$id_padre = $_POST['id_padre'];
	$id_padre_act = $_POST['id_padre_act'];
	$link = $_POST['link'];
	$link_act = $_POST['link_act'];
	$estado = $_POST['estado'];

    $objModulo = new Modulo();
    $listarModId = $objModulo->actualizar($id_mod, $nombre_modulo, $id_padre, $link, $estado);


	$id_modulo = 9;
 	$id_registro = $id_mod;
	$tipo_actividad = 'ACTUALIZAR';
	$columnas_modulo = '';
	$valores_antiguos = '';
	$valores_nuevos = '';
	$id_usuario = $_SESSION['id_usuario'];
	$fecha_actividad = date('Y-m-d');
	$hora_actividad = date('H:i:s');


if ($nombre_modulo != $nombre_modulo_act) {
	$columnas_modulo .= 'nombre_modulo | ';
    $valores_antiguos .= $nombre_modulo_act . ' | ';
    $valores_nuevos .= $nombre_modulo . ' | ';
}

if ($id_padre != $id_padre_act) {
	$columnas_modulo .= 'id_padre | ';
    $valores_antiguos .= $id_padre_act . ' | ';
    $valores_nuevos .= $id_padre . ' | ';
}

if ($link != $link_act) {
	$columnas_modulo .= 'link | ';
    $valores_antiguos .= $link_act . ' | ';
    $valores_nuevos .= $link . ' | ';
}

if($columnas_modulo != ''){

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}
header('Location: ../Vista/modulos.php');
 ?>
 