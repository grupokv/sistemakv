<?php
require_once("../Modelo/Conexion/conexionBD.php");
include ("Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
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

function generarDocumentoHtml($nombreArchivo, $titulo, $contenido)
{
    $directorio = "../Documentos/ServiciosOcasionales/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $html = "<!DOCTYPE html><html><head><meta charset='utf-8'><title>" . $titulo . "</title></head><body style='font-family:Arial,sans-serif;'>" . $contenido . "</body></html>";
    file_put_contents($directorio . $nombreArchivo, $html);

    return $nombreArchivo;
}

$cliente = new Cliente();
$servicioOcasional = new ServicioOcasional();
$ciudadModelo = new Ciudad();

$id_cliente = 0;
$opcionCliente = isset($_POST['opcionCliente']) ? $_POST['opcionCliente'] : '';
$idClienteExistente = isset($_POST['id_cliente_existente']) ? (int) $_POST['id_cliente_existente'] : 0;
$idClienteAnclado = isset($_POST['id_cliente_anclado']) ? (int) $_POST['id_cliente_anclado'] : 0;
if ($idClienteExistente <= 0 && $idClienteAnclado > 0) {
    $idClienteExistente = $idClienteAnclado;
}
if ($opcionCliente == '') {
    $opcionCliente = $idClienteExistente > 0 ? 'BA' : 'RN';
}

if ($opcionCliente == 'BA') {
    $id_cliente = $idClienteExistente;
    if ($id_cliente <= 0) {
        echo "<script>alert('Debe seleccionar un cliente en Buscar y Anclar.'); window.history.back();</script>";
        exit;
    }
} else {
    // REGISTRAR NUEVO (SIN TOCAR EL MÓDULO Cliente.php)
    // Se inserta DIRECTO en la tabla `clientes` usando los nombres reales de tus columnas.

    $razon_social = mb_strtoupper(trim($_POST['razon_social'] ?? ''));
    $sigla        = mb_strtoupper(trim($_POST['sigla'] ?? ''));
    $nit_cliente  = preg_replace('/\s+/', '', trim($_POST['nit_cliente'] ?? ''));

    //  Obligatorios mínimos
    if ($razon_social === '' || $nit_cliente === '') {
        echo "<script>alert('Faltan datos obligatorios del cliente: Razón social y NIT/Documento.'); window.history.back();</script>";
        exit;
    }

    $direccionC = mb_strtoupper(trim($_POST['direccion'] ?? ''));
    $telefonoC  = trim($_POST['telefono'] ?? '');

    if ($direccionC === '' || $telefonoC === '') {
        echo "<script>alert('Faltan datos obligatorios del cliente: Dirección y Teléfono.'); window.history.back();</script>";
        exit;
    }

    $correo_electronico   = trim($_POST['correo_electronico'] ?? '');
    $correo_facturacion   = trim($_POST['correo_facturacion'] ?? '');
    $representante_legalC = mb_strtoupper(trim($_POST['nombre_rl'] ?? ''));
    $numero_documentoC    = trim($_POST['doc_rl'] ?? '');

    // Ubicación / Segmento (según tu base y tu formulario)
    $id_ciudad       = (int)($_POST['id_ciudad'] ?? 0);
    $id_departamento = (int)($_POST['id_departamento'] ?? 0);
    $id_pais         = (int)($_POST['id_pais'] ?? 0);
    $id_segmento     = (int)($_POST['tipo_cliente'] ?? 0);

    if ($id_ciudad <= 0 || $id_departamento <= 0 || $id_pais <= 0 || $id_segmento <= 0) {
        echo "<script>alert('Complete la información obligatoria del cliente (país, departamento, ciudad y tipo/segmento).'); window.history.back();</script>";
        exit;
    }

    // Ciudades RL / expedición (si no vienen, heredan del cliente)
    $ciudad_residencia_rl = (int)($_POST['id_ciudad_rl'] ?? 0);
    if ($ciudad_residencia_rl <= 0) { $ciudad_residencia_rl = $id_ciudad; }

    $lugar_expedicionC = (int)($_POST['id_ciudad_exp'] ?? 0);
    if ($lugar_expedicionC <= 0) { $lugar_expedicionC = $ciudad_residencia_rl; }

    $fecha_expedicionC = trim($_POST['fecha_doc_rl'] ?? '');
    if ($fecha_expedicionC === '') { $fecha_expedicionC = date('Y-m-d'); }
    if (strpos($fecha_expedicionC, '/') !== false) {
        $fecha_expedicionC = str_replace('/', '-', $fecha_expedicionC);
    }

    //  Estado (1 activo, 0 inactivo)
    $estado = 1;
    $logo_cliente = null; // si tu columna permite NULL
    $id_usuario_registro = (int)($_SESSION['id_usuario'] ?? 0);

    //  1) Si ya existe por NIT, usarlo (sin modificar Cliente.php)
    $validarPorNitCliente = $cliente->validarPorNitCliente($nit_cliente);
    if (is_array($validarPorNitCliente) && count($validarPorNitCliente) > 0 && isset($validarPorNitCliente[0]['id_cliente'])) {
        $id_cliente = (int)$validarPorNitCliente[0]['id_cliente'];
    } else {
        //2) Insert directo en BD
        $con = Conexion::conectar();

        $sql = $con->prepare("
            INSERT INTO clientes (
                razon_social,
                sigla,
                nit_cliente,
                direccionC,
                correo_electronico,
                correo_facturacion,
                telefonoC,
                representante_legalC,
                ciudad_residencia_rl,
                numero_documentoC,
                fecha_expedicionC,
                lugar_expedicionC,
                id_ciudad,
                id_departamento,
                id_pais,
                id_segmento,
                estado,
                logo_cliente,
                id_usuario_registro
            ) VALUES (
                :razon_social,
                :sigla,
                :nit_cliente,
                :direccionC,
                :correo_electronico,
                :correo_facturacion,
                :telefonoC,
                :representante_legalC,
                :ciudad_residencia_rl,
                :numero_documentoC,
                :fecha_expedicionC,
                :lugar_expedicionC,
                :id_ciudad,
                :id_departamento,
                :id_pais,
                :id_segmento,
                :estado,
                :logo_cliente,
                :id_usuario_registro
            )
        ");

        $sql->bindParam(':razon_social', $razon_social);
        $sql->bindParam(':sigla', $sigla);
        $sql->bindParam(':nit_cliente', $nit_cliente);
        $sql->bindParam(':direccionC', $direccionC);
        $sql->bindParam(':correo_electronico', $correo_electronico);
        $sql->bindParam(':correo_facturacion', $correo_facturacion);
        $sql->bindParam(':telefonoC', $telefonoC);
        $sql->bindParam(':representante_legalC', $representante_legalC);
        $sql->bindParam(':ciudad_residencia_rl', $ciudad_residencia_rl);
        $sql->bindParam(':numero_documentoC', $numero_documentoC);
        $sql->bindParam(':fecha_expedicionC', $fecha_expedicionC);
        $sql->bindParam(':lugar_expedicionC', $lugar_expedicionC);
        $sql->bindParam(':id_ciudad', $id_ciudad);
        $sql->bindParam(':id_departamento', $id_departamento);
        $sql->bindParam(':id_pais', $id_pais);
        $sql->bindParam(':id_segmento', $id_segmento);
        $sql->bindParam(':estado', $estado);

        // Si tu columna NO permite NULL, cambia esto por '' (cadena vacía) o una ruta default
        $sql->bindValue(':logo_cliente', $logo_cliente, PDO::PARAM_NULL);

        $sql->bindParam(':id_usuario_registro', $id_usuario_registro);

        try {
    $sql->execute();

    $id_cliente = (int)$con->lastInsertId();

    // Si por alguna razón vino 0, buscar por NIT
    if ($id_cliente <= 0) {
        $clienteExistente = $cliente->validarPorNitCliente($nit_cliente);
        if (is_array($clienteExistente) && count($clienteExistente) > 0 && isset($clienteExistente[0]['id_cliente'])) {
            $id_cliente = (int)$clienteExistente[0]['id_cliente'];
        }
    }

} catch (Exception $e) {

    // Si falló (por ejemplo UNIQUE NIT), reintentar buscar por NIT
    $clienteExistente = $cliente->validarPorNitCliente($nit_cliente);
    if (is_array($clienteExistente) && count($clienteExistente) > 0 && isset($clienteExistente[0]['id_cliente'])) {
        $id_cliente = (int)$clienteExistente[0]['id_cliente'];
    } else {
        echo "<script>alert('Error registrando el cliente nuevo: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }
}
    }
}

if ((int)$id_cliente <= 0) {
    echo "<script>alert('No fue posible obtener el ID del cliente. Revise que clientes.id_cliente sea AUTO_INCREMENT y que no exista un registro con id_cliente=0.'); window.history.back();</script>";
    exit;
}

$tipo_servicio = $_POST['tipo_servicio_reserva'];
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
$cantidad_vehiculos = $_POST['cantidad_vehiculos'];
$cantidad_pasajeros = $_POST['cantidad_pasajeros'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$id_empresa = $_POST['id_empresa'];
$origen_id  = isset($_POST['origen']) ? (int) $_POST['origen'] : 0;
$destino_id = isset($_POST['destino']) ? (int) $_POST['destino'] : 0;

if ($origen_id <= 0 || $destino_id <= 0) {
    echo "<script>alert('Seleccione ORIGEN y DESTINO.'); window.history.back();</script>";
    exit;
}

// Convertir a nombres
$origen = '';
$destino = '';

$infoOrigen = $ciudadModelo->listarCiudadPorId($origen_id);
if (count($infoOrigen) > 0 && isset($infoOrigen[0]['ciudad'])) {
    $origen = mb_strtoupper(trim($infoOrigen[0]['ciudad']));
}

$infoDestino = $ciudadModelo->listarCiudadPorId($destino_id);
if (count($infoDestino) > 0 && isset($infoDestino[0]['ciudad'])) {
    $destino = mb_strtoupper(trim($infoDestino[0]['ciudad']));
}

if ($origen === '' || $destino === '') {
    echo "<script>alert('No fue posible obtener el nombre de ORIGEN/DESTINO.'); window.history.back();</script>";
    exit;
}

$fecha_inicial = $_POST['fecha_inicio'];
$fecha_final = $_POST['fecha_fin'];
$fecha_creacion = date('Y-m-d');
$hora_creacion = date('H:i:s');
$valor_servicio = $_POST['valor_servicio'];
$detalle_servicio = isset($_POST['detalle_servicio']) ? mb_strtoupper(trim($_POST['detalle_servicio'])) : '';
$id_responsable = $_SESSION['id_usuario'];
$estado = 'P';
if ($id_empresa == '' || $id_tipo_vehiculo == '' || $tipo_servicio == '') {
    echo "<script>alert('Complete la información obligatoria del servicio ocasional.'); window.history.back();</script>";
    exit;
}

$id_servicio_ocasional = $servicioOcasional->registrarServicioOcasional(
    $id_cliente,
    $id_empresa,
    $id_tipo_vehiculo,
    $tipo_servicio,
    $origen,
    $destino,
    $cantidad_vehiculos,
    $cantidad_pasajeros,
    $fecha_inicial,
    $fecha_final,
    $hora_inicio,
    $hora_fin,
    $valor_servicio,
    $id_responsable,
    $fecha_creacion,
    $hora_creacion,
    $estado,
    $detalle_servicio
);

if (!$id_servicio_ocasional) {
    echo "<script>alert('No fue posible registrar la reserva ocasional'); window.history.back();</script>";
    exit;
}

$camposDocs = array('doc_rut','doc_camara','doc_cedula_rl','doc_aceptacion','doc_contrato','doc_primer_abono','doc_segundo_abono','doc_prefactura');
foreach ($camposDocs as $campo) {
    $nombreDocumento = subirDocumentoPdf($campo, $id_servicio_ocasional);
    if ($nombreDocumento != '') {
        $servicioOcasional->registrarDocumentoServicioOcasional($id_servicio_ocasional, $campo, $nombreDocumento);
    }
}

// Generar documentos base por reserva: FUEC y Contrato
$listarCliente = $cliente->listarClientePorId($id_cliente);
$nombreCliente = (count($listarCliente) > 0 && isset($listarCliente[0]['razon_social'])) ? $listarCliente[0]['razon_social'] : 'CLIENTE';

$fuecNombre = 'SO_' . $id_servicio_ocasional . '_fuec_generado_' . date('YmdHis') . '.html';
$contratoNombre = 'SO_' . $id_servicio_ocasional . '_contrato_generado_' . date('YmdHis') . '.html';

$fuecContenido = "<h2>FUEC - SERVICIO OCASIONAL</h2>\n<p><strong>Reserva:</strong> " . $id_servicio_ocasional . "</p>\n<p><strong>Cliente:</strong> " . htmlspecialchars($nombreCliente) . "</p>\n<p><strong>Tipo servicio:</strong> " . htmlspecialchars($tipo_servicio) . "</p>\n<p><strong>Origen:</strong> " . htmlspecialchars($origen) . "</p>\n<p><strong>Destino:</strong> " . htmlspecialchars($destino) . "</p>\n<p><strong>Fechas:</strong> " . htmlspecialchars($fecha_inicial) . " a " . htmlspecialchars($fecha_final) . "</p>\n<p><strong>Horas:</strong> " . htmlspecialchars($hora_inicio) . " - " . htmlspecialchars($hora_fin) . "</p>\n<p><strong>Detalle:</strong> " . nl2br(htmlspecialchars($detalle_servicio)) . "</p>";

$contratoContenido = "<h2>CONTRATO - SERVICIO OCASIONAL</h2>\n<p><strong>Reserva:</strong> " . $id_servicio_ocasional . "</p>\n<p><strong>Cliente:</strong> " . htmlspecialchars($nombreCliente) . "</p>\n<p><strong>Empresa contratante:</strong> " . htmlspecialchars($id_empresa) . "</p>\n<p><strong>Valor servicio:</strong> $" . number_format((float) $valor_servicio, 2, ',', '.') . "</p>\n<p><strong>Tipo de vehículo:</strong> " . htmlspecialchars($id_tipo_vehiculo) . "</p>\n<p><strong>Cantidad vehículos:</strong> " . htmlspecialchars($cantidad_vehiculos) . "</p>\n<p><strong>Cantidad pasajeros:</strong> " . htmlspecialchars($cantidad_pasajeros) . "</p>\n<p><strong>Detalle:</strong> " . nl2br(htmlspecialchars($detalle_servicio)) . "</p>";

$fuecDocumento = generarDocumentoHtml($fuecNombre, 'FUEC Servicio Ocasional', $fuecContenido);
$contratoDocumento = generarDocumentoHtml($contratoNombre, 'Contrato Servicio Ocasional', $contratoContenido);

$servicioOcasional->registrarDocumentoServicioOcasional($id_servicio_ocasional, 'doc_fuec_generado', $fuecDocumento);
$servicioOcasional->registrarDocumentoServicioOcasional($id_servicio_ocasional, 'doc_contrato_generado', $contratoDocumento);

echo "<script>alert('Reserva ocasional registrada correctamente'); window.location.href='../Vista/serviciosOcasionales.php';</script>";
