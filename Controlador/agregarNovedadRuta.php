<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Pasajero.php");

$idv = $_POST['idv'];
$tipo_novedad = $_POST['tipo_novedad'];
$id_pasajero = $_POST['pasajero'];
$detalle = mb_strtoupper($_POST['detalle']);
if($tipo_novedad == '2'){
    $idruta2 = $_POST['rutanueva'];
} else {
    $idruta2 = 0;
}
$idusuario = $_SESSION['id_usuario'];

/*FECHA LOCAL*/
date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

$id_modulo = 15;
$id_registro = $id_pasajero;
$tipo_actividad = 'NUEVA NOVEDAD';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');


$columnas_modulo .= 'tipo_novedad  | id_ruta | id_ruta2 | detalle | id_pasajero';
$valores_antiguos .= '';
$valores_nuevos .= $tipo_novedad . ' | ' . $idv . ' | ' . $idruta2 . ' | ' . $detalle . ' | ' . $id_pasajero ;


if ($columnas_modulo != '') {
    $bitacoraActualizacionPropietario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
}

$pasajero = new pasajero();
$cambio = $pasajero->registrarnovedad($tipo_novedad,$idv,$idruta2,$detalle,$fecha,$id_pasajero,$idusuario);

?>