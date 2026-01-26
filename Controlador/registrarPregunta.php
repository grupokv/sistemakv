<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");
require_once("../Modelo/General.php");

$id_encuesta = $_POST['id_encuesta'];
$pregunta = mb_strtoupper($_POST['pregunta']);
$tipo = $_POST['tipo'];

$orden = $_POST['orden'];
$posicion = $_POST['posicion'];

$encuesta = new Encuesta();

if($orden != $posicion){
	if($orden < $posicion){
		$min = $orden;
		$max = $posicion;
		$preguntas_mayores = $encuesta->preguntasFiltroMenor($id_encuesta,$min,$max);
	} else if($orden > $posicion) {
		$max = $orden;
		$min = $posicion;
		$preguntas_mayores = $encuesta->preguntasFiltroMayor($id_encuesta,$min,$max);
	}

	foreach($preguntas_mayores as $pm){
		$id = $pm['id_pregunta'];
		if($orden < $posicion){
			$nueva = ($pm['orden'] + 1);
		} else {
			$nueva = ($pm['orden'] - 1);
		}
		$act = $encuesta->actualizarPosicion($id,$nueva);
	}
}

$registrar = $encuesta->registrarPregunta($tipo, $pregunta, $orden, $id_encuesta);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Pregunta creada correctamente');
    window.location.href='../Vista/preguntasEncuesta.php?id=".$id_encuesta."';
    </script>");
?>