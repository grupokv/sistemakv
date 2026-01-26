<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$id_usu = $_POST['id_usuario'];
$nombre_usu = mb_strtoupper($_POST['nombre_usu']);
$nombre_usu_act = mb_strtoupper($_POST['nombre_usu_act']);
$clave = base64_encode($_POST['clave']);
$clave_act = base64_encode($_POST['clave_act']);
$id_perfil = $_POST['id_perfil'];
$id_perfil_act = $_POST['id_perfil_act'];
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$correo_electronico_act = mb_strtoupper($_POST['correo_electronico_act']);
$estado = $_POST['estado'];
$nombre = mb_strtoupper($_POST['nombre']);
$nombre_act = mb_strtoupper($_POST['nombre_act']);
$id_cargo = $_POST['id_cargo'];
$id_cargo_act = $_POST['id_cargo_act'];
$cant_ingresos = $_POST['cant_ingresos'];
$fecha_ultimo_ingreso = $_POST['fecha_ultimo_ingreso'];

$ActualizarInfoUsu = $_POST['ActualizarInfoUsu'];

$usuario = new Usuario();
$actualizar = $usuario->actualizar($id_usu, $nombre_usu, $clave, $id_perfil, $correo_electronico, $estado, $nombre,  
								   $id_cargo, $cant_ingresos, $fecha_ultimo_ingreso);

$id_modulo = 4;
$id_registro = $id_usu;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($nombre_usu != $nombre_usu_act) {
	$columnas_modulo .= 'usuario |';
	$valores_antiguos .= $nombre_usu_act . ' | ';
	$valores_nuevos .= $nombre_usu . ' | ';
}

if ($clave != $clave_act) {
	$columnas_modulo .= 'clave |';
	$valores_antiguos .= $clave_act . ' | ';
	$valores_nuevos .= $clave . ' | ';
}

if ($id_perfil != $id_perfil_act) {
	$columnas_modulo .= 'id_perfil |';
	$valores_antiguos .= $id_perfil_act . ' | ';
	$valores_nuevos .= $id_perfil . ' | ';
}

if ($correo_electronico != $correo_electronico_act) {
	$columnas_modulo .= 'correo_electronico |';
	$valores_antiguos .= $correo_electronico_act . ' | ';
	$valores_nuevos .= $correo_electronico . ' | ';
}

if ($nombre != $nombre_act) {
	$columnas_modulo .= 'nombre |';
	$valores_antiguos .= $nombre_act . ' | ';
	$valores_nuevos .= $nombre . ' | ';
}

if ($id_cargo != $id_cargo_act) {
	$columnas_modulo .= 'id_cargo |';
	$valores_antiguos .= $id_cargo_act . ' | ';
	$valores_nuevos .= $id_cargo . ' | ';
}

if ($columnas_modulo != '') {
	$bitacoraActualizarUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}
if ($_SESSION['id_perfil'] == 2) {
	header('Location: ../Vista/inicioPropietarios.php');
}else{
	if ($ActualizarInfoUsu == 'U') {
		
		header('Location: ../Vista/inicio.php');
	}else{
		header('Location: ../Vista/usuarios.php');
	}
}

?>