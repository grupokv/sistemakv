<?php 
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");
require_once("../Modelo/Usuario.php");

$id_servicio_ocasional = isset($_GET['id_servicio_ocasional']) ? (int)$_GET['id_servicio_ocasional'] : 0;

$servicioOcasional = new ServicioOcasional();
$usuario = new Usuario();

$detalleServicio = $servicioOcasional->listarServicioPorId($id_servicio_ocasional);
$detalleServicio = isset($detalleServicio[0]) ? $detalleServicio[0] : null;
$documentosSoporte = $servicioOcasional->listarDocumentosServicioOcasional($id_servicio_ocasional);
$confirmaciones = $servicioOcasional->obtenerConfirmaciones($id_servicio_ocasional);
$detalleOperacion = $servicioOcasional->listarDetalleOperacionConNombres($id_servicio_ocasional);
$documentosFuec = $servicioOcasional->listarDocumentosFuecServicioOcasional($id_servicio_ocasional);
$documentosConvenio = $servicioOcasional->listarDocumentosConvenioServicioOcasional($id_servicio_ocasional);

$responsable = array();
if ($detalleServicio) {
    $responsable = $usuario->listarUsuarioPorId($detalleServicio['id_responsable']);
}

function nombreUsuario($usuarioModel, $idUsuario)
{
    if (empty($idUsuario)) {
        return 'Sin confirmar';
    }
    $u = $usuarioModel->listarUsuarioPorId($idUsuario);
    return isset($u[0]['nombre']) ? utf8_encode($u[0]['nombre']) : 'Sin confirmar';
}

function valorCampo($arr, $key, $default = '')
{
    return isset($arr[$key]) ? $arr[$key] : $default;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Consulta Servicio Ocasional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>
        .panel-card{border:1px solid #e5eaf1;border-radius:10px;background:#fff;padding:12px;height:100%;}
        .item-resumen{border:1px solid #eef2f7;border-radius:8px;background:#fbfcfe;padding:8px 10px;margin-bottom:8px;font-size:.88rem;}
        .doc-row{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:8px;border:1px solid #edf0f5;border-radius:8px;margin-bottom:8px;}
        .confirm-table th,.data-table th,.fuec-table th{background:#1b2d3b;color:#fff;text-align:center;}
        .confirm-table td,.data-table td,.fuec-table td{vertical-align:top;}
        .label-cell{font-weight:700;background:#f5f8fc;white-space:nowrap;width:220px;}
        .chip-ok{background:#e8f7ed;color:#1f7a3c;border:1px solid #caecd5;border-radius:18px;padding:2px 10px;font-size:.78rem;}
        .chip-off{background:#fff5f5;color:#a94442;border:1px solid #f1cece;border-radius:18px;padding:2px 10px;font-size:.78rem;}
        .tabla-operativa th,.tabla-operativa td{font-size:.80rem;}
    </style>
</head>
<body>
<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>
<section class="home_content">
 <div aria-label="breadcrumb" class="mt-1">
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="serviciosOcasionales.php">Servicios Ocasionales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Consultar Reserva Ocasional</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-search mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">CONSULTA DE RESERVA OCASIONAL</b></strong>
    </div>

    <div class="card p-3 mt-2" style="border:0;">
        <?php if (!$detalleServicio) { ?>
            <div class="alert alert-danger">No se encontró la reserva solicitada.</div>
        <?php } else { ?>
            <ul class="nav nav-tabs" id="tabsReserva" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabServicio" role="tab">Datos del servicio</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabConfirmaciones" role="tab">Confirmación áreas</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabDocumental" role="tab">Documentación</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabGenerados" role="tab">FUEC</a></li>
            </ul>

            <div class="tab-content border border-top-0 p-3">
                <div class="tab-pane fade show active" id="tabServicio" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm data-table mb-0">
                            <tbody>
                                <tr>
                                    <td class="label-cell">ID reserva</td>
                                    <td><?php echo $detalleServicio['id_servicio_ocasional']; ?></td>
                                    <td class="label-cell">Contratante</td>
                                    <td><?php echo $detalleServicio['nombre_empresa']; ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Cliente</td>
                                    <td><?php echo $detalleServicio['razon_social']; ?></td>
                                    <td class="label-cell">Tipo servicio</td>
                                    <td><?php echo $detalleServicio['tipo_servicio']; ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Origen</td>
                                    <td><?php echo $detalleServicio['origen']; ?></td>
                                    <td class="label-cell">Destino</td>
                                    <td><?php echo $detalleServicio['destino']; ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Tipo vehículo</td>
                                    <td><?php echo $detalleServicio['nombre_tipo_vehiculo']; ?></td>
                                    <td class="label-cell">Cantidad vehículos</td>
                                    <td><?php echo $detalleServicio['cantidad_vehiculos']; ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Cantidad pasajeros</td>
                                    <td><?php echo $detalleServicio['cantidad_pasajeros']; ?></td>
                                    <td class="label-cell">Valor</td>
                                    <td>$<?php echo number_format((float)$detalleServicio['valor_servicio'], 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Fecha/Hora inicio</td>
                                    <td><?php echo $detalleServicio['fecha_inicio']; ?> <?php echo $detalleServicio['hora_inicio']; ?></td>
                                    <td class="label-cell">Fecha/Hora fin</td>
                                    <td><?php echo $detalleServicio['fecha_fin']; ?> <?php echo $detalleServicio['hora_fin']; ?></td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Responsable creador</td>
                                    <td><?php echo isset($responsable[0]['nombre']) ? utf8_encode($responsable[0]['nombre']) : 'No disponible'; ?></td>
                                    <td class="label-cell">Detalle</td>
                                    <td><?php echo nl2br(htmlspecialchars($detalleServicio['detalle_servicio'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm data-table tabla-operativa mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Placa inicio</th>
                                    <th>Tipo afiliación inicio</th>
                                    <th>Conductor inicio</th>
                                    <th>Placa fin</th>
                                    <th>Tipo afiliación fin</th>
                                    <th>Conductor fin</th>
                                    <th>Dirección origen</th>
                                    <th>Dirección destino</th>
                                    <th>Tipo recorrido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($detalleOperacion) < 1) { ?>
                                    <tr><td colspan="10" class="text-center text-muted">Sin asignación operativa.</td></tr>
                                <?php } else { ?>
                                    <?php foreach ($detalleOperacion as $fila) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $fila['consecutivo']; ?></td>
                                            <td><?php echo valorCampo($fila, 'placa_inicio', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'tipo_afiliacion_inicio', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'conductor_inicio', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'placa_fin', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'tipo_afiliacion_fin', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'conductor_fin', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'direccion_origen', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'direccion_destino', 'N/A'); ?></td>
                                            <td><?php echo valorCampo($fila, 'tipo_recorrido', 'N/A'); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="tabConfirmaciones" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center confirm-table">
                            <thead>
                                <tr>
                                    <th>Contabilidad</th>
                                    <th>Operaciones</th>
                                    <th>Documental</th>
                                    <th>Conductor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="item-resumen"><b>Estado:</b> <?php echo valorCampo($confirmaciones, 'estado_contabilidad', 'SIN CONFIRMAR'); ?></div>
                                        <div class="item-resumen"><b>Usuario:</b> <?php echo nombreUsuario($usuario, valorCampo($confirmaciones, 'usuario_contabilidad', 0)); ?></div>
                                        <div class="item-resumen"><b>Fecha:</b> <?php echo valorCampo($confirmaciones, 'fecha_contabilidad', ''); ?></div>
                                    </td>
                                    <td>
                                        <div class="item-resumen"><b>Estado:</b> <?php echo valorCampo($confirmaciones, 'estado_operaciones', 'SIN CONFIRMAR'); ?></div>
                                        <div class="item-resumen"><b>Usuario:</b> <?php echo nombreUsuario($usuario, valorCampo($confirmaciones, 'usuario_operaciones', 0)); ?></div>
                                        <div class="item-resumen"><b>Fecha:</b> <?php echo valorCampo($confirmaciones, 'fecha_operaciones', ''); ?></div>
                                    </td>
                                    <td>
                                        <div class="item-resumen"><b>Estado:</b> <?php echo valorCampo($confirmaciones, 'estado_documental', 'SIN CONFIRMAR'); ?></div>
                                        <div class="item-resumen"><b>Usuario:</b> <?php echo nombreUsuario($usuario, valorCampo($confirmaciones, 'usuario_documental', 0)); ?></div>
                                        <div class="item-resumen"><b>Fecha:</b> <?php echo valorCampo($confirmaciones, 'fecha_documental', ''); ?></div>
                                    </td>
                                    <td>
                                        <div class="item-resumen"><b>Estado:</b> <?php echo valorCampo($confirmaciones, 'estado_conductor', 'SIN CONFIRMAR'); ?></div>
                                        <div class="item-resumen"><b>Usuario:</b> <?php echo nombreUsuario($usuario, valorCampo($confirmaciones, 'usuario_conductor', 0)); ?></div>
                                        <div class="item-resumen"><b>Fecha:</b> <?php echo valorCampo($confirmaciones, 'fecha_conductor', ''); ?></div>
                                        <?php if ((int)valorCampo($confirmaciones, 'confirmacion_conductor', 0) === 1) { ?>
                                            <span class="chip-ok">Recibido confirmado por conductor</span>
                                        <?php } else { ?>
                                            <span class="chip-off">Pendiente confirmación conductor</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="tabDocumental" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm data-table mb-0">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $docsCliente = array(
                                    'doc_rut' => 'RUT',
                                    'doc_camara' => 'Cámara de comercio',
                                    'doc_cedula_rl' => 'Cédula representante legal',
                                    'doc_aceptacion' => 'Aceptación del cliente',
                                    'doc_contrato' => 'Contrato del servicio firmado',
                                    'doc_primer_abono' => 'Soporte primer abono 50%',
                                    'doc_segundo_abono' => 'Soporte segundo abono 50%',
                                    'doc_prefactura' => 'Proforma',
                                    'doc_recibo_caja_abono_1' => 'Recibo de caja abono 1',
                                    'doc_recibo_caja_abono_2' => 'Recibo de caja abono 2',
                                    'doc_factura' => 'Factura'
                                );
                                foreach ($docsCliente as $campo => $label) {
                                    $existe = !empty($documentosSoporte[$campo]);
                                ?>
                                    <tr>
                                        <td><?php echo $label; ?></td>
                                        <td><?php echo $existe ? '<span class="chip-ok">Cargado</span>' : '<span class="chip-off">No cargado</span>'; ?></td>
                                        <td>
                                            <?php if ($existe) { ?>
                                                <a href="../Documentos/ServiciosOcasionales/<?php echo $documentosSoporte[$campo]; ?>" target="_blank">Ver documento</a>
                                            <?php } else { ?>
                                                <span class="text-muted">Sin archivo</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="tabGenerados" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm fuec-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Trayecto</th>
                                    <th>Placa</th>
                                    <th>Conductor</th>
                                    <th>Archivo FUEC</th>
                                    <th>Convenio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $filasFuec = array();
foreach ($detalleOperacion as $fila) {
    $cons = (int)$fila['consecutivo'];

    $docInicio = isset($documentosFuec[$cons]['INICIO']['documento_fuec']) ? $documentosFuec[$cons]['INICIO']['documento_fuec'] : '';
    $convInicioAplica = isset($documentosConvenio[$cons]['INICIO']['aplica']) ? (int)$documentosConvenio[$cons]['INICIO']['aplica'] : 0;
    $convInicioDoc = isset($documentosConvenio[$cons]['INICIO']['documento_convenio']) ? $documentosConvenio[$cons]['INICIO']['documento_convenio'] : '';

    $filasFuec[] = array(
        'consecutivo' => $cons,
        'trayecto' => 'INICIO',
        'placa' => valorCampo($fila, 'placa_inicio', 'N/A'),
        'conductor' => valorCampo($fila, 'conductor_inicio', 'N/A'),
        'documento' => $docInicio,
        'convenio_aplica' => $convInicioAplica,
        'convenio_documento' => $convInicioDoc
    );

    $vehFin = (int)valorCampo($fila, 'id_vehiculo_fin', 0);
    $vehIni = (int)valorCampo($fila, 'id_vehiculo_inicio', 0);

    if ($vehFin > 0 && $vehFin !== $vehIni) {
        $docFin = isset($documentosFuec[$cons]['FIN']['documento_fuec']) ? $documentosFuec[$cons]['FIN']['documento_fuec'] : '';
        $convFinAplica = isset($documentosConvenio[$cons]['FIN']['aplica']) ? (int)$documentosConvenio[$cons]['FIN']['aplica'] : 0;
        $convFinDoc = isset($documentosConvenio[$cons]['FIN']['documento_convenio']) ? $documentosConvenio[$cons]['FIN']['documento_convenio'] : '';

        $filasFuec[] = array(
            'consecutivo' => $cons,
            'trayecto' => 'FIN',
            'placa' => valorCampo($fila, 'placa_fin', 'N/A'),
            'conductor' => valorCampo($fila, 'conductor_fin', 'N/A'),
            'documento' => $docFin,
            'convenio_aplica' => $convFinAplica,
            'convenio_documento' => $convFinDoc
        );
    }
}
                                ?>
                                <?php if (count($filasFuec) < 1) { ?>
                                    <tr><td colspan="6" class="text-center text-muted">No hay asignación operativa para listar FUEC.</td></tr>
                                <?php } else { ?>
                                    <?php foreach ($filasFuec as $row) { ?>
                                        <tr>
    <td class="text-center"><?php echo $row['consecutivo']; ?></td>
    <td class="text-center"><?php echo $row['trayecto']; ?></td>
    <td><?php echo htmlspecialchars($row['placa']); ?></td>
    <td><?php echo htmlspecialchars($row['conductor']); ?></td>
    <td>
        <?php if (!empty($row['documento'])) { ?>
            <a href="../Documentos/ServiciosOcasionales/<?php echo urlencode($row['documento']); ?>" target="_blank">Visualizar FUEC</a>
        <?php } else { ?>
            <span class="text-muted">No cargado</span>
        <?php } ?>
    </td>
    <td>
        <?php if ((int)$row['convenio_aplica'] === 1) { ?>
            <?php if (!empty($row['convenio_documento'])) { ?>
                <a href="../Documentos/ServiciosOcasionales/<?php echo urlencode($row['convenio_documento']); ?>" target="_blank">Visualizar convenio</a>
            <?php } else { ?>
                <span class="text-muted">Aplica, sin archivo</span>
            <?php } ?>
        <?php } else { ?>
            <span class="text-muted">No aplica</span>
        <?php } ?>
    </td>
</tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="serviciosOcasionales.php" class="btn btn-outline-secondary"><i class="fa fa-arrow-left mr-1"></i>Regresar</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include("Template/scripts.php"); ?>
<script>
$('#tabsReserva .nav-link').on('click', function(e){
    e.preventDefault();
    $(this).tab('show');
});
</script>
</body>
</html>