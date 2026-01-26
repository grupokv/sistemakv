<?php 

require_once '../Modelo/Contrato.php';

$contrato = new Contrato();

$id_proyecto = $_POST['id_proyecto'];
$id_contrato = $_POST['id_contrato'];
$nombre_proyecto = $_POST['nombre_proyecto'];

$actualizarProyecto = $contrato->actualizarProyectosContratos($id_proyecto, $id_contrato, $nombre_proyecto);

echo "<script>alert('El proyecto se actualizó correctamente.'); window.location.href='../Vista/contratos.php';</script>";
?>