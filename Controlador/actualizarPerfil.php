<?php 


include ("Sesion/autenticar.php");
require_once("../Modelo/Perfil.php");
require_once("../Modelo/General.php");

$id_perfil = $_POST['id_perfil'];
$nombre_perfil = mb_strtoupper($_POST['nombre_perfil']);
$nombre_perfil_act = mb_strtoupper($_POST['nombre_perfil_act']);

$perfil = new Perfil();
$actualizar = $perfil->actualizarPerfil($id_perfil, $nombre_perfil);


 $id_modulo = 8;
 $id_registro = $id_perfil;
 $tipo_actividad = 'ACTUALIZAR';
 $columnas_modulo = '';
 $valores_antiguos = '';
 $valores_nuevos = '';
 $id_usuario = $_SESSION['id_usuario'];
 $fecha_actividad = date('Y-m-d');
 $hora_actividad = date('H:i:s');

if ($nombre_perfil != $nombre_perfil_act) {
	$columnas_modulo .= 'nombre_perfil | ';
    $valores_antiguos .= $nombre_perfil_act . ' | ';
    $valores_nuevos .= $nombre_perfil . ' | ';
}

if($columnas_modulo != ''){
$bitacoraActualizacionArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

}
header('Location: ../Vista/perfiles.php');
 ?>