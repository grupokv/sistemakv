<?php 

require_once("../Modelo/General.php");

$id_departamento = $_POST['id_departamento'];
$id_ciudad = $_POST['id_ciudad'];


$ciudades = Ciudades($id_departamento);
$c = count($ciudades);

$html = '<option value="">Selecione opcion</option>';
if ($c > 0) {
	foreach ($ciudades as $ciu) {
		if($id_ciudad == $ciu['id_ciudad']){
			$html .= '<option value=' .$ciu['id_ciudad'].' selected="selected">' . $ciu['ciudad']. '</option>';	
		} else {

		$html .= '<option value=' .$ciu['id_ciudad'].'>' . $ciu['ciudad']. '</option>';

		}
	}
} 

echo $html;

 ?>