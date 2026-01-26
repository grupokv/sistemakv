<?php require_once("../Modelo/CargoCliente.php");
$id_cliente = $_POST['id_cliente'];
$id_cargo = $_POST['id_cargo'];
$cc = new CargoCliente();
$listado = $cc->listarCargosPorCliente($id_cliente);
$d = count($listado);
$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($listado as $ls) {
		if($ls['id_cargo'] == $id_cargo){
		$html .= '<option value=' .$ls['id_cargo'].' selected="selected">' . $ls['detalle']. '</option>';
		} else {
		$html .= '<option value=' .$ls['id_cargo'].'>' . $ls['detalle']. '</option>';
		}
	}
}
echo $html;
?>