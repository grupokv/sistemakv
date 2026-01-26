<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
$id = $_GET['id'];
require('bd/datos.php');
$querys = new consultas;

$contenidoid=$querys->invitacion_id($id);
$actividad = $querys->actividad_id2($contenidoid[0]['id_actividad']);
$pareto = $querys->pareto_fecha($_SESSION['idus'],$actividad[0]['fecha']);
if(count($pareto) > 0){
	$idpareto = $pareto[0]['id'];
} else {
	$idpareto = 0;
}
echo $idpareto;
$hoy = date('Y-m-d H:i:s');
$idusuario = $_SESSION['idus'];
$descripc = $actividad[0]['descripcion'];
$tipo = $actividad[0]['id_tipoactividad'];
$fechap = $actividad[0]['fecha'];
$horai = $actividad[0]['hora'];
$horaf = $actividad[0]['hora_fin'];
$idcreador = $actividad[0]['id_creador'];

$sql = "insert into pareto_actividades 
(id_usuario,id_pareto,id_padre,descripcion,id_tipoactividad,estado,fecha,hora,fecha_fin,hora_fin,fecha_creacion,fecha_modificacion,activo,id_creador,id_frecuencia,aplica_objetivo,id_objetivo) 
values 
('$idusuario','$idpareto','0','$descripc','$tipo','0','$fechap','$horai','$fechap','$horaf','$hoy','$hoy','A','$idcreador','1','N','0')";
$insert = new base_datos;
$insert->connect();
$insert->query($sql);

$sql = "update invitaciones set estado = 'A', respuesta = 'ACEPTADA - $hoy' WHERE id_invitacion = '$id' and id_invitado = '$idusuario'";
$insert = new base_datos;
$insert->connect();
$insert->query($sql);

echo ("<SCRIPT LANGUAGE='JavaScript'>
alert('Actividad Agregada Correctamente');
window.location.href='invitaciones.php';
</SCRIPT>");
?>
