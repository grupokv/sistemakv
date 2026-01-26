<?php require_once("../Modelo/CentroCostoCliente.php");
$id_cliente = $_POST['id_cliente'];
$cc = new CentroCostoCliente();
$listado = $cc->listarPorCliente($id_cliente);
$d = count($listado);
$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($listado as $ls) {
		$html .= '<option value=' .$ls['id_centro_costo'].'>' . $ls['detalle']. '</option>';
	}
}
echo $html;
?>