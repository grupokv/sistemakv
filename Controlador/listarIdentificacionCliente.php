<?php
require_once("../Modelo/Cliente.php");

$cliente = new Cliente();

$id_cliente = $_POST['id_cliente'];

$listarClientePorId = $cliente->cliente_ID($id_cliente);

echo $listarClientePorId[0]['nit_cliente'];

?>