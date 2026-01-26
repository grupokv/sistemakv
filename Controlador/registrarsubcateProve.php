<?php 
require_once '../Modelo/ProveedorMantenimiento.php';

$proveedorMantenimiento = new ProveedorMantenimiento();

$id_proveedor = $_POST['id_proveedor'];
$id_subcategoria = $_POST['id_subcategoria'];
$costo = $_POST['costo'];

$validarCantSubsProveedor = $proveedorMantenimiento->validarCantSubsPorProveedor($id_proveedor, $id_subcategoria);

$cant = count($validarCantSubsProveedor);

if ($cant >= 1) {
	echo "<script>alert('Este proveedor ya tiene valorado este servicio, actualiza el que esta registrado.');</script>";
	echo "<script>window.location= '../Vista/registrarSubcategoriaProveedor.php?id=" . $id_proveedor ."'</script>";
}else{

	$registrar = $proveedorMantenimiento->registrarSubcategoriaPorProveedor($id_proveedor, $id_subcategoria, $costo);
	header('Location: ../Vista/proveedores_mantenimiento.php');
}




 ?>