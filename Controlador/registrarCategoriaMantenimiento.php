<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Categoria_Mantenimiento.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_cat']);

$categoria = new Categoria_Mantenimiento();

$registrar = $categoria->registrar($detalle);

$id_modulo = 44;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_categoria | detalle_categoria';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/categorias_mantenimiento.php');

 ?>