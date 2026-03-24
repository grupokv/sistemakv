<?php
$hoy = date('Ymd_His');
$filename = $hoy . '_reporte_reservas_servicios_ocasionales.xls';

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);
header('Pragma: no-cache');
header('Expires: 0');

include('../Controlador/Sesion/autenticar.php');
require_once('../Modelo/ServicioOcasional.php');

$servicioOcasional = new ServicioOcasional();

$id_responsable = isset($_POST['id_responsable']) && $_POST['id_responsable'] !== '' ? $_POST['id_responsable'] : '%%';
$id_cliente = isset($_POST['id_cliente']) && $_POST['id_cliente'] !== '' ? $_POST['id_cliente'] : '%%';
$fecha_inicial = isset($_POST['fecha_inicial']) && $_POST['fecha_inicial'] !== '' ? $_POST['fecha_inicial'] : '0000-00-00';
$fecha_final = isset($_POST['fecha_final']) && $_POST['fecha_final'] !== '' ? $_POST['fecha_final'] : '9999-12-31';

$reservas = $servicioOcasional->filtrarReservasReporte($id_responsable, $id_cliente, $fecha_inicial, $fecha_final);

function textoSeguroExcel($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function valorReservaExcel($reserva, $claves, $default = '')
{
    foreach ($claves as $clave) {
        if (isset($reserva[$clave]) && $reserva[$clave] !== '' && $reserva[$clave] !== null) {
            return $reserva[$clave];
        }
    }

    return $default;
}

function linkDocExcel($archivo)
{
    if (empty($archivo)) {
        return '';
    }

    if (strpos($archivo, 'http://') === 0 || strpos($archivo, 'https://') === 0) {
        return $archivo;
    }

    return '../Documentos/ServiciosOcasionales/' . $archivo;
}

function linksFuecDocumentalExcel($jsonFuec)
{
    if (empty($jsonFuec)) {
        return '';
    }

    $data = json_decode($jsonFuec, true);
    if (!is_array($data)) {
        return '';
    }

    $links = array();

    foreach ($data as $consecutivo => $trayectos) {
        if (!is_array($trayectos)) {
            continue;
        }

        foreach ($trayectos as $tipo => $info) {
            if (!is_array($info) || empty($info['documento_fuec'])) {
                continue;
            }

            $links[] = 'Reserva ' . $consecutivo . ' ' . strtoupper($tipo) . ': ../Documentos/ServiciosOcasionales/' . $info['documento_fuec'];
        }
    }

    return implode(' | ', $links);
}

function linksConvenioDocumentalExcel($jsonConvenio)
{
    if (empty($jsonConvenio)) {
        return '';
    }

    $data = json_decode($jsonConvenio, true);
    if (!is_array($data)) {
        return '';
    }

    $links = array();

    foreach ($data as $consecutivo => $trayectos) {
        if (!is_array($trayectos)) {
            continue;
        }

        foreach ($trayectos as $tipo => $info) {
            if (!is_array($info)) {
                continue;
            }

            $aplica = isset($info['aplica']) ? (int)$info['aplica'] : 0;
            $documento = isset($info['documento_convenio']) ? $info['documento_convenio'] : '';

            if ($aplica === 1) {
                if ($documento !== '') {
                    $links[] = 'Reserva ' . $consecutivo . ' ' . strtoupper($tipo) . ': ../Documentos/ServiciosOcasionales/' . $documento;
                } else {
                    $links[] = 'Reserva ' . $consecutivo . ' ' . strtoupper($tipo) . ': APLICA SIN ARCHIVO';
                }
            }
        }
    }

    return implode(' | ', $links);
}
?>
<table border="1">
    <thead>
    <tr>
        <th colspan="48">REPORTE DE RESERVAS - SERVICIOS OCASIONALES (TOTAL: <?php echo count($reservas); ?>)</th>
    </tr>
    <tr>
        <th>ID reserva</th>
        <th>Contratante</th>
        <th>Cliente</th>
        <th>Tipo servicio</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Tipo vehículo</th>
        <th>Cantidad vehículos</th>
        <th>Cantidad pasajeros</th>
        <th>Placa inicio</th>
        <th>Tipo afiliación inicio</th>
        <th>Conductor inicio</th>
        <th>Placa fin</th>
        <th>Tipo afiliación fin</th>
        <th>Conductor fin</th>
        <th>Valor</th>
        <th>Fecha/Hora inicio</th>
        <th>Fecha/Hora fin</th>
        <th>Responsable creador</th>
        <th>Detalle</th>
        <th>Confirmación contabilidad</th>
        <th>Estado confirmación contabilidad</th>
        <th>Usuario confirmación contabilidad</th>
        <th>Fecha confirmación contabilidad</th>
        <th>Confirmación operaciones</th>
        <th>Estado confirmación operaciones</th>
        <th>Usuario confirmación operaciones</th>
        <th>Fecha confirmación operaciones</th>
        <th>Confirmación documental</th>
        <th>Estado confirmación documental</th>
        <th>Usuario confirmación documental</th>
        <th>Fecha confirmación documental</th>
        <th>Confirmación conductor</th>
        <th>Estado confirmación conductor</th>
        <th>Usuario confirmación conductor</th>
        <th>Fecha confirmación conductor</th>
        <th>RUT</th>
        <th>Cámara de comercio</th>
        <th>Cédula representante legal</th>
        <th>Aceptación del cliente</th>
        <th>Contrato del servicio</th>
        <th>Soporte primer abono 50%</th>
        <th>Soporte segundo abono 50%</th>
        <th>Proforma</th>
        <th>Recibo caja abono 1</th>
        <th>Recibo caja abono 2</th>
        <th>Factura</th>
        <th>FUEC documental</th>
        <th>Convenio documental</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reservas as $r) { ?>
        <tr>
            <td><?php echo (int) valorReservaExcel($r, ['id_servicio_ocasional'], 0); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['contratante', 'nombre_contratante'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['cliente', 'razon_social'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['tipo_servicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['origen'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['destino'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['nombre_tipo_vehiculo', 'id_tipo_vehiculo'], 'N/A')); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['cantidad_vehiculos'], 0)); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['cantidad_pasajeros'], 0)); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['placa_inicio', 'placas_inicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['tipo_afiliacion_inicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['conductor_inicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['placa_fin', 'placas_fin'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['tipo_afiliacion_fin'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['conductor_fin'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['valor_servicio', 'valor'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_inicio', 'fecha_hora_inicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_fin', 'fecha_hora_fin'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['responsable', 'responsable_creador'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['detalle', 'detalle_servicio'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['confirmacion_contabilidad'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['estado_confirmacion_contabilidad'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['usuario_confirmacion_contabilidad'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_confirmacion_contabilidad'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['confirmacion_operaciones'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['estado_confirmacion_operaciones'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['usuario_confirmacion_operaciones'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_confirmacion_operaciones'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['confirmacion_documental'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['estado_confirmacion_documental'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['usuario_confirmacion_documental'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_confirmacion_documental'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['confirmacion_conductor'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['estado_confirmacion_conductor'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['usuario_confirmacion_conductor'])); ?></td>
            <td><?php echo textoSeguroExcel(valorReservaExcel($r, ['fecha_confirmacion_conductor'])); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_rut']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_camara']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_cedula_rl']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_aceptacion']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_contrato']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_primer_abono']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_segundo_abono']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_proforma', 'doc_prefactura', 'doc_orden_compra']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_recibo_caja_abono_1']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_recibo_caja_abono_2']))); ?></td>
            <td><?php echo textoSeguroExcel(linkDocExcel(valorReservaExcel($r, ['doc_factura']))); ?></td>
            <td><?php
            $fuecDocumental = linksFuecDocumentalExcel(valorReservaExcel($r, ['doc_fuec_documental']));
            echo textoSeguroExcel($fuecDocumental !== '' ? $fuecDocumental : valorReservaExcel($r, ['links_fuec', 'fuec_codigos']));
            ?></td>
            <td><?php echo textoSeguroExcel(linksConvenioDocumentalExcel(valorReservaExcel($r, ['doc_convenio_documental']))); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>