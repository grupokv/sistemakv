<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$id = $_POST['id'];
$id_cliente = $_POST['id_cliente'];
$clase_movil_producto = $_POST['clase_movil_producto'];
$capacidad = $_POST['capacidad'];
$id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
$observaciones = $_POST['observaciones'];
$estado = $_POST['estado'];

$operativo = new Operativo();
$actualizarClaseMovilCliente = $operativo->actualizarClaseMovilCliente($id, $id_cliente, $clase_movil_producto, $capacidad, $id_tipo_vehiculo, $observaciones, $estado);

echo "<script>alert('Se ha registrado correctamente la información.'); window.location.href = '../Vista/clasesMovilProductos.php';</script>";

?>