<?php 

//include ("Sesion/autenticar.php");
require_once("../Modelo/Cotizador.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$departamento = $_POST['departamento'];
$ciudad = $_POST['ciudad'];
$dias = $_POST['dias'];
$kilometraje = $_POST['kilometraje'];
$kms = ($_POST['kilometraje']*2);
$peajes = $_POST['peajes'];
$total_peajes = $_POST['total_peajes'];

$peaje_campero = $_POST['peaje_campero'];
$valor_campero = $_POST['valor_campero'];
$peaje_doblecabina = $_POST['peaje_doblecabina'];
$valor_doblecabina = $_POST['valor_doblecabina'];
$peaje_van = $_POST['peaje_van'];
$valor_van = $_POST['valor_van'];
$peaje_microbus = $_POST['peaje_microbus'];
$valor_microbus = $_POST['valor_microbus'];
$peaje_buseta = $_POST['peaje_buseta'];
$valor_buseta = $_POST['valor_buseta'];
$peaje_buseton = $_POST['peaje_buseton'];
$valor_buseton = $_POST['valor_buseton'];
$peaje_bus = $_POST['peaje_bus'];
$valor_bus = $_POST['valor_bus'];

$cotizacion = new Cotizador();
$actualizar = $cotizacion->actualizarDestino($id, $ciudad, $departamento, $dias, $kilometraje, $kms, $peajes, $peaje_campero, $valor_campero, $peaje_doblecabina, $valor_doblecabina, $peaje_van, $valor_van, $peaje_microbus, $valor_microbus, $peaje_buseta, $valor_buseta, $peaje_buseton, $valor_buseton, $peaje_bus, $valor_bus);

echo ("<script LANGUAGE='JavaScript'>
    window.alert('Destino Actualizado Correctamente');
    window.location.href='../Vista/adminDestinosCotizacion.php';
    </script>");

?>