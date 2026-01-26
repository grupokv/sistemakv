<?php 
require_once '../Modelo/Contrato.php';

$contrato = new Contrato();

$id_contrato = $_POST['id_contrato'];
$nombre_proyecto = $_POST['nombre_proyecto'];

$registrarProyecto = $contrato->registrarProyectosContratos($id_contrato, $nombre_proyecto);


header("Location: ../Vista/registrarTarifasProyecto.php?id_proyecto=" . $registrarProyecto);

 ?>