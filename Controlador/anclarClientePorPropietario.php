<?php 
require_once '../Modelo/Cliente.php';

$cliente = new Cliente();

$id_cliente = $_POST['id_cliente'];
$id_usuario = $_POST['id_usuario'];


$listarClientesAncladosPorPropietario = $cliente->validarClientesPorPropietario($id_usuario, $id_cliente);


if(count($listarClientesAncladosPorPropietario) <= 0){
	$anclarCliente = $cliente->registrarClientePorPropieario($id_cliente, $id_usuario);

	if ($anclarCliente == 1) { 
		echo "<script>alert('El cliente fue anclado correctamente.'); window.location.href='../Vista/clientesPropietarios.php';</script>";
	}else{
		echo "<script>alert('Error al anclar el cliente.'); window.location.href='../Vista/clientesPropietarios.php';</script>";
	} 

}else{
	echo "<script>alert('Este cliente ya se encuentra anclado a su usuario'); window.location.href='../Vista/clientesPropietarios.php';</script>";
}



?>


