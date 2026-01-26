<?php
session_start();
require('bd/datos.php');
$querys = new consultas;

$date = date('Y-m-d H:i:s');
$id = $_POST['id'];

$obj_especificosid = $querys->obj_especificosid2($id);

$periodo = $obj_especificosid[0]['fecha_presentacion'];
$continuidad = $obj_especificosid[0]['continuidad'];
$actual = $obj_especificosid[0]['proxima_alerta'];
$fechaproxima = $querys->proximaalertaobj($periodo,$continuidad,$actual);

$sql = "update obj_especificos set proxima_alerta = '$fechaproxima' where id = '$id'";
$insert = new base_datos;
$insert->connect();
$insert->query($sql);
?>