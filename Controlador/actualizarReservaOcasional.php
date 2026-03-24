<?php
include("Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");
require_once("../Modelo/Ciudad.php");

function subirDocumentoPdf($campo, $idServicio)
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['name'] == '') {
        return '';
    }

    $nombre = $_FILES[$campo]['name'];
    $tmp = $_FILES[$campo]['tmp_name'];
    $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

    if ($extension != 'pdf') {
        return '';
    }

    $directorio = "../Documentos/ServiciosOcasionales/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreFinal = $idServicio . '_' . $campo . '_' . date('YmdHis') . '.pdf';
    move_uploaded_file($tmp, $directorio . $nombreFinal);

    return $nombreFinal;
}

$id_servicio_ocasional = isset($_POST['id_servicio_ocasional']) ? (int)$_POST['id_servicio_ocasional'] : 0;
$id_empresa = isset($_POST['id_empresa']) ? (int)$_POST['id_empresa'] : 0;
$tiposVehiculo = isset($_POST['id_tipo_vehiculo']) ? $_POST['id_tipo_vehiculo'] : array();

if (!is_array($tiposVehiculo) || count($tiposVehiculo) < 1) {
    echo "<script>alert('Debe seleccionar al menos un tipo de vehículo.'); window.history.back();</script>";
    exit;
}

$tiposVehiculo = array_map('trim', $tiposVehiculo);
$tiposVehiculo = array_filter($tiposVehiculo, function ($v) {
    return $v !== '';
});

$id_tipo_vehiculo = implode(',', $tiposVehiculo);
$tipo_servicio = isset($_POST['tipo_servicio_reserva']) ? trim($_POST['tipo_servicio_reserva']) : '';
$cantidad_vehiculos = isset($_POST['cantidad_vehiculos']) ? (int)$_POST['cantidad_vehiculos'] : 0;
$cantidad_pasajeros = isset($_POST['cantidad_pasajeros']) ? (int)$_POST['cantidad_pasajeros'] : 0;
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
$hora_inicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : '';
$hora_fin = isset($_POST['hora_fin']) ? $_POST['hora_fin'] : '';
$valor_servicio = isset($_POST['valor_servicio']) ? (float)$_POST['valor_servicio'] : 0;
$detalle_servicio = isset($_POST['detalle_servicio']) ? mb_strtoupper(trim($_POST['detalle_servicio'])) : '';
$origen_id = isset($_POST['origen']) ? (int)$_POST['origen'] : 0;
$destino_id = isset($_POST['destino']) ? (int)$_POST['destino'] : 0;
$id_cliente = isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : 0;

if ($id_servicio_ocasional <= 0 || $id_cliente <= 0 || $id_empresa <= 0 || $id_tipo_vehiculo <= 0 || $tipo_servicio === '') {
    echo "<script>alert('Datos incompletos para actualizar la reserva.'); window.history.back();</script>";
    exit;
}

if ($origen_id <= 0 || $destino_id <= 0) {
    echo "<script>alert('Seleccione ORIGEN y DESTINO.'); window.history.back();</script>";
    exit;
}

$ciudadModelo = new Ciudad();
$infoOrigen = $ciudadModelo->listarCiudadPorId($origen_id);
$infoDestino = $ciudadModelo->listarCiudadPorId($destino_id);

$origen = (count($infoOrigen) > 0 && isset($infoOrigen[0]['ciudad'])) ? mb_strtoupper(trim($infoOrigen[0]['ciudad'])) : '';
$destino = (count($infoDestino) > 0 && isset($infoDestino[0]['ciudad'])) ? mb_strtoupper(trim($infoDestino[0]['ciudad'])) : '';

if ($origen === '' || $destino === '') {
    echo "<script>alert('No fue posible obtener el nombre de ORIGEN/DESTINO.'); window.history.back();</script>";
    exit;
}

$servicioOcasional = new ServicioOcasional();
$ok = $servicioOcasional->actualizarServicioOcasional(
    $id_servicio_ocasional,
    $id_cliente,
    $id_empresa,
    $id_tipo_vehiculo,
    $tipo_servicio,
    $origen,
    $destino,
    $cantidad_vehiculos,
    $cantidad_pasajeros,
    $fecha_inicio,
    $fecha_fin,
    $hora_inicio,
    $hora_fin,
    $valor_servicio,
    $detalle_servicio
);

if (!$ok) {
    echo "<script>alert('No fue posible actualizar la reserva ocasional.'); window.history.back();</script>";
    exit;
}


$camposDocs = array('doc_rut', 'doc_camara', 'doc_cedula_rl', 'doc_aceptacion', 'doc_contrato', 'doc_primer_abono', 'doc_segundo_abono', 'doc_prefactura');
foreach ($camposDocs as $campo) {
    $nombreDocumento = subirDocumentoPdf($campo, $id_servicio_ocasional);
    if ($nombreDocumento != '') {
        $servicioOcasional->registrarDocumentoServicioOcasional($id_servicio_ocasional, $campo, $nombreDocumento);
    }
}

if (!headers_sent()) {
    header('Location: ../Vista/serviciosOcasionales.php');
    exit;
}

echo "<script>window.location.href='../Vista/serviciosOcasionales.php';</script>";