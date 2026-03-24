<?php
include("Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");

$id_servicio_ocasional = isset($_POST['id_servicio_ocasional']) ? (int)$_POST['id_servicio_ocasional'] : 0;
$area = isset($_POST['area']) ? $_POST['area'] : '';
$accion = isset($_POST['accion']) ? $_POST['accion'] : 'confirmar';

if ($id_servicio_ocasional <= 0 || $area == '') {
    echo "<script>alert('Datos incompletos');window.history.back();</script>";
    exit;
}

$servicio = new ServicioOcasional();
$estado = strtoupper($accion);

if ($area === 'contabilidad') {
    $confirmarPrimer = isset($_POST['confirmar_primer_abono']) ? 1 : 0;
    $confirmarOrden = isset($_POST['confirmar_orden_compra']) ? 1 : 0;
    $segundoExiste = isset($_POST['segundo_abono_existe']) ? (int)$_POST['segundo_abono_existe'] : 0;
    $confirmarSegundo = isset($_POST['confirmar_segundo_abono']) ? 1 : 0;

    if ($accion === 'confirmar') {
        if ($confirmarPrimer !== 1 || $confirmarOrden !== 1 || ($segundoExiste === 1 && $confirmarSegundo !== 1)) {
            echo "<script>alert('Para confirmar contabilidad debe validar primer abono, orden de compra y segundo abono si aplica.');window.history.back();</script>";
            exit;
        }
    }

    $docs = array(
        'primer_abono' => $confirmarPrimer,
        'segundo_abono' => $confirmarSegundo,
        'orden_compra' => $confirmarOrden,
        'segundo_abono_existe' => $segundoExiste
    );

    $mapaArchivosContabilidad = array(
        'doc_recibo_caja_abono_1' => 'recibo_caja_abono_1',
        'doc_recibo_caja_abono_2' => 'recibo_caja_abono_2',
        'doc_factura' => 'factura'
    );

    foreach ($mapaArchivosContabilidad as $campoFormulario => $prefijoNombre) {
        $tieneArchivo = isset($_FILES[$campoFormulario]) &&
            isset($_FILES[$campoFormulario]['name']) &&
            $_FILES[$campoFormulario]['name'] !== '';

        if (!$tieneArchivo) {
            continue;
        }

        if ((int)$_FILES[$campoFormulario]['error'] !== 0) {
            echo "<script>alert('No fue posible cargar el archivo " . $prefijoNombre . ".');window.history.back();</script>";
            exit;
        }

        $tipoArchivo = isset($_FILES[$campoFormulario]['type']) ? $_FILES[$campoFormulario]['type'] : '';
        $extension = strtolower(pathinfo($_FILES[$campoFormulario]['name'], PATHINFO_EXTENSION));
        if ($extension !== 'pdf' && $tipoArchivo !== 'application/pdf') {
            echo "<script>alert('Solo se permiten archivos PDF para los soportes de contabilidad.');window.history.back();</script>";
            exit;
        }

        $nombre = $prefijoNombre . '_so_' . $id_servicio_ocasional . '_' . date('YmdHis') . '_' . mt_rand(1000, 9999) . '.pdf';
        $rutaDestino = '../Documentos/ServiciosOcasionales/' . $nombre;

        if (!move_uploaded_file($_FILES[$campoFormulario]['tmp_name'], $rutaDestino)) {
            echo "<script>alert('No fue posible guardar el archivo " . $prefijoNombre . ".');window.history.back();</script>";
            exit;
        }

        $servicio->registrarDocumentoServicioOcasional($id_servicio_ocasional, $campoFormulario, $nombre, (int)$_SESSION['id_usuario']);
    }

    $servicio->guardarConfirmacionArea($id_servicio_ocasional, 'contabilidad', $_SESSION['id_usuario'], $estado, $docs);
}

if ($area === 'operaciones') {
    $cantidad = isset($_POST['cantidad_filas']) ? (int)$_POST['cantidad_filas'] : 0;
    $detalles = array();
    for ($i = 1; $i <= $cantidad; $i++) {
        $detalles[] = array(
            'consecutivo' => $i,
            'id_vehiculo_inicio' => isset($_POST['id_vehiculo_inicio'][$i]) ? (int)$_POST['id_vehiculo_inicio'][$i] : null,
            'id_vehiculo_fin' => isset($_POST['id_vehiculo_fin'][$i]) ? (int)$_POST['id_vehiculo_fin'][$i] : null,
            'id_conductor_inicio' => isset($_POST['id_conductor_inicio'][$i]) ? (int)$_POST['id_conductor_inicio'][$i] : null,
            'id_conductor_fin' => isset($_POST['id_conductor_fin'][$i]) ? (int)$_POST['id_conductor_fin'][$i] : null,
            'direccion_origen' => isset($_POST['direccion_origen'][$i]) ? trim($_POST['direccion_origen'][$i]) : '',
            'direccion_destino' => isset($_POST['direccion_destino'][$i]) ? trim($_POST['direccion_destino'][$i]) : '',
            'tipo_recorrido' => isset($_POST['tipo_recorrido'][$i]) ? trim($_POST['tipo_recorrido'][$i]) : ''
        );
    }

    $servicio->guardarDetalleOperacion($id_servicio_ocasional, $detalles, (int)$_SESSION['id_usuario']);
    if ($accion === 'confirmar') {
        $servicio->guardarConfirmacionArea($id_servicio_ocasional, 'operaciones', $_SESSION['id_usuario'], $estado);
    }
}

if ($area === 'documental') {
    $rutaBaseDocumentos = '../Documentos/ServiciosOcasionales/';
    if (!is_dir($rutaBaseDocumentos)) {
        @mkdir($rutaBaseDocumentos, 0777, true);
    }

    // Persistencia de selección y/o carga de convenio por cada trayecto.
    $convenioAplica = isset($_POST['convenio_aplica']) && is_array($_POST['convenio_aplica']) ? $_POST['convenio_aplica'] : array();
    $convenioExistente = isset($_POST['documento_convenio_existente']) && is_array($_POST['documento_convenio_existente'])
        ? $_POST['documento_convenio_existente']
        : array();

    foreach ($convenioAplica as $key => $aplicaValor) {
        $partes = explode('|', $key);
        $consecutivo = isset($partes[0]) ? (int)$partes[0] : 0;
        $trayecto = isset($partes[1]) ? strtoupper(trim($partes[1])) : '';

        if ($consecutivo <= 0 || ($trayecto !== 'INICIO' && $trayecto !== 'FIN')) {
            continue;
        }

        $aplica = ((int)$aplicaValor === 1) ? 1 : 0;
        $docConvenio = isset($convenioExistente[$key]) ? trim((string)$convenioExistente[$key]) : '';
        $subioNuevoConvenio = false;

        $tieneArchivoConvenio = isset($_FILES['doc_convenio']) &&
            isset($_FILES['doc_convenio']['name']) &&
            isset($_FILES['doc_convenio']['name'][$key]) &&
            $_FILES['doc_convenio']['name'][$key] !== '';

        if ($tieneArchivoConvenio) {
            if ((int)$_FILES['doc_convenio']['error'][$key] !== 0) {
                echo "<script>alert('No fue posible cargar uno de los convenios de colaboración.');window.history.back();</script>";
                exit;
            }

            $tipoArchivoConvenio = isset($_FILES['doc_convenio']['type'][$key]) ? $_FILES['doc_convenio']['type'][$key] : '';
            $extensionConvenio = strtolower(pathinfo($_FILES['doc_convenio']['name'][$key], PATHINFO_EXTENSION));
            if ($extensionConvenio !== 'pdf' && $tipoArchivoConvenio !== 'application/pdf') {
                echo "<script>alert('Solo se permiten archivos PDF para convenio de colaboración.');window.history.back();</script>";
                exit;
            }

            $docConvenio = 'convenio_so_' . $id_servicio_ocasional . '_' . $consecutivo . '_' . strtolower($trayecto) . '_' . date('YmdHis') . '_' . mt_rand(1000, 9999) . '.pdf';
            $rutaDestinoConvenio = $rutaBaseDocumentos . $docConvenio;

            if (!move_uploaded_file($_FILES['doc_convenio']['tmp_name'][$key], $rutaDestinoConvenio)) {
                echo "<script>alert('No fue posible guardar uno de los convenios de colaboración.');window.history.back();</script>";
                exit;
            }

            $subioNuevoConvenio = true;
        }

        // Si la opción es NO aplica, limpiar cualquier documento anterior en el mapa.
        if ($aplica !== 1) {
            $docConvenio = '';
        }

        // Guardar siempre para mantener persistencia de selección al reingresar al tab FUEC.
        // Notificar solo cuando realmente se carga un nuevo archivo de convenio.
        $idUsuarioNotificacion = $subioNuevoConvenio ? (int)$_SESSION['id_usuario'] : 0;
        $servicio->guardarDocumentoConvenioServicioOcasional(
            $id_servicio_ocasional,
            $consecutivo,
            $trayecto,
            $aplica,
            $docConvenio,
            $idUsuarioNotificacion
        );
    }

    if ($accion === 'confirmar') {
        $cantidadDocumentos = isset($_POST['cantidad_documentos']) ? (int)$_POST['cantidad_documentos'] : 0;
        $existentes = isset($_POST['documento_existente']) && is_array($_POST['documento_existente']) ? $_POST['documento_existente'] : array();

        if ($cantidadDocumentos < 1) {
            echo "<script>alert('No hay trayectos configurados para cargar FUEC.');window.history.back();</script>";
            exit;
        }

        $permitidos = array('application/pdf');
        $cargados = 0;

        foreach ($existentes as $key => $nombreActual) {
            $nombreActual = trim($nombreActual);
            $tieneArchivoNuevo = isset($_FILES['doc_fuec']['name'][$key]) && $_FILES['doc_fuec']['name'][$key] !== '';

            if (!$tieneArchivoNuevo && $nombreActual !== '') {
                $cargados++;
                continue;
            }

            if (!$tieneArchivoNuevo) {
                continue;
            }

            if ((int)$_FILES['doc_fuec']['error'][$key] !== 0) {
                echo "<script>alert('No fue posible cargar uno de los documentos FUEC.');window.history.back();</script>";
                exit;
            }

            $tipoArchivo = isset($_FILES['doc_fuec']['type'][$key]) ? $_FILES['doc_fuec']['type'][$key] : '';
            $extension = strtolower(pathinfo($_FILES['doc_fuec']['name'][$key], PATHINFO_EXTENSION));
            if (!in_array($tipoArchivo, $permitidos, true) && $extension !== 'pdf') {
                echo "<script>alert('Solo se permiten archivos PDF para FUEC.');window.history.back();</script>";
                exit;
            }

            $partes = explode('|', $key);
            $consecutivo = isset($partes[0]) ? (int)$partes[0] : 0;
            $trayecto = isset($partes[1]) ? strtoupper(trim($partes[1])) : '';
            if ($consecutivo <= 0 || ($trayecto !== 'INICIO' && $trayecto !== 'FIN')) {
                continue;
            }

            $nombre = 'fuec_so_' . $id_servicio_ocasional . '_' . $consecutivo . '_' . strtolower($trayecto) . '_' . date('YmdHis') . '_' . mt_rand(1000, 9999) . '.pdf';
            $rutaDestino = '../Documentos/ServiciosOcasionales/' . $nombre;

            if (!move_uploaded_file($_FILES['doc_fuec']['tmp_name'][$key], $rutaDestino)) {
                echo "<script>alert('No fue posible guardar uno de los documentos FUEC.');window.history.back();</script>";
                exit;
            }

            $servicio->guardarDocumentoFuecServicioOcasional($id_servicio_ocasional, $consecutivo, $trayecto, $nombre, $_SESSION['id_usuario']);
            $cargados++;
        }

        if ($cargados < $cantidadDocumentos) {
            echo "<script>alert('Debe cargar todos los documentos FUEC requeridos antes de confirmar.');window.history.back();</script>";
            exit;
        }
    }

    if ($accion === 'fuec_incorrecto') {
        $servicio->guardarConfirmacionArea($id_servicio_ocasional, 'documental', $_SESSION['id_usuario'], 'FUEC_INCORRECTO');
    } else {
        $servicio->guardarConfirmacionArea($id_servicio_ocasional, 'documental', $_SESSION['id_usuario'], $estado);
    }
}

if ($area === 'conductor') {
    $confirmado = 0;
    if ($accion === 'confirmar' || $accion === 'CONFIRMAR' || $accion === 'confirmado' || $accion === 'CONFIRMADO') {
        $confirmado = 1;
    }

    $servicio->guardarConfirmacionConductorRecibido($id_servicio_ocasional, (int)$_SESSION['id_usuario'], $confirmado);
}

$destino = "../Vista/serviciosOcasionalesArea.php?area={$area}&id_servicio_ocasional={$id_servicio_ocasional}";
if (
    ($accion === 'confirmar') ||
    ($area === 'contabilidad' && $accion === 'soporte_pendiente') ||
    ($area === 'operaciones' && $accion === 'guardar')
) {
    $destino = '../Vista/serviciosOcasionales.php';
}

if ($area === 'conductor') {
    $destino = '../Vista/serviciosOcasionalesAsignadosaConductor.php';
}

if (!headers_sent()) {
    header('Location: ' . $destino);
    exit;
}

echo "<script>window.location.href='" . $destino . "';</script>";