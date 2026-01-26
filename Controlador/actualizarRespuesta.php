	<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");
require_once("../Modelo/General.php");

$id_respuesta = $_POST['id_respuesta'];
$id_encuesta = $_POST['id_encuesta'];
$id_pregunta = $_POST['id_pregunta'];
$tipo_pregunta = $_POST['tipo_pregunta'];
$respuesta = mb_strtoupper($_POST['respuesta']);
$ampliacion = $_POST['ampliacion'];
$orden = $_POST['orden'];
$posicion = $_POST['posicion'];

$encuesta = new Encuesta();

if($orden != $posicion){
	if($orden < $posicion){
		$min = $orden;
		$max = $posicion;
		$respuestas_mayores = $encuesta->respuestasFiltroMenor($id_pregunta,$min,$max);
	} else if($orden > $posicion) {
		$max = $orden;
		$min = $posicion;
		$respuestas_mayores = $encuesta->respuestasFiltroMenor($id_pregunta,$min,$max);
	}

	foreach($respuestas_mayores as $pm){
		$id = $pm['id_respuesta'];
		if($orden < $posicion){
			$nueva = ($pm['orden'] + 1);
		} else {
			$nueva = ($pm['orden'] - 1);
		}
		$act = $encuesta->actualizarPosicionRespuesta($id,$nueva);
	}
}

$registrar = $encuesta->actualizarRespuesta($id_respuesta, $respuesta, $id_pregunta, $ampliacion, $orden);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Respuesta actualizada correctamente');
    window.location.href='../Vista/respuestasEncuesta.php?datos=".$id_encuesta."_".$id_pregunta."_".$tipo_pregunta."';
    </script>");
?>