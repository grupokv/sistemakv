<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Curso.php");

$colegio = $_POST['colegio'];

$curso = new Curso();
$ListarCursos = $curso->listarCursoPorIdColegio($colegio);

//print_r($ListarCursos);

$html = '';
$cantidad = count($ListarCursos);
if($cantidad < 1){
	$html = 'No hay registros';
} else {
	foreach($ListarCursos as $lc){
		$html .= '<option value="'.$lc["id_curso"].'" >'.$lc["nombre"].'</option>';
	}
}
echo $html;
?>
