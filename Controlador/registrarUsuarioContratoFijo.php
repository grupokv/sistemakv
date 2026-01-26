<?php 
require_once("../Modelo/UsuarioContratoFijo.php");

$id_contrato = $_POST['id_contrato'];

$nombre = $_POST['nombre_usuario'];
$documento = $_POST['numero_documento'];

$UsuarioContratoFijo = new UsuarioContratoFijo();

for ($i=0; $i < count($nombre); $i++) { 
	$nombre_usuario = $nombre[$i];
	$numero_documento = $documento[$i];

	$registrar = $UsuarioContratoFijo->registrar($id_contrato, $nombre_usuario, $numero_documento);	
}

echo "<script>alert('Usuarios registrados correctamente.'); window.location.href='../Vista/usuariosContratosFijos.php';</script>"

 ?>
