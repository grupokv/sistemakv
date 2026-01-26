<?php 

require_once("../Modelo/General.php");

$id_pais = $_POST['id_pais'];
$id_departamento = $_POST['id_departamento'];

$departamentos = Departamentos($id_pais);
$d = count($departamentos);

$html = '<option value="">Selecione opcion</option>';
if ($d > 0) {
	foreach ($departamentos as $dep) {
		if($id_departamento == $dep['id_departamento']){
			$html .= '<option value=' .$dep['id_departamento'].' selected="selected">' . $dep['departamento']. '</option>';	
		} else {
			$html .= '<option value=' .$dep['id_departamento'].'>' . $dep['departamento']. '</option>';
		}
	}
} 

echo $html;

 ?>