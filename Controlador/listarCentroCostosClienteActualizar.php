<?php require_once("../Modelo/CentroCostoCliente.php");
$id_cliente = $_POST['id_cliente'];
$id_centro_costo = $_POST['id_centro_costo'];
$cc = new CentroCostoCliente();
$listado = $cc->listarPorCliente($id_cliente);
$d = count($listado);
$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($listado as $ls) {
		if($ls['id_centro_costo'] == $id_centro_costo){
		$html .= '<option value=' .$ls['id_centro_costo'].' selected="selected">' . $ls['detalle']. '</option>';
		} else {
		$html .= '<option value=' .$ls['id_centro_costo'].'>' . $ls['detalle']. '</option>';
		}
	}
}
echo $html;
?>