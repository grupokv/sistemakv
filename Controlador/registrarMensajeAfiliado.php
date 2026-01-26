<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/General.php';

$usuario = $_POST['id_usuario'];
$mensaje = $_POST['mensaje'];
$id_usuario_remitente = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');

for ($i=0; $i < count($usuario); $i++) { 
	$id_usuario_destinatario = $usuario[$i];

	$registrarMensaje = registrarMensajeAfiliado($id_usuario_destinatario, $mensaje, $id_usuario_remitente, $fecha);
}

if ($registrarMensaje == 1) {
	echo "<script>alert('Mensaje enviado correctamente'); window.location.href = '../Vista/mensajesAfiliados.php';</script>";
}else{
	echo "<script>alert('Error en el registro.'); window.location.href = '../Vista/mensajesAfiliados.php';</script>";
}


?>