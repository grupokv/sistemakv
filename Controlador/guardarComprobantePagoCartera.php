<?php 
include 'Sesion/autenticar.php';
require_once("../Modelo/Cartera.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

$doc = $_FILES['doc_comprobante_file']['name'];
$id_acuerdo = $_POST['id_acuerdo_comprobante'];
$valor = $_POST['valor_comprobante'];
$fecha_pago = $_POST['fecha_comprobante'];
$hoy = date('Y-m-d H:i:s');
$estado = 1;
$id_usuario = $_SESSION['id_usuario'];

$cartera = new Cartera();
$det_acuerdo = $cartera->buscarAcuerdoPago($id_acuerdo);

if (isset($doc)){
	if (!empty($_FILES['doc_comprobante_file']['name'])) {

	    $carpeta = $carpeta = '../Documentos/Cartera/';
	    $ruta = $carpeta .'/'. $fecha.'-'. $_FILES['doc_comprobante_file']['name'];
	   	$doc = $fecha . '-' . $doc;

	    if (!file_exists($carpeta)) {
	        mkdir($carpeta, 0757, true);
	    }

	    $ruta_temp = $_FILES['doc_comprobante_file']['tmp_name'];
	    move_uploaded_file($ruta_temp, $ruta);
	}

}

$cargarC = $cartera->cargarComprobantePago($det_acuerdo[0]['id_vehiculo'],$fecha_pago,$valor,$doc,$id_acuerdo,$hoy,$id_usuario,$estado);

//echo $doc_acuerdo.'<br/>'.$id_acuerdo_doc;

header("Location: ../Vista/cobro_cartera.php");

?>