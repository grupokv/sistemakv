<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Correspondencia.php");

$correspondencia = new Correspondencia();

$id = $_POST['id_doc'];
//print_r($_POST);
$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = uniqid().'.png';

$micarpeta = '../firmas';
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}

file_put_contents('../firmas/'.$fileName, $fileData);

$firma = $fileName;
$fecha = date('Y-m-d H:i:s');

$actualizar = $correspondencia->entregar($fecha,$firma,$id);

echo "<script>
    alert('Documento entregado correctamente');
    window.location = 'correspondencia.php';
  	</script>";
?>