<?php
require('bd/datos.php');

$usuario = $_POST['usuario'];

$annosu = array();
$cons = new base_datos;
$cons->connect();
$sql = "SELECT extract(month from fecha_inicial) as mes, EXTRACT(year from fecha_inicial) as anno FROM pareto where id_usuario = '$usuario' group by extract( year from fecha_inicial )
UNION
SELECT extract(month from fecha_final) as mes, extract(year from fecha_final) as anno FROM pareto where id_usuario = '$usuario'  group by extract( year from fecha_final ) order by anno Desc, mes Desc";
$res = $cons->query($sql);
while($item = $cons->fetch_row($res))	{
	array_push($annosu,$item);
}
$html = '';
$cantidad = count($annosu);
if($cantidad < 1){
	$html = 'No hay registros';
} else {
	foreach($annosu as $anno){
		$html .= '<option value="'.$anno["mes"].'|'.$anno["anno"].'" >'.$anno["mes"].' / '.$anno["anno"].'</option>';
	}
}
echo $html;
?>
