<?php  

require_once '../Modelo/General.php';
date_default_timezone_set('America/Bogota');

$nombres_trabajador = $_POST['nombres'];
$apellidos_trabajador = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$correo_electronico = $_POST['correo_electronico'];
$id_referenciador = $_POST['id_referenciador'];
$fecha_registro = date('Y-m-d H:i:s');
$cant_personas_contacto = $_POST['cant_personas_contacto'];

$registrarEncuesta = registrarEncuestaNotificacionPositiva($nombres_trabajador, $apellidos_trabajador, $telefono, $direccion, $correo_electronico, $id_referenciador, $fecha_registro, $cant_personas_contacto);

$id_notificacion = $registrarEncuesta;
$nombre_persona = $_POST['nombre_usuario'];
$lugar_contacto = $_POST['lugar_encuentro'];
$fecha_contacto = $_POST['fecha_encuentro'];

for ($i=0; $i < count($nombre_persona); $i++) { 
	$nombres = $nombre_persona[$i];
	$fecha = $fecha_contacto[$i];
	$lugar = $lugar_contacto[$i];
	$registrarPersonasNotificacionPositiva = registrarPersonasNotificacionPositiva($id_notificacion, $nombres, $fecha, $lugar);
}


echo "<script>alert('Notificación creada correctamente.'); window.location.href='../Vista/controlNotificacionPositivo.php';</script>";

?>