<?php  
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/Convenio.php");

$clienteConvenio = new Cliente_Convenio();
$convenio = new Convenio();

$id_convenio = $_POST['id_convenio'];
$listarConvenioId = $convenio->listarId($id_convenio);

$listarClienteID = $clienteConvenio->cliente_ID($listarConvenioId[0]['id_cliente']);

echo $listarClienteID[0]['razon_social'];


?>