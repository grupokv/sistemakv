<?php 

require_once("../Modelo/General.php");

$id_pais = $_POST['id_pais'];

$departamentos = Departamentos($id_pais);
$d = count($departamentos);

$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($departamentos as $dep) {
		$html .= '<option value=' .$dep['id_departamento'].'>' . $dep['departamento']. '</option>';
	}
}

echo $html;

 ?>