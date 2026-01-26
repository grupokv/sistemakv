<?php
require('qrlib.php');
include("../../../Controlador/Sesion/autenticar.php");
require_once("../../../Modelo/Fuec.php");

$id = $_POST['id'];
$id_oca = $_GET['id_fuecOcasional'];


if (( $id != '' )&&( $id_oca == '')) {

$fuec = new Fuec();
$datos = $fuec->listarFuecPorId($id);

$codigo = $datos[0]['num_comprobante'];
$nombre = $codigo.'.png';

$codigo = 'https://www.sistemakv.com/Vista/verificarfuec.php?cod='.$codigo;

$imgcodigo = 'codigos/'.$nombre; 

QRcode::png($codigo,$imgcodigo);

//echo '<img src="'.$imgcodigo.'" />';

}else if (( $id == '' )&&( $id_oca != '')) {

	$fuec = new Fuec();
	$datos = $fuec->listarFuecPorId($id_oca);

	$codigo = $datos[0]['num_comprobante'];
	$nombre = $codigo.'.png';

	$codigo = 'https://www.sistemakv.com/Vista/verificarfuec.php?cod='.$codigo;

	$imgcodigo = 'codigos/'.$nombre; 

	QRcode::png($codigo,$imgcodigo);

	//echo '<img src="'.$imgcodigo.'" />';

	header('Location: ../../../Vista/registrarUsuariosContratos.php?id_contrato_ocasional='. $datos[0]['id_contrato_ocasional']);

}

?>