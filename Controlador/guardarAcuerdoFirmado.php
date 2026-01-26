<?php 
include 'Sesion/autenticar.php';
require_once("../Modelo/Cartera.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

print_r($_FILES);

$doc_acuerdo = $_FILES['doc_firmado_file']['name'];
$id_acuerdo_doc = $_POST['id_acuerdo_doc'];

if (isset($doc_acuerdo)){
	if (!empty($_FILES['doc_firmado_file']['name'])) {

	    $carpeta = $carpeta = '../Documentos/Cartera/';
	    $ruta = $carpeta .'/'. $fecha.'-'. $_FILES['doc_firmado_file']['name'];
	   	$doc_acuerdo = $fecha . '-' . $doc_acuerdo;

	    if (!file_exists($carpeta)) {
	        mkdir($carpeta, 0757, true);
	    }

	    $ruta_temp = $_FILES['doc_firmado_file']['tmp_name'];
	    move_uploaded_file($ruta_temp, $ruta);
	}

}

$cartera = new Cartera();
$cargarC = $cartera->cargarAcuerdoFirmado($doc_acuerdo, $id_acuerdo_doc);

//echo $doc_acuerdo.'<br/>'.$id_acuerdo_doc;

header("Location: ../Vista/cobro_cartera.php");

?>