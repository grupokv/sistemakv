<?php 
include 'Sesion/autenticar.php';
require_once("../Modelo/Vehiculo.php");
$id_ruta = $_GET['id'];
$vehiculo = new Vehiculo();
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$usuario = $_SESSION['id_usuario'];
if($_SESSION['id_cliente'] != ''){	
$tipo = 'M';} else {	$tipo = 'C';}
$registrar = $vehiculo->registrarRecorrido($fecha, $hora, $usuario, $id_ruta, $tipo);
$pasajeros = $vehiculo->buscarPasajerosRuta($id_ruta);

foreach($pasajeros as $pas){   
	$reg = $vehiculo->registrarPasajeroRecorrido($pas['id_pasajero'],$registrar,$id_ruta,$fecha,$hora,$usuario);
}
echo ("<script LANGUAGE='JavaScript'>
window.alert('El recorrido se inicio correctamente');
window.location.href='../Vista/recogida_pasajeros.php?id=".$registrar."';
</script>");
?>