<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");

date_default_timezone_set('America/Bogota');


$id_usuario = $_SESSION['id_usuario'];
$fecha = date('YmdHis');

$nombreDocSS = $_POST['nombre_doc_ss'];
$documentoSS = $_FILES['doc_ss']['name'];
$mesSS = $_POST['mes'];
$anioSS = $_POST['anio'];

for ($i=0; $i < count($documentoSS); $i++) { 
	

    $carpeta = '../Documentos/Empleados/SeguridadSocial';
    $ruta = $carpeta . '/' . $fecha . '-' . $documentoSS[$i];
    $docSS = $fecha .'-'. $documentoSS[$i];

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }

    $ruta_temp = $_FILES['doc_ss']['tmp_name'][$i];
    move_uploaded_file($ruta_temp, $ruta);
        
	$nombreDoc = $nombreDocSS[$i];
	$anio = $anioSS[$i];
	$mes = $mesSS[$i];

	$empleado = new Empleado();
	$registrarSeguridadSocialEmpleado = $empleado->registrarSeguridadSocialEmpleado($nombreDoc, $docSS, $anio, $mes, $id_usuario);
}

header('Location: ../Vista/seguridadSocialEmpleados.php');



?>