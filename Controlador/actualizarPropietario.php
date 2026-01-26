<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Propietario.php");

$id_propietario = $_POST['id_propietario'];
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
$fecha_ultima_modificacion = date('Y-m-d H:i:s');
$id_usuario_ultima_modificacion = $_SESSION['id_usuario'];

$propietario = new Propietario();
$actualizarPropietario = $propietario->actualizarPropietario($id_propietario, $nombre, $tipo_documento, $numero_documento, $telefono, $correo, $ciudad, $direccion, $entidad_bancaria, $titular_cuenta, $cc_titular, $tipo_cuenta, $num_cuenta, $estado, $fecha_ultima_modificacion, $id_usuario_ultima_modificacion);

if($actualizarPropietario == 1){
    echo ("<script LANGUAGE='JavaScript'>
        window.alert('El propietario fue actualizado correctamente');
        window.location.href='../Vista/propietarios.php';
        </script>");
}else{
    echo ("<script LANGUAGE='JavaScript'>
		window.alert('Error al actualizar el propietario, porfavor revise la información diligenciada y datos requeridos.');
		window.location.href='../Vista/propietarios.php';
		</script>");
}

?>