<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$id_cliente = $_POST['id_cliente'];
$clase_movil_producto = $_POST['clase_movil_producto'];
$capacidad = $_POST['capacidad'];
$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
$observaciones = $_POST['observaciones'];
$id_usuario_creacion = $_SESSION['id_usuario'];
$fecha_creacion = date('Y-m-d H:i:s');

$operativo = new Operativo();
$registrarClaseMovilCliente = $operativo->registrarClaseMovilCliente($id_cliente, $clase_movil_producto, $capacidad, $id_tipo_vehiculo, $observaciones, $id_usuario_creacion, $fecha_creacion);

echo "<script>alert('Se ha actualizado correctamente la información.'); window.location.href = '../Vista/clasesMovilProductos.php';</script>";

?>

