<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

/*USUARIO*/
$nombre_usu = $_POST['numero_documento'];
$clave = base64_encode($_POST['numero_documento']);
$id_centro_costo= $_POST['id_centro_costo'];
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$nombre = mb_strtoupper($_POST['nombre']." ".$_POST['apellido']);
$id_cargo = $_POST['id_cargo'];$id_cliente = $_POST['id_cliente'];
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

$registrar = $usuario->registrarUC($nombre_usu, $clave, $id_centro_costo, $correo_electronico, $nombre, $id_cliente, $id_cargo, $fecha_ultimo_ingreso);echo ("<script LANGUAGE='JavaScript'>    window.alert('Usuario Registrado');    window.location.href='../Vista/usuarios_clientes.php';    </script>");
?>