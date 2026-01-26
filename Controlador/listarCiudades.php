<?php 

require_once("../Modelo/General.php");

$id_departamento = $_POST['id_departamento'];

$ciudades = Ciudades($id_departamento);
$c = count($ciudades);

$html = '<option value="">Seleccione opcion</option>';
if ($c > 0) {
	foreach ($ciudades as $ciu) {
		$html .= '<option value=' .$ciu['id_ciudad'].'>' . $ciu['ciudad']. '</option>';
	}
}

echo $html;

 ?>