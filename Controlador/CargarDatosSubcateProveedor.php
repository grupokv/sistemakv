<?php  

require_once "../Modelo/ProveedorMantenimiento.php";

$id_subcategoria =  $_POST['id_subcategoria'];
$id_proveedor =  $_POST['id_proveedor'];

$proveedorMantenimiento = new ProveedorMantenimiento();

$listarSubcatePorProveedor = $proveedorMantenimiento->validarCantSubsPorProveedor($id_proveedor, $id_subcategoria);

echo $listarSubcatePorProveedor[0]['costo'];
?>