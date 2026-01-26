<?php 
require_once("../Modelo/Cartera.php");

$id_acuerdo = $_POST['id_acuerdo'];
$estado = $_POST['estado'];

$cartera = new Cartera();

$existe = $cartera->buscarAcuerdoPago($id_acuerdo);

if(count($existe) > 0){
    $actualizar = $cartera->actualizarEstadoAcuerdoPago($id_acuerdo, $estado);
    echo $id_acuerdo;
} else {
    echo 0;
}
?>