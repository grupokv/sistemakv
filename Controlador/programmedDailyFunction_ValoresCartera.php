<?php

require_once("../Modelo/Cartera.php");
$cartera = new Cartera();

$mes_fecha_cobro = date('m');
$anio_fecha_cobro = date('Y');
$listarCarteraVehiculosAfiliados = $cartera->listarCarteraVehiculosAfiliados($mes_fecha_cobro, $anio_fecha_cobro);

$fecha_actualizacionCobro = date('Y-m') . "-" . 15;

foreach ($listarCarteraVehiculosAfiliados as $lcva) {
    $valor_actual = ($lcva['valor'] + 20000);
    if(date('Y-m-d') > $fecha_actualizacionCobro){
        $actualizarValorConceptoCartera = $cartera->actualizarValorConceptoCartera($lcva['id_cobro'], $valor_actual);
    }
}

?>