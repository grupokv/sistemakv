<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Categoria_Mantenimiento.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$nombre_cat = mb_strtoupper($_POST['nombre_cat']);
$nombre_cat_act = mb_strtoupper($_POST['nombre_cat_act']);

$categoria = new Categoria_Mantenimiento();

$actualizar = $categoria->actualizar($nombre_cat, $id);

$id_modulo = 44;
$id_registro = $id;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($nombre_cat != $nombre_cat_act) {
	$columnas_modulo .=  'id_categoria | detalle_categoria';
	$valores_antiguos .= $id.' | '.$nombre_cat_act;
	$valores_nuevos .= $id.' | '.$nombre_cat;
}

if($columnas_modulo != ''){

$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/categorias_mantenimiento.php');
?>