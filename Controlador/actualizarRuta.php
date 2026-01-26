<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");
$id = $_POST['id'];$cliente = $_POST['id_cliente'];
$num_ruta = mb_strtoupper($_POST['num_ruta']);
$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];$id_monitor = $_POST['id_monitor'];
$veh = new Vehiculo();
$actualizar = $veh->actualizarRuta($id,$cliente,$id_vehiculo,$id_conductor,$id_monitor,$num_ruta);
echo ("<script LANGUAGE='JavaScript'>
    window.alert('Registro Actualizado Correctamente');
    window.location.href='../Vista/listado_rutas_cliente.php?id_cliente=".$cliente."';
    </script>");
?>