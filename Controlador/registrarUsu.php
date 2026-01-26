<?php 

include ("Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Rol.php");
require_once("../Modelo/General.php");

/*USUARIO*/
$nombre_usu = $_POST['numero_documento'];
$clave = base64_encode($_POST['numero_documento']);
$id_perfil = $_POST['id_perfil'];
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$nombre = mb_strtoupper($_POST['nombre']);
$id_cargo = $_POST['id_cargo'];
$fecha_ultimo_ingreso = date('Y-m-d H:i:s');

$usuario = new Usuario();

 $existe = $usuario->buscarUsuarioPorCedula($nombre_usu);

if(count($existe)>0){

	echo "<script>
    alert('El usuario ya se encuentra registrado en el sistema');
    window.location.href = '../Vista/usuarios.php';
    </script>";
    exit;

}

$registrar = $usuario->registrar($nombre_usu, $clave, $id_perfil, $correo_electronico, $nombre, $id_cargo, 
								 $fecha_ultimo_ingreso);

$id_modulo = 4;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_usuario | usuario | clave | id_perfil | correo_electronico | estado | nombre |id_cargo | cant_ingresos |fecha_ultimo_ingreso';

$valores_antiguos = '';
$valores_nuevos = $registrar . ' | ' . $nombre_usu . ' | ' . $clave . ' | ' . $id_perfil . ' | ' . $correo_electronico . ' | ' .  1 . ' | ' . $nombre . ' | ' . $id_cargo . ' | ' . $fecha_ultimo_ingreso;

$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo,$valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

 ?>