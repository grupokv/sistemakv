<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../Modelo/CRMComercial.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'Sesion no valida']);
    exit;
}

$crm = new CRMComercial();
$crm->crearTablaSiNoExiste();

$accion = isset($_REQUEST['accion']) ? $_REQUEST['accion'] : '';
$perfil_id = (int)$_SESSION['id_perfil'];
$responsable_id = (int)$_SESSION['id_usuario'];
$responsable_nombre = trim($_SESSION['nombre'] ?? '');

if ($accion === 'listar') {
    $data = $crm->listar();
    echo json_encode(['ok' => true, 'data' => $data]);
    exit;
}

if ($accion === 'guardar') {
    $payload = [
        'id' => isset($_POST['id']) ? (int)$_POST['id'] : 0,
        'nombre' => trim($_POST['nombre'] ?? ''),
        'empresa' => trim($_POST['empresa'] ?? ''),
        'estado_venta' => trim($_POST['estado_venta'] ?? ''),
        'tipo_cliente' => trim($_POST['tipo_cliente'] ?? ''),
        'status_porcentaje' => max(0, min(100, (int)($_POST['status_porcentaje'] ?? 0))),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'correo' => trim($_POST['correo'] ?? ''),
        'ciudad' => trim($_POST['ciudad'] ?? ''),
        'fecha_seguimiento' => !empty($_POST['fecha_seguimiento']) ? $_POST['fecha_seguimiento'] : null,
        'valor_potencial' => (float)($_POST['valor_potencial'] ?? 0),
        'ultimo_contacto' => !empty($_POST['ultimo_contacto']) ? $_POST['ultimo_contacto'] : null,
        'responsable' => trim($_POST['responsable'] ?? ''),
        'observaciones' => trim($_POST['observaciones'] ?? ''),
        'responsable_id' => $responsable_id,
        'perfil_id' => $perfil_id,
        'actualizado_por_id' => $responsable_id,
        'actualizado_por' => $responsable_nombre
    ];

    if ($payload['nombre'] === '' || $payload['empresa'] === '' || $payload['estado_venta'] === '' || $payload['tipo_cliente'] === '') {
        echo json_encode(['ok' => false, 'mensaje' => 'Faltan campos obligatorios']);
        exit;
    }

    $id = $crm->guardar($payload);
    echo json_encode(['ok' => (bool)$id, 'id' => $id]);
    exit;
}

if ($accion === 'cambiar_estado') {
    $id = (int)($_POST['id'] ?? 0);
    $ok = $crm->cambiarEstado($id, $responsable_id, $responsable_nombre);
    echo json_encode(['ok' => $ok]);
    exit;
}

echo json_encode(['ok' => false, 'mensaje' => 'Accion no valida']);
