<?php
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Conductor.php';
require_once '../Modelo/ServicioOcasional.php';

$conductorModel = new Conductor();
$servicioOcasional = new ServicioOcasional();

function h($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function valor($arr, $key, $default = '')
{
    return isset($arr[$key]) && $arr[$key] !== '' && $arr[$key] !== null ? $arr[$key] : $default;
}

function estadoOperaciones($confirmacionOperaciones)
{
    return ((int)$confirmacionOperaciones === 1) ? 'CONFIRMADO' : 'POR CONFIRMAR';
}

function claseEstado($estado)
{
    return $estado === 'CONFIRMADO' ? 'badge-success' : 'badge-secondary';
}

function estadoConductor($confirmacionConductor)
{
    return ((int)$confirmacionConductor === 1) ? 'CONFIRMADO' : 'SIN CONFIRMAR';
}

function claseConductor($estado)
{
    return $estado === 'CONFIRMADO' ? 'badge-success' : 'badge-warning';
}

function construirFuecConductor($detalleOperacion, $documentosFuec, $documentosConvenio, $idConductor)
{
    $fuecConductor = array();

    foreach ($detalleOperacion as $fila) {
        $consecutivo = (int)valor($fila, 'consecutivo', 0);

        if ((int)valor($fila, 'id_conductor_inicio', 0) === $idConductor) {
            $fuecConductor[] = array(
                'trayecto' => 'INICIO',
                'placa' => valor($fila, 'placa_inicio', 'N/A'),
                'documento' => isset($documentosFuec[$consecutivo]['INICIO']['documento_fuec'])
                    ? $documentosFuec[$consecutivo]['INICIO']['documento_fuec'] : '',
                'convenio_aplica' => isset($documentosConvenio[$consecutivo]['INICIO']['aplica'])
                    ? (int)$documentosConvenio[$consecutivo]['INICIO']['aplica'] : 0,
                'convenio_documento' => isset($documentosConvenio[$consecutivo]['INICIO']['documento_convenio'])
                    ? $documentosConvenio[$consecutivo]['INICIO']['documento_convenio'] : ''
            );
        }

        if ((int)valor($fila, 'id_conductor_fin', 0) === $idConductor) {
            $fuecConductor[] = array(
                'trayecto' => 'FIN',
                'placa' => valor($fila, 'placa_fin', 'N/A'),
                'documento' => isset($documentosFuec[$consecutivo]['FIN']['documento_fuec'])
                    ? $documentosFuec[$consecutivo]['FIN']['documento_fuec'] : '',
                'convenio_aplica' => isset($documentosConvenio[$consecutivo]['FIN']['aplica'])
                    ? (int)$documentosConvenio[$consecutivo]['FIN']['aplica'] : 0,
                'convenio_documento' => isset($documentosConvenio[$consecutivo]['FIN']['documento_convenio'])
                    ? $documentosConvenio[$consecutivo]['FIN']['documento_convenio'] : ''
            );
        }
    }

    return $fuecConductor;
}

function construirPlacasConductor($detalleOperacion, $idConductor)
{
    $placas = array();

    foreach ($detalleOperacion as $fila) {
        if ((int)valor($fila, 'id_conductor_inicio', 0) === (int)$idConductor) {
            $placaInicio = trim((string)valor($fila, 'placa_inicio', ''));
            if ($placaInicio !== '') {
                $placas[] = $placaInicio;
            }
        }

        if ((int)valor($fila, 'id_conductor_fin', 0) === (int)$idConductor) {
            $placaFin = trim((string)valor($fila, 'placa_fin', ''));
            if ($placaFin !== '') {
                $placas[] = $placaFin;
            }
        }
    }

    $placas = array_values(array_unique($placas));

    return count($placas) > 0 ? implode(' / ', $placas) : 'N/A';
}
$conductorSesion = $conductorModel->buscarConductorPorDocumento($_SESSION['sesion']);
$idConductor = isset($conductorSesion[0]['id_conductor']) ? (int)$conductorSesion[0]['id_conductor'] : 0;

$reservasAsignadas = $idConductor > 0
    ? $servicioOcasional->listarReservasAsignadasConductor($idConductor, '0000-00-00', '9999-12-31')
    : array();

$reservasVista = array();
foreach ($reservasAsignadas as $reserva) {
    $idReserva = (int)valor($reserva, 'id_servicio_ocasional', 0);
    if ($idReserva <= 0) {
        continue;
    }

    $estadoOps = estadoOperaciones((int)valor($reserva, 'confirmacion_operaciones', 0));
    $estadoCond = estadoConductor((int)valor($reserva, 'confirmacion_conductor', 0));

    $detalleOperacion = $servicioOcasional->listarDetalleOperacionConNombres($idReserva);
    $documentosFuec = $servicioOcasional->listarDocumentosFuecServicioOcasional($idReserva);
    $documentosConvenio = $servicioOcasional->listarDocumentosConvenioServicioOcasional($idReserva);

    $reserva['estado_operaciones_label'] = $estadoOps;
    $reserva['estado_operaciones_class'] = claseEstado($estadoOps);
    $reserva['estado_conductor_label'] = $estadoCond;
    $reserva['estado_conductor_class'] = claseConductor($estadoCond);
    $reserva['placas_conductor'] = construirPlacasConductor($detalleOperacion, $idConductor);
   $reserva['fuec_conductor'] = construirFuecConductor(
    $detalleOperacion,
    $documentosFuec,
    $documentosConvenio,
    $idConductor
);

    $reservasVista[] = $reserva;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Servicios Ocasionales Asignados Conductor</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>
        .contenedor-tabla { padding-bottom: 8px; }
        .contenedor-tabla .dataTables_wrapper > .row:nth-child(2) {
            overflow-x: auto;
            margin-left: 0;
            margin-right: 0;
        }
        .tabla-reservas {
            width: 100%;
            min-width: 2200px;
            font-size: 12px;
        }
        .tabla-reservas .col-direccion {
    min-width: 220px;
    white-space: normal;
    word-break: break-word;
}
        .tabla-reservas th {
            background: #1b2d3b;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            padding: 8px 10px !important;
        }
        .tabla-reservas td {
            vertical-align: middle;
            padding: 7px 8px !important;
            white-space: nowrap;
        }
        .tabla-reservas .col-detalle {
            min-width: 240px;
            white-space: normal;
            word-break: break-word;
        }
    </style>
</head>
<body>
<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>
<section class="home_content">
    <div aria-label="breadcrumb" class="mt-1">
        <ol class="breadcrumb" style="background:#fff;">
            <li class="breadcrumb-item"><a href="inicioConductores.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Servicios Ocasionales Asignados Conductor</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-tasks mr-2" style="font-size:2rem;"></i><b style="font-size:1.2rem;">SERVICIOS OCASIONALES ASIGNADOS</b></strong>
    </div>

    <div class="card p-3 mt-2" style="border:0;">
        <?php if ($idConductor <= 0) { ?>
            <div class="alert alert-warning mb-0">No se encontró un conductor asociado a tu usuario.</div>
        <?php } else { ?>
            <div class="contenedor-tabla">
                <table id="dataT" class="table table-bordered table-sm tabla-reservas">
                    <thead>
                    <tr>
                        <th>ID RESERVA</th>
                        <th>CONTRATANTE</th>
                        <th>CLIENTE</th>
                        <th>PLACA</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>DIRECCIÓN ORIGEN</th>
                        <th>DIRECCIÓN DESTINO</th>
                        <th>FECHA Y HORA INICIO</th>
                        <th>FECHA Y HORA FIN</th>
                        <th>DETALLE DEL SERVICIO</th>
                        <th>ESTADO</th>
                        <th>CONFIRMACIÓN CONDUCTOR</th>
                        <th>OPCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($reservasVista) < 1) { ?>
                        <tr><td colspan="14" class="text-center text-muted">No tienes servicios ocasionales asignados.</td></tr>
                    <?php } else { ?>
                        <?php foreach ($reservasVista as $reserva) { ?>
                            <tr>
                                <td class="text-center"><?php echo (int)valor($reserva, 'id_servicio_ocasional', 0); ?></td>
                                <td><?php echo h(valor($reserva, 'contratante', 'N/A')); ?></td>
                                <td><?php echo h(valor($reserva, 'cliente', 'N/A')); ?></td>
                                <td><?php echo h(valor($reserva, 'placas_conductor', 'N/A')); ?></td>
                                <td><?php echo h(valor($reserva, 'origen', 'N/A')); ?></td>
                                <td><?php echo h(valor($reserva, 'destino', 'N/A')); ?></td>
                                <td class="col-direccion"><?php echo nl2br(h(str_replace(' / ', "\n", valor($reserva, 'direccion_origen', 'N/A')))); ?></td>
<td class="col-direccion"><?php echo nl2br(h(str_replace(' / ', "\n", valor($reserva, 'direccion_destino', 'N/A')))); ?></td>
                                <td class="text-center"><?php echo h(valor($reserva, 'fecha_inicio')) . ' ' . h(valor($reserva, 'hora_inicio')); ?></td>
                                <td class="text-center"><?php echo h(valor($reserva, 'fecha_fin')) . ' ' . h(valor($reserva, 'hora_fin')); ?></td>
                                <td class="col-detalle"><?php echo nl2br(h(valor($reserva, 'detalle_servicio'))); ?></td>
                                <td class="text-center"><span class="badge <?php echo h(valor($reserva, 'estado_operaciones_class', 'badge-secondary')); ?>"><?php echo h(valor($reserva, 'estado_operaciones_label', 'POR CONFIRMAR')); ?></span></td>
                                <td class="text-center"><span class="badge <?php echo h(valor($reserva, 'estado_conductor_class', 'badge-warning')); ?>"><?php echo h(valor($reserva, 'estado_conductor_label', 'SIN CONFIRMAR')); ?></span></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" title="Ver FUEC" data-toggle="modal" data-target="#modalFuec" onclick='abrirModalFuec(<?php echo json_encode(valor($reserva, 'fuec_conductor', array()), JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" title="Confirmar recibido" data-toggle="modal" data-target="#modalConfirmacion" onclick="setConfirmacion(<?php echo (int)valor($reserva, 'id_servicio_ocasional', 0); ?>, '<?php echo h(valor($reserva, 'estado_operaciones_label', 'POR CONFIRMAR')); ?>')">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</section>

<div class="modal fade" id="modalFuec" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#1b2d3b;color:#fff;">
                <h5 class="modal-title">FUEC asignados al conductor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead>
                        <tr>
                            <th>Trayecto</th>
                            <th>Placa</th>
                            <th>Documento FUEC</th>
                             <th>Convenio</th>
                        </tr>
                        </thead>
                        <tbody id="tablaFuecBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="../Controlador/confirmarRecibidoServicioOcasionalConductor.php">
                <div class="modal-header" style="background:#1b2d3b;color:#fff;">
                    <h5 class="modal-title">Confirmar recibido de reserva y FUEC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_servicio_ocasional" id="id_servicio_confirmar" value="0">
                    <p class="mb-1">¿Quieres confirmar el recibido de la reserva y el FUEC?</p>
                    <p class="text-muted mb-0" id="estado_operaciones_texto"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="decision" value="NO_CONFIRMAR" class="btn btn-outline-danger">No confirmar</button>
                    <button type="submit" name="decision" value="CONFIRMAR" class="btn btn-outline-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("Template/scripts.php"); ?>
<script>
function abrirModalFuec(filas) {
    var html = '';

    if (!Array.isArray(filas) || filas.length < 1) {
        html = '<tr><td colspan="4" class="text-center text-muted">No hay FUEC cargados para este conductor.</td></tr>';
    } else {
        filas.forEach(function(fila) {
            var linkFuec = fila.documento
                ? '<a href="../Documentos/ServiciosOcasionales/' + encodeURIComponent(fila.documento) + '" target="_blank">Visualizar FUEC</a>'
                : '<span class="text-muted">No cargado</span>';

            var linkConvenio = '<span class="text-muted">No aplica</span>';

            if (parseInt(fila.convenio_aplica || 0, 10) === 1) {
                if (fila.convenio_documento) {
                    linkConvenio = '<a href="../Documentos/ServiciosOcasionales/' + encodeURIComponent(fila.convenio_documento) + '" target="_blank">Visualizar convenio</a>';
                } else {
                    linkConvenio = '<span class="text-muted">Aplica, sin archivo</span>';
                }
            }

            html += '<tr>' +
                '<td class="text-center">' + (fila.trayecto || 'N/A') + '</td>' +
                '<td>' + (fila.placa || 'N/A') + '</td>' +
                '<td>' + linkFuec + '</td>' +
                '<td>' + linkConvenio + '</td>' +
            '</tr>';
        });
    }

    $('#tablaFuecBody').html(html);
}

function setConfirmacion(idReserva, estadoOperaciones) {
    $('#id_servicio_confirmar').val(idReserva);
    $('#estado_operaciones_texto').text('Estado de operaciones: ' + estadoOperaciones);
}
</script>
</body>
</html>