<?php
require_once("../Modelo/Contrato.php");

$contrato = new Contrato();

echo $id_proyecto = $_POST['id_proyecto'];
echo $id_tarifa_proyecto = $_POST['id_tarifa_proyecto'];
echo $valor_tercero = $_POST['valor_tercero'];

$registrarTarifasTerceros = $contrato->registrarTarifasTerceros($id_proyecto, $id_tarifa_proyecto, $valor_tercero);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('La tarifa del tercero se registro correctamente');
    window.location.href='../Vista/contratos.php';
    </script>");

?>