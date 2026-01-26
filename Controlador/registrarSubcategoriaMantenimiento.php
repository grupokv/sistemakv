<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Subcategoria_Mantenimiento.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_cat']);
$id_cat = $_POST['id_cat'];

$subcategoria = new Subcategoria_Mantenimiento();

$registrar = $subcategoria->registrar($detalle,$id_cat);

$id_modulo = 45;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_subcategoria | detalle_categoria | id_categoria';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $detalle . ' | ' . $id_cat;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/subcategorias_mantenimiento.php');

 ?>