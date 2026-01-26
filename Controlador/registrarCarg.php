<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Cargo.php");
require_once("../Modelo/General.php");

$nombre_cargo = mb_strtoupper($_POST['nombre_cargo']);
$id_area = $_POST['id_area'];
$id_empresa = $_POST['id_empresa'];

$cargo = new Cargo();
$registrarC = $cargo->registrarCargos($nombre_cargo, $id_area, $id_empresa);

$id_modulo = 7; 
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_cargo | nombre_cargo | id_area | id_empresa';
$valores_antiguos = '';
$valores_nuevos = $registrarC . ' | ' .$nombre_cargo . ' | ' . $id_area . ' | '. $id_empresa;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s'); 

$bitacoraRegistroCargo = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/cargos.php');
 ?>