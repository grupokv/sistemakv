<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");
require_once("../Modelo/Usuario.php");

$id_servicio_ocasional = isset($_GET['id_servicio_ocasional']) ? (int)$_GET['id_servicio_ocasional'] : 0;
$area = isset($_GET['area']) ? $_GET['area'] : 'contabilidad';

$titulos = array(
    'contabilidad' => 'Contabilidad',
    'operaciones' => 'Operaciones',
    'documental' => 'Documental'
);
if (!isset($titulos[$area])) {
    $area = 'contabilidad';
}

$servicioOcasional = new ServicioOcasional();
$usuario = new Usuario();
$detalleServicioData = $servicioOcasional->listarServicioPorId($id_servicio_ocasional);
$detalleServicio = isset($detalleServicioData[0]) ? $detalleServicioData[0] : null;
$documentos = $servicioOcasional->listarDocumentosServicioOcasional($id_servicio_ocasional);
$confirmaciones = $servicioOcasional->obtenerConfirmaciones($id_servicio_ocasional);
$vehiculos = $servicioOcasional->listarVehiculosSimple();
$conductores = $servicioOcasional->listarConductoresSimple();
$detalleOperacion = $servicioOcasional->listarDetalleOperacionConNombres($id_servicio_ocasional);
$alertasDocumentacion = $servicioOcasional->listarAlertasDocumentacionOperacion($id_servicio_ocasional);
$documentosFuec = array();
$documentosConvenio = array();
if ($area == 'documental' && $id_servicio_ocasional > 0) {
    $documentosFuec = $servicioOcasional->listarDocumentosFuecServicioOcasional($id_servicio_ocasional);
    $documentosConvenio = $servicioOcasional->listarDocumentosConvenioServicioOcasional($id_servicio_ocasional);
}

$docsContabilidad = array();
if (!empty($confirmaciones['documentos_contabilidad'])) {
    $tmpDocs = json_decode($confirmaciones['documentos_contabilidad'], true);
    if (is_array($tmpDocs)) {
        $docsContabilidad = $tmpDocs;
    }
}

$usuariosConfirmacion = array();
foreach (array('usuario_contabilidad', 'usuario_operaciones', 'usuario_documental', 'usuario_conductor') as $campoUsuario) {
    if (!empty($confirmaciones[$campoUsuario])) {
        $usuariosConfirmacion[$campoUsuario] = $usuario->listarUsuarioPorId($confirmaciones[$campoUsuario]);
    }
}

$filasOperacion = array();
$cantidadFilas = $detalleServicio ? (int)$detalleServicio['cantidad_vehiculos'] : 1;
if (count($detalleOperacion) > 0) {
    foreach ($detalleOperacion as $fila) {
        $filasOperacion[(int)$fila['consecutivo']] = $fila;
    }
}

function valorCampo($arr, $key, $default = '')
{
    return isset($arr[$key]) ? $arr[$key] : $default;
}

function nombreUsuarioConfirmacion($usuariosConfirmacion, $campo)
{
    if (!isset($usuariosConfirmacion[$campo][0]['nombre'])) {
        return 'Sin confirmar';
    }
    return utf8_encode($usuariosConfirmacion[$campo][0]['nombre']);
}

function marcado($docsContabilidad, $key)
{
    return (isset($docsContabilidad[$key]) && (int)$docsContabilidad[$key] === 1) ? 'checked' : '';
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | <?php echo $titulos[$area]; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>
        .panel-card{border:1px solid #e5eaf1;border-radius:10px;background:#fff;padding:12px;height:100%;}
        .item-resumen{border:1px solid #eef2f7;border-radius:8px;background:#fbfcfe;padding:8px 10px;margin-bottom:8px;font-size:.88rem;}
        .section-title{font-size:1rem;font-weight:700;color:#1b2d3b;margin-bottom:10px;}
        .doc-row{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:8px;border:1px solid #edf0f5;border-radius:8px;margin-bottom:8px;}
        .operation-card{border:1px solid #dbe4f0;border-radius:10px;padding:10px 12px;margin-bottom:10px;background:#f9fbff;}
        .operation-card h6{margin:0 0 8px 0;color:#1b2d3b;font-weight:700;}
        .fuec-card{border:1px solid #d8e2ef;border-radius:10px;padding:12px;margin-bottom:12px;background:#fff;}
        .fuec-title{font-weight:700;color:#1b2d3b;margin-bottom:8px;}
        .fuec-table td{padding:4px 8px;border-top:1px solid #eef2f7;font-size:.88rem;}
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
            <li class="breadcrumb-item active" aria-current="page"><?php echo $titulos[$area]; ?></li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-tasks mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;"><?php echo strtoupper($titulos[$area]); ?> - RESERVA</b></strong>
    </div>

    <div class="card p-3 mt-2" style="border:0;">
        <?php if (!$detalleServicio) { ?>
            <div class="alert alert-danger">No se encontró la reserva solicitada.</div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel-card">
                        <div class="section-title">Resumen del servicio</div>
                        <div class="item-resumen"><b>ID reserva:</b> <?php echo $detalleServicio['id_servicio_ocasional']; ?></div>
                        <div class="item-resumen"><b>Contratante:</b> <?php echo $detalleServicio['nombre_empresa']; ?></div>
                        <div class="item-resumen"><b>Cliente:</b> <?php echo $detalleServicio['razon_social']; ?> <?php echo !empty($detalleServicio['nit_cliente']) ? ('- ' . $detalleServicio['nit_cliente']) : ''; ?></div>
                        <div class="item-resumen"><b>Origen:</b> <?php echo $detalleServicio['origen']; ?></div>
                        <div class="item-resumen"><b>Destino:</b> <?php echo $detalleServicio['destino']; ?></div>
                        <div class="item-resumen"><b>Tipo servicio:</b> <?php echo $detalleServicio['tipo_servicio']; ?></div>
                        <div class="item-resumen"><b>Tipo vehículo:</b> <?php echo htmlspecialchars($detalleServicio['nombre_tipo_vehiculo']); ?></div>
                        <div class="item-resumen"><b>Cantidad vehículos:</b> <?php echo $detalleServicio['cantidad_vehiculos']; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel-card">
                        <div class="section-title">Programación</div>
                        <div class="item-resumen"><b>Cantidad pasajeros:</b> <?php echo $detalleServicio['cantidad_pasajeros']; ?></div>
                        <div class="item-resumen"><b>Fecha inicio:</b> <?php echo $detalleServicio['fecha_inicio']; ?></div>
                        <div class="item-resumen"><b>Fecha fin:</b> <?php echo $detalleServicio['fecha_fin']; ?></div>
                        <div class="item-resumen"><b>Hora inicio:</b> <?php echo $detalleServicio['hora_inicio']; ?></div>
                        <div class="item-resumen"><b>Hora fin:</b> <?php echo $detalleServicio['hora_fin']; ?></div>
                        <div class="item-resumen"><b>Valor:</b> $<?php echo number_format((float)$detalleServicio['valor_servicio'], 0, ',', '.'); ?></div>
                        <div class="item-resumen"><b>Detalle:</b> <?php echo nl2br(htmlspecialchars($detalleServicio['detalle_servicio'])); ?></div>
                    </div>
                </div>
            </div>

            <?php if ($area == 'contabilidad') { ?>
                <hr><h5>Validación contable</h5>
                <form method="POST" action="../Controlador/guardarConfirmacionServicioOcasional.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_servicio_ocasional" value="<?php echo $id_servicio_ocasional; ?>">
                    <input type="hidden" name="area" value="contabilidad">
                    <input type="hidden" name="segundo_abono_existe" value="<?php echo !empty($documentos['doc_segundo_abono']) ? 1 : 0; ?>">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="panel-card">
                                <?php
                                $docsLabel = array(
                                    'doc_rut' => 'RUT',
                                    'doc_camara' => 'Cámara de comercio',
                                    'doc_cedula_rl' => 'Cédula representante legal',
                                    'doc_aceptacion' => 'Aceptación del cliente',
                                    'doc_contrato' => 'Contrato del servicio',
                                    'doc_primer_abono' => 'Soporte primer abono 50%',
                                    'doc_segundo_abono' => 'Soporte segundo abono 50%',
                                    'doc_prefactura' => 'Proforma'
                                );
                                foreach ($docsLabel as $campo => $label) {
                                    if (!empty($documentos[$campo])) {
                                ?>
                                        <div class="doc-row">
                                            <a href="../Documentos/ServiciosOcasionales/<?php echo $documentos[$campo]; ?>" target="_blank"><?php echo $label; ?></a>
                                            <div>
                                                <?php if ($campo === 'doc_primer_abono') { ?><label class="mb-0"><input type="checkbox" class="ml-2" name="confirmar_primer_abono" value="1" <?php echo marcado($docsContabilidad, 'primer_abono'); ?>> Confirmar</label><?php } ?>
                                                <?php if ($campo === 'doc_segundo_abono') { ?><label class="mb-0"><input type="checkbox" class="ml-2" name="confirmar_segundo_abono" value="1" <?php echo marcado($docsContabilidad, 'segundo_abono'); ?>> Confirmar</label><?php } ?>
                                                <?php if ($campo === 'doc_prefactura') { ?><label class="mb-0"><input type="checkbox" class="ml-2" name="confirmar_orden_compra" value="1" <?php echo marcado($docsContabilidad, 'orden_compra'); ?>> Confirmar</label><?php } ?>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel-card">
                                <div class="item-resumen"><b>Estado:</b> <?php echo valorCampo($confirmaciones, 'estado_contabilidad', 'SIN CONFIRMAR'); ?></div>
                                <div class="item-resumen"><b>Confirmó:</b> <?php echo nombreUsuarioConfirmacion($usuariosConfirmacion, 'usuario_contabilidad'); ?></div>
                                <div class="item-resumen"><b>Fecha:</b> <?php echo valorCampo($confirmaciones, 'fecha_contabilidad', ''); ?></div>

                                <hr>
                                <div class="section-title mb-2">Soportes contables</div>
                                <div class="form-group">
                                    <label><b>Recibo de caja abono 1 (PDF)</b></label>
                                    <input type="file" class="form-control form-control-sm" name="doc_recibo_caja_abono_1" accept="application/pdf">
                                    <?php if (!empty($documentos['doc_recibo_caja_abono_1'])) { ?>
                                        <small class="text-success d-block mt-1">Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($documentos['doc_recibo_caja_abono_1']); ?>">Ver PDF</a></small>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label><b>Recibo de caja abono 2 (PDF)</b></label>
                                    <input type="file" class="form-control form-control-sm" name="doc_recibo_caja_abono_2" accept="application/pdf">
                                    <?php if (!empty($documentos['doc_recibo_caja_abono_2'])) { ?>
                                        <small class="text-success d-block mt-1">Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($documentos['doc_recibo_caja_abono_2']); ?>">Ver PDF</a></small>
                                    <?php } ?>
                                </div>
                                <div class="form-group mb-0">
                                    <label><b>Factura (PDF)</b></label>
                                    <input type="file" class="form-control form-control-sm" name="doc_factura" accept="application/pdf">
                                    <?php if (!empty($documentos['doc_factura'])) { ?>
                                        <small class="text-success d-block mt-1">Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($documentos['doc_factura']); ?>">Ver PDF</a></small>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap mt-2">
                        <button class="btn btn-outline-primary m-1" type="submit" name="accion" value="confirmar">Confirmar</button>
                        <button class="btn btn-outline-warning m-1" type="submit" name="accion" value="soporte_pendiente">Soporte pendiente</button>
                        <button class="btn btn-outline-danger m-1" type="submit" name="accion" value="cancelar">Cancelar</button>
                    </div>
                </form>
            <?php } ?>

            <?php if ($area == 'operaciones') { ?>
                <hr><h5>Validación operativa</h5>
                <form method="POST" action="../Controlador/guardarConfirmacionServicioOcasional.php">
                    <input type="hidden" name="id_servicio_ocasional" value="<?php echo $id_servicio_ocasional; ?>">
                    <input type="hidden" name="area" value="operaciones">
                    <input type="hidden" name="cantidad_filas" value="<?php echo $cantidadFilas; ?>">

                    <?php for ($i = 1; $i <= $cantidadFilas; $i++) {
                        $f = isset($filasOperacion[$i]) ? $filasOperacion[$i] : array(); ?>
                        <div class="operation-card">
                            <h6>Vehículo <?php echo $i; ?></h6>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label>Vehículo inicio</label>
                                    <select class="form-control form-control-sm vehiculo-inicio" name="id_vehiculo_inicio[<?php echo $i; ?>]" data-row="<?php echo $i; ?>">
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($vehiculos as $v) { ?>
                                            <option value="<?php echo $v['id_vehiculo']; ?>" <?php echo (valorCampo($f, 'id_vehiculo_inicio') == $v['id_vehiculo']) ? 'selected' : ''; ?>><?php echo $v['placa'] . ' - ' . $v['marca'] . ' ' . $v['modelo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                               <div class="col-md-3 mb-2">
                                    <label>Conductor inicio</label>
                                    <select class="form-control form-control-sm conductor-inicio"
                                            id="id_conductor_inicio_<?php echo $i; ?>"
                                            name="id_conductor_inicio[<?php echo $i; ?>]"
                                            data-row="<?php echo $i; ?>"
                                            data-selected="<?php echo htmlspecialchars((string)valorCampo($f, 'id_conductor_inicio', '')); ?>">
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($conductores as $c) { ?>
                                            <option value="<?php echo $c['id_conductor']; ?>"
                                                <?php echo (valorCampo($f, 'id_conductor_inicio') == $c['id_conductor']) ? 'selected' : ''; ?>>
                                                <?php echo $c['nombre_conductor']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label>Vehículo fin</label>
                                    <select class="form-control form-control-sm vehiculo-fin" name="id_vehiculo_fin[<?php echo $i; ?>]" data-row="<?php echo $i; ?>">
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($vehiculos as $v) { ?>
                                            <option value="<?php echo $v['id_vehiculo']; ?>" <?php echo (valorCampo($f, 'id_vehiculo_fin') == $v['id_vehiculo']) ? 'selected' : ''; ?>><?php echo $v['placa'] . ' - ' . $v['marca'] . ' ' . $v['modelo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                               <div class="col-md-3 mb-2">
                                    <label>Conductor fin</label>
                                    <select class="form-control form-control-sm conductor-fin"
                                            id="id_conductor_fin_<?php echo $i; ?>"
                                            name="id_conductor_fin[<?php echo $i; ?>]"
                                            data-row="<?php echo $i; ?>"
                                            data-selected="<?php echo htmlspecialchars((string)valorCampo($f, 'id_conductor_fin', '')); ?>">
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($conductores as $c) { ?>
                                            <option value="<?php echo $c['id_conductor']; ?>"
                                                <?php echo (valorCampo($f, 'id_conductor_fin') == $c['id_conductor']) ? 'selected' : ''; ?>>
                                                <?php echo $c['nombre_conductor']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Dirección origen</label>
                                    <input type="text" class="form-control form-control-sm" name="direccion_origen[<?php echo $i; ?>]" value="<?php echo htmlspecialchars(valorCampo($f, 'direccion_origen', '')); ?>" placeholder="Ingrese dirección origen">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Dirección destino</label>
                                    <input type="text" class="form-control form-control-sm" name="direccion_destino[<?php echo $i; ?>]" value="<?php echo htmlspecialchars(valorCampo($f, 'direccion_destino', '')); ?>" placeholder="Ingrese dirección destino">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Tipo de recorrido</label>
                                    <?php $tipoRecorrido = valorCampo($f, 'tipo_recorrido', ''); ?>
                                    <select class="form-control form-control-sm" name="tipo_recorrido[<?php echo $i; ?>]">
                                        <option value="">Seleccionar</option>
                                        <option value="IDA" <?php echo ($tipoRecorrido === 'IDA') ? 'selected' : ''; ?>>Ida</option>
                                        <option value="REGRESO" <?php echo ($tipoRecorrido === 'REGRESO') ? 'selected' : ''; ?>>Regreso</option>
                                        <option value="IDA_Y_REGRESO" <?php echo ($tipoRecorrido === 'IDA_Y_REGRESO') ? 'selected' : ''; ?>>Ida y regreso</option>
                                        <option value="DISPONIBILIDAD_DIA" <?php echo ($tipoRecorrido === 'DISPONIBILIDAD_DIA') ? 'selected' : ''; ?>>Disponibilidad día</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="d-flex flex-wrap mt-2">
                        <button class="btn btn-outline-primary m-1" type="submit" name="accion" value="confirmar">Confirmar</button>
                        <button class="btn btn-outline-secondary m-1" type="submit" name="accion" value="guardar">Guardar sin confirmar</button>
                        <button class="btn btn-outline-danger m-1" type="submit" name="accion" value="cancelar">Cancelar</button>
                    </div>
                </form>
            <?php } ?>

            <?php if ($area == 'documental') { ?>
                <hr><h5>Validación documental y FUEC</h5>
                <ul class="nav nav-tabs" id="tabsDocumental" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#docVehiculo">Documentación</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#docFuec">FUEC</a></li>
                </ul>
                <div class="tab-content border border-top-0 p-3">
                    <div class="tab-pane fade show active" id="docVehiculo">
                        <?php if (count($alertasDocumentacion) > 0) { ?>
                            <div class="alert alert-danger">
                                <b>Documentación vencida detectada:</b>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($alertasDocumentacion as $alerta) { ?>
                                        <li><?php echo htmlspecialchars($alerta); ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success">No se encontraron vencimientos en la documentación de vehículos/conductores anclados.</div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-card">
                                    <h6>Vehículos anclados en operación</h6>
                                    <?php if (count($detalleOperacion) < 1) { ?>
                                        <p class="text-muted">No hay vehículos anclados por Operaciones.</p>
                                    <?php } else {
                                        foreach ($detalleOperacion as $fila) { ?>
                                            <div class="item-resumen"><b>#<?php echo $fila['consecutivo']; ?></b> Veh. inicio: <?php echo valorCampo($fila, 'placa_inicio', 'N/A'); ?> | Veh. fin: <?php echo valorCampo($fila, 'placa_fin', 'N/A'); ?></div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-card">
                                    <h6>Conductores anclados</h6>
                                    <?php if (count($detalleOperacion) < 1) { ?>
                                        <p class="text-muted">No hay conductores anclados por Operaciones.</p>
                                    <?php } else {
                                        foreach ($detalleOperacion as $fila) { ?>
                                            <div class="item-resumen"><b>#<?php echo $fila['consecutivo']; ?></b> Cond. inicio: <?php echo valorCampo($fila, 'conductor_inicio', 'N/A'); ?> | Cond. fin: <?php echo valorCampo($fila, 'conductor_fin', 'N/A'); ?></div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-2">La validación final del FUEC se realiza en la pestaña <b>FUEC</b>.</div>
                    </div>
                    <div class="tab-pane fade" id="docFuec" role="tabpanel" aria-labelledby="tab-doc-fuec">
                        <?php if (count($detalleOperacion) < 1) { ?>
                            <div class="alert alert-warning">Aún no hay vehículos/conductores anclados en Operaciones para generar la vista FUEC.</div>
                        <?php } else { ?>
                            <form method="POST" action="../Controlador/guardarConfirmacionServicioOcasional.php" class="mt-2" enctype="multipart/form-data">
                                <input type="hidden" name="id_servicio_ocasional" value="<?php echo $id_servicio_ocasional; ?>">
                                <input type="hidden" name="area" value="documental">
                                                                <div class="table-responsive mb-3">
                                    <table class="table table-sm table-bordered text-center">
                                        <thead style="background:#1b2d3b;color:#fff;">
                                            <tr>
                                                <th>FUEC</th>
                                                <th>Placa inicio</th>
                                                <th>Conductor inicio</th>
                                                <th>Placa fin</th>
                                                <th>Conductor fin</th>
                                                <th>Documento FUEC</th>
                                                <th>Convenio de colaboración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $cantidadDocumentos = 0; ?>
                                            <?php foreach ($detalleOperacion as $fila) {
                                                $consecutivoFila = (int)$fila['consecutivo'];
                                                $numFuec = 'FUEC OCASIONAL ' . $consecutivoFila;
                                                $mostrarFin = !empty($fila['id_vehiculo_fin']) && ((int)$fila['id_vehiculo_fin'] !== (int)$fila['id_vehiculo_inicio']);
                                                $docInicio = isset($documentosFuec[$consecutivoFila]['INICIO']['documento_fuec']) ? $documentosFuec[$consecutivoFila]['INICIO']['documento_fuec'] : '';
                                                $docFin = isset($documentosFuec[$consecutivoFila]['FIN']['documento_fuec']) ? $documentosFuec[$consecutivoFila]['FIN']['documento_fuec'] : '';
                                                $convInicioAplica = isset($documentosConvenio[$consecutivoFila]['INICIO']['aplica']) ? (int)$documentosConvenio[$consecutivoFila]['INICIO']['aplica'] : 0;
$convInicioDoc = isset($documentosConvenio[$consecutivoFila]['INICIO']['documento_convenio']) ? $documentosConvenio[$consecutivoFila]['INICIO']['documento_convenio'] : '';

$convFinAplica = isset($documentosConvenio[$consecutivoFila]['FIN']['aplica']) ? (int)$documentosConvenio[$consecutivoFila]['FIN']['aplica'] : 0;
$convFinDoc = isset($documentosConvenio[$consecutivoFila]['FIN']['documento_convenio']) ? $documentosConvenio[$consecutivoFila]['FIN']['documento_convenio'] : '';
                                                $cantidadDocumentos++;
                                                if ($mostrarFin) {
                                                    $cantidadDocumentos++;
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $numFuec; ?></td>
                                                    <td><?php echo htmlspecialchars(valorCampo($fila, 'placa_inicio', 'N/A')); ?></td>
                                                    <td><?php echo htmlspecialchars(valorCampo($fila, 'conductor_inicio', 'N/A')); ?></td>
                                                    <td><?php echo htmlspecialchars(valorCampo($fila, 'placa_fin', 'N/A')); ?></td>
                                                    <td><?php echo htmlspecialchars(valorCampo($fila, 'conductor_fin', 'N/A')); ?></td>
                                                    <td class="text-left">
                                                        <div class="mb-2">
                                                            <label class="mb-1"><b>Inicio (<?php echo htmlspecialchars(valorCampo($fila, 'placa_inicio', 'N/A')); ?>):</b></label>
                                                            <input type="file" class="form-control form-control-sm" name="doc_fuec[<?php echo $consecutivoFila; ?>|INICIO]" accept="application/pdf">
                                                            <input type="hidden" name="documento_existente[<?php echo $consecutivoFila; ?>|INICIO]" value="<?php echo htmlspecialchars($docInicio); ?>">
                                                            <?php if (!empty($docInicio)) { ?>
                                                                <small class="text-success d-block mt-1">Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($docInicio); ?>">Ver PDF</a></small>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if ($mostrarFin) { ?>
                                                            <div>
                                                                <label class="mb-1"><b>Fin (<?php echo htmlspecialchars(valorCampo($fila, 'placa_fin', 'N/A')); ?>):</b></label>
                                                                <input type="file" class="form-control form-control-sm" name="doc_fuec[<?php echo $consecutivoFila; ?>|FIN]" accept="application/pdf">
                                                                <input type="hidden" name="documento_existente[<?php echo $consecutivoFila; ?>|FIN]" value="<?php echo htmlspecialchars($docFin); ?>">
                                                                <?php if (!empty($docFin)) { ?>
                                                                    <small class="text-success d-block mt-1">Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($docFin); ?>">Ver PDF</a></small>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-left">
    <div class="mb-3 border rounded p-2">
        <label class="mb-1"><b>Inicio (<?php echo htmlspecialchars(valorCampo($fila, 'placa_inicio', 'N/A')); ?>):</b></label>
        <div class="mb-2">
            <label class="mr-3">
                <input type="radio"
                       name="convenio_aplica[<?php echo $consecutivoFila; ?>|INICIO]"
                       value="1"
                       <?php echo ($convInicioAplica === 1 ? 'checked' : ''); ?>
                       onclick="toggleConvenio('<?php echo $consecutivoFila; ?>_INICIO', true)">
                Sí
            </label>
            <label>
                <input type="radio"
                       name="convenio_aplica[<?php echo $consecutivoFila; ?>|INICIO]"
                       value="0"
                       <?php echo ($convInicioAplica !== 1 ? 'checked' : ''); ?>
                       onclick="toggleConvenio('<?php echo $consecutivoFila; ?>_INICIO', false)">
                No
            </label>
        </div>

        <div id="convenio_box_<?php echo $consecutivoFila; ?>_INICIO" style="<?php echo ($convInicioAplica === 1 ? '' : 'display:none;'); ?>">
            <input type="file"
                   class="form-control form-control-sm"
                   name="doc_convenio[<?php echo $consecutivoFila; ?>|INICIO]"
                   accept="application/pdf">
            <input type="hidden"
                   name="documento_convenio_existente[<?php echo $consecutivoFila; ?>|INICIO]"
                   value="<?php echo htmlspecialchars($convInicioDoc); ?>">
            <?php if (!empty($convInicioDoc)) { ?>
                <small class="text-success d-block mt-1">
                    Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($convInicioDoc); ?>">Ver PDF</a>
                </small>
            <?php } ?>
        </div>
    </div>

    <?php if ($mostrarFin) { ?>
        <div class="border rounded p-2">
            <label class="mb-1"><b>Fin (<?php echo htmlspecialchars(valorCampo($fila, 'placa_fin', 'N/A')); ?>):</b></label>
            <div class="mb-2">
                <label class="mr-3">
                    <input type="radio"
                           name="convenio_aplica[<?php echo $consecutivoFila; ?>|FIN]"
                           value="1"
                           <?php echo ($convFinAplica === 1 ? 'checked' : ''); ?>
                           onclick="toggleConvenio('<?php echo $consecutivoFila; ?>_FIN', true)">
                    Sí
                </label>
                <label>
                    <input type="radio"
                           name="convenio_aplica[<?php echo $consecutivoFila; ?>|FIN]"
                           value="0"
                           <?php echo ($convFinAplica !== 1 ? 'checked' : ''); ?>
                           onclick="toggleConvenio('<?php echo $consecutivoFila; ?>_FIN', false)">
                    No
                </label>
            </div>

            <div id="convenio_box_<?php echo $consecutivoFila; ?>_FIN" style="<?php echo ($convFinAplica === 1 ? '' : 'display:none;'); ?>">
                <input type="file"
                       class="form-control form-control-sm"
                       name="doc_convenio[<?php echo $consecutivoFila; ?>|FIN]"
                       accept="application/pdf">
                <input type="hidden"
                       name="documento_convenio_existente[<?php echo $consecutivoFila; ?>|FIN]"
                       value="<?php echo htmlspecialchars($convFinDoc); ?>">
                <?php if (!empty($convFinDoc)) { ?>
                    <small class="text-success d-block mt-1">
                        Actual: <a target="_blank" href="../Documentos/ServiciosOcasionales/<?php echo urlencode($convFinDoc); ?>">Ver PDF</a>
                    </small>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</td>


                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="cantidad_documentos" value="<?php echo $cantidadDocumentos; ?>">

                                <div class="d-flex flex-wrap mt-2">
                                    <button class="btn btn-outline-primary m-1" type="submit" name="accion" value="confirmar">Confirmar vehículo/conductor</button>
                                    <button class="btn btn-outline-warning m-1" type="submit" name="accion" value="fuec_incorrecto">FUEC incorrecto</button>
                                    <button class="btn btn-outline-danger m-1" type="submit" name="accion" value="cancelar">Cancelar</button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
</div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</section>
<?php include("Template/scripts.php"); ?>
<script>
const TODOS_LOS_CONDUCTORES = <?php echo json_encode($conductores, JSON_UNESCAPED_UNICODE); ?>;
const VALOR_MOSTRAR_TODOS = '__MOSTRAR_TODOS__';

function construirOpcionesConductores(lista, seleccionado = '') {
    let options = '<option value="">Seleccionar</option>';

    if (lista && lista.length) {
        lista.forEach(function(c) {
            const selected = (String(seleccionado) === String(c.id_conductor)) ? 'selected' : '';
            options += '<option value="' + c.id_conductor + '" ' + selected + '>' + c.nombre_conductor + '</option>';
        });
    }

    options += '<option value="' + VALOR_MOSTRAR_TODOS + '">Mostrar todos</option>';
    return options;
}

function construirOpcionesTodosConductores(seleccionado = '') {
    let options = '<option value="">Seleccionar</option>';

    TODOS_LOS_CONDUCTORES.forEach(function(c) {
        const selected = (String(seleccionado) === String(c.id_conductor)) ? 'selected' : '';
        options += '<option value="' + c.id_conductor + '" ' + selected + '>' + c.nombre_conductor + '</option>';
    });

    return options;
}

function cargarConductoresPorVehiculo(idVehiculo, targetSelect, seleccionado = '') {
    if (!idVehiculo) {
        $(targetSelect).html(construirOpcionesTodosConductores(seleccionado));
        return;
    }

    $.post('../Controlador/listarConductoresPorVehiculoSO.php', { id_vehiculo: idVehiculo }, function(resp) {
        let lista = [];

        if (resp && resp.length) {
            lista = resp;
        }

        if (seleccionado) {
            const yaExiste = lista.some(function(c) {
                return String(c.id_conductor) === String(seleccionado);
            });

            if (!yaExiste) {
                const conductorGuardado = TODOS_LOS_CONDUCTORES.find(function(c) {
                    return String(c.id_conductor) === String(seleccionado);
                });

                if (conductorGuardado) {
                    lista.push(conductorGuardado);
                }
            }
        }

        $(targetSelect).html(construirOpcionesConductores(lista, seleccionado));
    }, 'json');
}

function activarMostrarTodos(selectId) {
    $(document).on('change', selectId, function() {
        const valor = $(this).val();
        if (valor === VALOR_MOSTRAR_TODOS) {
            $(this).html(construirOpcionesTodosConductores(''));
        }
    });
}

$(document).ready(function() {
    $('#tabsDocumental .nav-link').on('click', function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    $('.vehiculo-inicio').on('change', function() {
        const row = $(this).data('row');
        const idVehiculo = $(this).val();
        const target = '#id_conductor_inicio_' + row;
        const seleccionadoActual = $(target).attr('data-selected') || '';
        cargarConductoresPorVehiculo(idVehiculo, target, seleccionadoActual);
    });

    $('.vehiculo-fin').on('change', function() {
        const row = $(this).data('row');
        const idVehiculo = $(this).val();
        const target = '#id_conductor_fin_' + row;
        const seleccionadoActual = $(target).attr('data-selected') || '';
        cargarConductoresPorVehiculo(idVehiculo, target, seleccionadoActual);
    });

    activarMostrarTodos('.conductor-inicio');
    activarMostrarTodos('.conductor-fin');

    $('.vehiculo-inicio').each(function() {
        const row = $(this).data('row');
        const idVehiculo = $(this).val();
        const target = '#id_conductor_inicio_' + row;
        const seleccionado = $(target).attr('data-selected') || '';

        if (idVehiculo) {
            cargarConductoresPorVehiculo(idVehiculo, target, seleccionado);
        }
    });

    $('.vehiculo-fin').each(function() {
        const row = $(this).data('row');
        const idVehiculo = $(this).val();
        const target = '#id_conductor_fin_' + row;
        const seleccionado = $(target).attr('data-selected') || '';

        if (idVehiculo) {
            cargarConductoresPorVehiculo(idVehiculo, target, seleccionado);
        }
    });
});

function toggleConvenio(clave, mostrar) {
    var box = document.getElementById('convenio_box_' + clave);
    if (box) {
        box.style.display = mostrar ? '' : 'none';
    }
}
</script>
</body>
</html>