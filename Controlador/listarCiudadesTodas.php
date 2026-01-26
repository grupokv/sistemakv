<?php
require_once("../Modelo/Ciudad.php");

$ciudad = new Ciudad();
$ciudades = $ciudad->listar();
$c = count($ciudades);

$html = '<option value="">SELECCIONAR</option>';
if ($c > 0) {
	foreach ($ciudades as $ciu) {
		$html .= '<option value=' .$ciu['id_ciudad'].'>' . $ciu['ciudad']. '</option>';
	}
}

echo $html;

?>