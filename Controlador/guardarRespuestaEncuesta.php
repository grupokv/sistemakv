<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Encuesta.php");

$id_encuesta = $_POST['ide'];

$encuesta = new Encuesta();

$usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');
$fecha_archivo = date('YmdHis');

$preguntas = $encuesta->listarPreguntasPorIdEncuesta($id_encuesta);
$cant = count($preguntas);

if($cant > 0){
	foreach($preguntas as $preg){
		$respuestas = $encuesta->listarRespuestasPorIdPregunta($preg['id_pregunta']);
		$cant1 = count($respuestas);
		
		if($preg['id_tipo_pregunta'] == '1'){
			if($cant1 > 0){
				
				$array = $_POST['checkbox_'.$preg["id_pregunta"]];
				
				for($i = 0; $i<= count($array); $i++){
					$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],$array[$i],'','I',$usuario,$fecha);
				}
			}
		}
		
		if($preg['id_tipo_pregunta'] == '2'){
			if($cant1 > 0){
				
				$respuesta = $_POST['radio_'.$preg["id_pregunta"]];
				$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],$respuesta,'','I',$usuario,$fecha);
			}
		}
		
		if($preg['id_tipo_pregunta'] == '3'){			
				$respuesta = $_POST['detalle_'.$preg["id_pregunta"]];
				$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],'0',$respuesta,'I',$usuario,$fecha);
		}
		
		if($preg['id_tipo_pregunta'] == '4'){
			if($cant1 > 0){
				$array = $_POST['checkbox_'.$preg["id_pregunta"]];
				for($i = 0; $i<= count($array); $i++){
					$ampliacion = $_POST['detalle_'.$preg["id_pregunta"].'_'.$array[$i]];
					if(($ampliacion == '')or($ampliacion == NULL)){
						$ampliacion = '';
					}
					$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],$array[$i],$ampliacion,'I',$usuario,$fecha);
				}
			}
		}
		
		if($preg['id_tipo_pregunta'] == '5'){
			if($cant1 > 0){
				$respuesta = $_POST['radio_'.$preg["id_pregunta"]];
				$ampliacion = $_POST['detalle_'.$preg["id_pregunta"].'_'.$respuesta];
				if(($ampliacion == '')or($ampliacion == NULL)){
					$ampliacion = '';
				}
				$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],$respuesta,$ampliacion,'I',$usuario,$fecha);
			}
		}
		
		if($preg['id_tipo_pregunta'] == '6'){
			if (!empty($_FILES['file_'.$preg["id_pregunta"]]['name'])) {
				$arc = $_FILES['file_'.$preg["id_pregunta"]]['name'];
				$arc_temp = $_FILES['file_'.$preg["id_pregunta"]]['tmp_name'];
				$carpeta = '../Documentos/Encuestas/'.$id_encuesta;
                $ruta = $carpeta .'/'. $fecha_archivo .'-'. $arc;
                $archivo = $fecha_archivo .'-'. $arc;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                move_uploaded_file($arc_temp, $ruta);
				
				$registrar = $encuesta->registrarRespuestaUsuario($id_encuesta,$preg['id_pregunta'],'0',$archivo,'I',$usuario,$fecha);
			}
		}
		
	}
}

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Encuesta diligenciada correctamente');
    window.location.href='../Vista/diligenciar_encuesta.php?id=".$id_encuesta."';
    </script>");
?>