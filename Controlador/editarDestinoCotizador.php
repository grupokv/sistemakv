<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id'];
$nombre = mb_strtoupper($_POST['nombre']);
$kms = $_POST['kms'];
$dias_viaje = $_POST['dias_viaje'];
$valor_4_pax = $_POST['valor_4_pax'];
$valor_19_pax = $_POST['valor_19_pax'];
$valor_24_pax = $_POST['valor_24_pax'];
$valor_30_pax = $_POST['valor_30_pax'];
$valor_40_pax = $_POST['valor_40_pax'];
$valor_45_pax = $_POST['valor_45_pax'];
$cant_peajes = $_POST['cant_peajes'];
$estado = $_POST['estado'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->editar_destino($id,$nombre, $kms, $dias_viaje, $valor_4_pax, $valor_19_pax, $valor_24_pax, $valor_30_pax, $valor_40_pax, $valor_45_pax, $cant_peajes, $estado);

if($id > 0){
    echo "<script>
    alert('Destino editado correctamente');
    window.location.href='../Vista/CotizacionAdminDestinos.php';
    </script>";
} else {
    echo "<script>
    alert('Error al editar destino');
    window.history.back();
    </script>";
}
?>