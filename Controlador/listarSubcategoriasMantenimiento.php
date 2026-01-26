<?php 
require_once("../Modelo/Subcategoria_Mantenimiento.php");
require_once("../Modelo/ProveedorMantenimiento.php");

$id_proveedor = $_POST['id_proveedor'];

$subcategorias = new Subcategoria_Mantenimiento();
$proveedor = new ProveedorMantenimiento();

$listado = $proveedor->listarsubcategoriaPorProveedores($id_proveedor);
$cant = count($listado);

//print_r($listado);

$html = '<option value="">Seleccione opcion</option>';

if ($cant > 0) {
	foreach ($listado as $lcs) {
		$subcategoria = $subcategorias->listarPorId($lcs['id_subcategoria']);
		$html .= '<option value="'. $lcs['id_subcategoria']. '">' . $subcategoria[0]['detalle_subcategoria'] . '</option>';
	}
}

echo $html;
?>