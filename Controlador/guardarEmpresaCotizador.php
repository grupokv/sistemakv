<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$razon_social = mb_strtoupper($_POST['razon_social']);
$nit = $_POST['nit'];
$direccion = mb_strtoupper($_POST['direccion']);
$telefono = $_POST['telefono'];
$logo = $_FILES['logo']['name'];
$estado = $_POST['estado'];

if (isset($logo)) {

        if (!empty($_FILES['logo']['name'])) {

            $ruta = "../Resources/fpdf/img/". $_FILES['logo']['name'];

            $ruta_temp = $_FILES['logo']['tmp_name'];
            move_uploaded_file($ruta_temp, $ruta);   
        }
}

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->guardar_empresa($razon_social, $nit, $direccion, $telefono, $logo, $estado);

if($registrar > 0){
    echo "<script>
    alert('Empresa registrada correctamente');
    window.location.href='../Vista/CotizacionAdminEmpresas.php';
    </script>";
} else {
    echo "<script>
    alert('Error al registrar empresa');
    window.history.back();
    </script>";
}
?>