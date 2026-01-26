<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$valor = $_POST['valor'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->guardar_descuento($valor);

if($registrar > 0){
    echo "<script>
    alert('Descuento registrado correctamente');
    window.location.href='../Vista/CotizacionAdminDescuentos.php';
    </script>";
} else {
    echo "<script>
    alert('Error al registrar descuento');
    window.history.back();
    </script>";
}
?>