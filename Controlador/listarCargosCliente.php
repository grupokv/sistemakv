<?php require_once("../Modelo/CargoCliente.php");
$id_cliente = $_POST['id_cliente'];
$cc = new CargoCliente();
$listado = $cc->listarCargosPorCliente($id_cliente);
$d = count($listado);
$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($listado as $ls) {
		$html .= '<option value=' .$ls['id_cargo'].'>' . $ls['detalle']. '</option>';
	}
}
echo $html;
?>