<?php 

require_once '../Modelo/Subcategoria_Mantenimiento.php';
require_once '../Modelo/Categoria_Mantenimiento.php';

$categoria = new Categoria_Mantenimiento();
$subCategoria = new Subcategoria_Mantenimiento();

$id_proveedor = $_POST['id_proveedor'];
$id_categoria = $_POST['id_categoria'];

$listarPorCategoria = $subCategoria->listarPorCategoria($id_categoria);
$listarSubcategoriaProveedor = $subCategoria->listarSubcategoriaProveedor($id_proveedor);

$array = array();
foreach ($listarSubcategoriaProveedor as $lscp) {
	array_push($array, $lscp['id_subcategoria']);
}


$html = '';
$html .= '<option value=""> SELECCIONAR</option>';

foreach ($listarPorCategoria as $lcp) {
	if (in_array($lcp['id_subcategoria'],$array)) {	
		$html .= '<option value="'. $lcp['id_subcategoria'] .'"> '. $lcp['detalle_subcategoria'] .'</option>';
	}
}

echo $html;


 ?>