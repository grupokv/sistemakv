<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Propietario.php");

$nombre = strtoupper($_POST['nombre']);
$tipo_documento = $_POST['tipo_documento'];
$numero_documento = $_POST['numero_documento'];
$telefono = $_POST['telefono'];
$correo = strtoupper($_POST['correo']);
$ciudad = strtoupper($_POST['ciudad']);
$direccion = strtoupper($_POST['direccion']);
$entidad_bancaria = strtoupper($_POST['entidad_bancaria']);
$titular_cuenta = strtoupper($_POST['titular_cuenta']);
$cc_titular = $_POST['documento_titular'];
$tipo_cuenta = $_POST['tipo_cuenta'];
$num_cuenta = $_POST['num_cuenta'];
$estado = $_POST['estado'];
$fecha_registro = date('Y-m-d H:i:s');
$fecha_ultima_modificacion = date('Y-m-d H:i:s');
$id_usuario_registro = $_SESSION['id_usuario'];
$id_usuario_ultima_modificacion = $_SESSION['id_usuario'];


$propietario = new Propietario();
$registrarPropietario = $propietario->registrarPropietario($nombre, $tipo_documento, $numero_documento, $telefono, $correo, $ciudad, $direccion, $entidad_bancaria, $titular_cuenta, $cc_titular, $tipo_cuenta, $num_cuenta, $estado, $fecha_registro, $fecha_ultima_modificacion, $id_usuario_registro, $id_usuario_ultima_modificacion);

if($registrarPropietario == 1){
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('El propietario fue registrado correctamente');
        window.location.href='../Vista/propietarios.php';
        </script>");
}else{
    echo ("<script LANGUAGE='JavaScript'>
		window.alert('Error al registrar el propietario, porfavor revise la información diligenciada y datos requeridos.');
		window.location.href='../Vista/propietarios.php';
		</script>");
}

?>