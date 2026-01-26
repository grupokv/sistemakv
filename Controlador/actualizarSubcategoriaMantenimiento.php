<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Subcategoria_Mantenimiento.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$id_cat = $_POST['id_cat'];
$id_cat_act = $_POST['id_cat_act']; 
$nombre_cat = mb_strtoupper($_POST['nombre_cat']);
$nombre_cat_act = mb_strtoupper($_POST['nombre_cat_act']);

$subcategoria = new Subcategoria_Mantenimiento();

$actualizar = $subcategoria->actualizar($nombre_cat,$id_cat,$id);

$id_modulo = 45;
$id_registro = $id;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if (($nombre_cat != $nombre_cat_act)or($id_cat != $id_cat_act)) {
	$columnas_modulo .=  'id_subcategoria | detalle_subcategoria | id_categoria';
	$valores_antiguos .= $id.' | '.$nombre_cat_act.' | '.$id_cat_act;
	$valores_nuevos .= $id.' | '.$nombre_cat.' | '.$id_cat;
}

if($columnas_modulo != ''){

$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/subcategorias_mantenimiento.php');
?>