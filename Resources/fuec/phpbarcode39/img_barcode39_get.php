	<?php
include "Barcode39.php"; 
include("../../../Controlador/Sesion/autenticar.php");
require_once("../../../Modelo/Fuec.php");

$id = $_POST['id'];
$id_oca = $_GET['id_fuecOcasional'];

//$id = $_GET['id'];

if (( $id != '' )&&( $id_oca == '')) {
	
	$fuec = new Fuec();
	$datos = $fuec->listarFuecPorId($id);

	$codigo = $datos[0]['num_interno'];

	$nombre = $codigo.'.gif';
	$imgcodigo = 'codigos/'. $nombre;
	// set Barcode39 object 
	$bc = new Barcode39($codigo);

	// set text size 
	$bc->barcode_text_size = 2; 

	// set barcode bar thickness (thick bars) 
	$bc->barcode_bar_thick = 4; 

	// set barcode bar thickness (thin bars) 
	$bc->barcode_bar_thin = 2; 

	$bc->draw($imgcodigo);

}else if (( $id == '' )&&( $id_oca != '')) {

	$fuec = new Fuec();
	$datos = $fuec->listarFuecPorId($id_oca);

	$codigo = $datos[0]['num_interno'];

	$nombre = $codigo.'.gif';
	$imgcodigo = 'codigos/'. $nombre;
	// set Barcode39 object 
	$bc = new Barcode39($codigo);

	// set text size 
	$bc->barcode_text_size = 2; 

	// set barcode bar thickness (thick bars) 
	$bc->barcode_bar_thick = 4; 

	// set barcode bar thickness (thin bars) 
	$bc->barcode_bar_thin = 2; 

	$bc->draw($imgcodigo);

	header('Location: ../phpqrcode/img_qr.php?id_fuecOcasional='. $id_oca);
}

?>
