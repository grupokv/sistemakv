<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$id_cliente = $_POST['id_cliente'];

$operativo = new Operativo();
$listarProductos = $operativo->listarProductos();
$listarProductosPorCliente = $operativo->listarProductosPorCliente($id_cliente);

$html = "";

if($id_cliente == ""){
    $html .= "<option value=''>SELECCIONAR</option>";
    foreach ($listarProductos as $lp){
        $html .= "<option value='" . $lp['id_producto'] . "'>" . $lp['detalle_producto']. " ( " . $lp['tipo_producto'] . ") </option>";
    }
}else{
    $html .= "<option value=''>SELECCIONAR</option>";
    foreach($listarProductosPorCliente as $lppc){
        $html .= "<option value='" . $lppc['id_producto'] . "'>" . $lppc['detalle_producto']. " ( " . $lppc['tipo_producto'] . ") </option>";
    }
}

echo $html;

?>