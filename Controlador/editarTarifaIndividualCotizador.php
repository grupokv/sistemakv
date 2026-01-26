<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id'];
$valor = $_POST['valor_base'];
$espera = $_POST['dia_espera'];
$servicio = $_POST['dia_servicio'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->editar_tarifa_individual($id,$valor,$espera,$servicio);

if($id > 0){
    echo "<script>
    alert('Tarifa editada correctamente');
    window.location.href='../Vista/CotizacionAdminTarifaIndividual.php';
    </script>";
} else {
    echo "<script>
    alert('Error al editar tarifa');
    window.history.back();
    </script>";
}
?>