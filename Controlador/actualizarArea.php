<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Area.php");
require_once("../Modelo/General.php");

$nombre_area = mb_strtoupper($_POST['nombre_area']);
$nombre_area_act = mb_strtoupper($_POST['nombre_area_act']);
$id_empresa = $_POST['id_empresa'];
$id_empresa_act = $_POST['id_empresa_act'];
$id_area = $_POST['id_area'];

$area = new Area();
$actualizar = $area->actualizar($nombre_area, $id_empresa, $id_area);

 $id_modulo = 6;
 $id_registro = $id_area;
 $tipo_actividad = 'ACTUALIZAR';
 $columnas_modulo = '';
 $valores_antiguos = '';
 $valores_nuevos = '';
 $id_usuario = $_SESSION['id_usuario'];
 $fecha_actividad = date('Y-m-d');
 $hora_actividad = date('H:i:s');

if ($nombre_area != $nombre_area_act) {
	$columnas_modulo .= 'nombre_area | ';
    $valores_antiguos .= $nombre_area_act . ' | ';
    $valores_nuevos .= $nombre_area . ' | ';
}

if ($id_empresa != $id_empresa_act) {
	$columnas_modulo .= 'id_empresa | ';
    $valores_antiguos .= $id_empresa_act . ' | ';
    $valores_nuevos .= $id_empresa . ' | ';
}

if($columnas_modulo != ''){
$bitacoraActualizacionArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
}


echo ("<script LANGUAGE='JavaScript'>
    window.alert('Registro Actualizado Correctamente');
    window.location.href='../Vista/areas.php';
    </script>");
?>