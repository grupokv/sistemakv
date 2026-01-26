<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Area.php");
require_once("../Modelo/General.php");

$nombre_area = mb_strtoupper($_POST['nombre_area']);
$id_empresa = $_POST['id_empresa'];

$area = new Area();
$registrarArea = $area->registrar($nombre_area, $id_empresa);

$id_modulo = 6;
$id_registro = $registrarArea;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_area' . ' | ' . 'nombre_area' . ' | ' . 'id_empresa' . ' | ' . 'estado_area';
$valores_antiguos =  '';
$valores_nuevos = $registrarArea . ' | '. $nombre_area . ' | '  . $id_empresa . ' | '. 1;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header('Location: ../Vista/areas.php');

 ?>