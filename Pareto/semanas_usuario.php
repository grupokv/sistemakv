<?php
require('bd/datos.php');

$usuario = $_POST['usuario'];

$semanasu = array();
$cons = new base_datos;
$cons->connect();
$sql = "Select * from pareto where id_usuario = '$usuario' order by id Desc";
$res = $cons->query($sql);
while($item = $cons->fetch_row($res))	{
	array_push($semanasu,$item);
}
$html = '';
$cantidad = count($semanasu);
if($cantidad < 1){
	$html = 'No hay registros';
} else {
	foreach($semanasu as $sem){
		$html .= '<option value="'.$sem["id"].'|'.$sem["fecha_inicial"].'|'.$sem["fecha_final"].'" >'.$sem["id"].' - '.$sem["fecha_inicial"].' / '.$sem["fecha_final"].'</option>';
	}
}
echo $html;
?>