<?php
require_once(__DIR__ . "/../Controlador/Sesion/autenticar.php");
require_once(__DIR__ . "/../Modelo/ServicioOcasional.php");
require_once(__DIR__ . "/../Modelo/Cliente.php");
require_once(__DIR__ . "/../Modelo/TipoVehiculo.php");
require_once(__DIR__ . "/../Modelo/EmpresaEnt.php");
require_once(__DIR__ . "/../Modelo/Ciudad.php");

$id_servicio_ocasional = isset($_GET['id_servicio_ocasional']) ? (int)$_GET['id_servicio_ocasional'] : 0;

$servicioOcasional = new ServicioOcasional();
$clienteModel = new Cliente();
$tipoVehiculo = new TipoVehiculo();
$empresa = new Empresa();
$ciudad = new Ciudad();

$detalleServicio = $servicioOcasional->listarServicioPorId($id_servicio_ocasional);
$detalleServicio = isset($detalleServicio[0]) ? $detalleServicio[0] : null;
$documentos = $servicioOcasional->listarDocumentosServicioOcasional($id_servicio_ocasional);

$listarClientes = $clienteModel->listar();
$listarTV = $tipoVehiculo->listar();
$listarEmpresas = $empresa->listar();
$ciudades = $ciudad->listar();

function ciudadIdPorNombre($ciudades, $nombre)
{
    $objetivo = mb_strtoupper(trim((string)$nombre));
    foreach ($ciudades as $c) {
        if (mb_strtoupper(trim((string)$c['ciudad'])) === $objetivo) {
            return (int)$c['id_ciudad'];
        }
    }
    return 0;
}

$clienteAnclado = array();
if ($detalleServicio && !empty($detalleServicio['id_cliente'])) {
    $tmp = $clienteModel->listarClientePorId($detalleServicio['id_cliente']);
    $clienteAnclado = isset($tmp[0]) ? $tmp[0] : array();
}

$idOrigen = $detalleServicio ? ciudadIdPorNombre($ciudades, $detalleServicio['origen']) : 0;
$idDestino = $detalleServicio ? ciudadIdPorNombre($ciudades, $detalleServicio['destino']) : 0;

$tiposVehiculoSeleccionados = array();

$tiposVehiculoSeleccionados = array();

if ($detalleServicio && !empty($detalleServicio['id_tipo_vehiculo'])) {
    $tiposVehiculoSeleccionados = array_map('trim', explode(',', (string)$detalleServicio['id_tipo_vehiculo']));
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Actualizar Reserva Ocasional</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{
            background: #1b2d3b !important;
            border: #fff;
        }
        .doc-item{padding:8px 10px;border:1px solid #e6edf5;border-radius:8px;margin-bottom:8px;background:#fff;}
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
            <li class="breadcrumb-item active" aria-current="page">Actualizar Reserva Ocasional</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-edit mr-3" style="font-size: 2rem;"></i>ACTUALIZAR RESERVA OCASIONAL</strong>
    </div>

    <section class="form-usuarios mt-1 p-3 mb-2">
        <?php if (!$detalleServicio) { ?>
            <div class="alert alert-danger">No se encontró la reserva seleccionada.</div>
        <?php } else { ?>
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/actualizarReservaOcasional.php" method="POST" id="actualizarReservaOcasional" enctype="multipart/form-data">
                    <input type="hidden" name="id_servicio_ocasional" value="<?php echo (int)$detalleServicio['id_servicio_ocasional']; ?>">
                    <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo (int)$detalleServicio['id_cliente']; ?>">

                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Cliente</a></li>
                            <li><a href="#tabs-2">Información Servicio</a></li>
                            <li><a href="#tabs-3">Documentos</a></li>
                            <li><a href="#tabs-4">Detalles del servicio</a></li>
                        </ul>

                        <div id="tabs-1" class="p-4">
                            <div class="row mt-3">
                                <div class="label"><label>Seleccione el tipo de registro</label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm" id="opcionCliente" disabled>
                                        <option value="BA" selected>Buscar y Anclar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Cliente anclado</label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_cliente_existente" id="id_cliente_existente" disabled>
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarClientes as $lc){ ?>
                                            <option value="<?php echo $lc['id_cliente']; ?>" <?php echo ((int)$detalleServicio['id_cliente'] === (int)$lc['id_cliente']) ? 'selected' : ''; ?>><?php echo $lc['razon_social'] . ' - ' . $lc['nit_cliente']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Razón social</label></div>
                                <div class="input"><input type="text" class="form-control form-control-sm" value="<?php echo isset($clienteAnclado['razon_social']) ? htmlspecialchars($clienteAnclado['razon_social']) : ''; ?>" readonly></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>NIT o cédula</label></div>
                                <div class="input"><input type="text" class="form-control form-control-sm" value="<?php echo isset($clienteAnclado['nit_cliente']) ? htmlspecialchars($clienteAnclado['nit_cliente']) : ''; ?>" readonly></div>
                            </div>
                        </div>

                        <div id="tabs-2" class="p-4">
                            <div class="row mt-3">
                                <div class="label"><label>Contratante (Empresa) <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_empresa" id="id_empresa" required>
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listarEmpresas as $le){ ?>
                                            <option value="<?php echo $le['id_empresa']; ?>" <?php echo ((int)$detalleServicio['id_empresa'] === (int)$le['id_empresa']) ? 'selected' : ''; ?>><?php echo $le['nombre_empresa']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Origen Del Servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="origen" id="origen" required>
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($ciudades as $cs){ ?>
                                            <option value="<?php echo $cs['id_ciudad']; ?>" <?php echo ($idOrigen === (int)$cs['id_ciudad']) ? 'selected' : ''; ?>><?php echo $cs['ciudad']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Destino del Servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="destino" id="destino" required>
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($ciudades as $cs){ ?>
                                            <option value="<?php echo $cs['id_ciudad']; ?>" <?php echo ($idDestino === (int)$cs['id_ciudad']) ? 'selected' : ''; ?>><?php echo $cs['ciudad']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Tipo de servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input">
                                    <select class="form-control form-control-sm" name="tipo_servicio_reserva" id="tipo_servicio_reserva" required>
                                        <option value="">SELECCIONAR</option>
                                        <option value="EMPRESARIAL" <?php echo ($detalleServicio['tipo_servicio'] === 'EMPRESARIAL') ? 'selected' : ''; ?>>EMPRESARIAL</option>
                                        <option value="TURISTICO" <?php echo ($detalleServicio['tipo_servicio'] === 'TURISTICO') ? 'selected' : ''; ?>>TURÍSTICO</option>
                                        <option value="EVENTOS" <?php echo ($detalleServicio['tipo_servicio'] === 'EVENTOS') ? 'selected' : ''; ?>>EVENTOS</option>
                                        <option value="TRASLADO_ESPECIAL" <?php echo ($detalleServicio['tipo_servicio'] === 'TRASLADO_ESPECIAL') ? 'selected' : ''; ?>>TRASLADO ESPECIAL</option>
                                        <option value="GRUPO_ESPECIFICO" <?php echo ($detalleServicio['tipo_servicio'] === 'GRUPO_ESPECIFICO') ? 'selected' : ''; ?>>GRUPO ESPECÍFICO DE USUARIOS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
    <div class="label"><label>Tipo de vehículo <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
    <div class="input">
        <select class="form-control form-control-sm selectpicker"
                data-live-search="true"
                multiple
                name="id_tipo_vehiculo[]"
                id="id_tipo_vehiculo"
                title="SELECCIONAR"
                required>
            <?php foreach ($listarTV as $ltv){ ?>
                <option value="<?php echo $ltv['id_tipo_vehiculo']; ?>"
                    <?php echo in_array((string)$ltv['id_tipo_vehiculo'], $tiposVehiculoSeleccionados, true) ? 'selected' : ''; ?>>
                    <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

                            <div class="row mt-3">
                                <div class="label"><label>Cantidad de vehículos <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="number" min="1" name="cantidad_vehiculos" id="cantidad_vehiculos" class="form-control form-control-sm" value="<?php echo (int)$detalleServicio['cantidad_vehiculos']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Cantidad de pasajeros <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="number" min="1" name="cantidad_pasajeros" id="cantidad_pasajeros" class="form-control form-control-sm" value="<?php echo (int)$detalleServicio['cantidad_pasajeros']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Fecha inicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-sm" value="<?php echo $detalleServicio['fecha_inicio']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Fecha fin <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="date" name="fecha_fin" id="fecha_fin" class="form-control form-control-sm" value="<?php echo $detalleServicio['fecha_fin']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Hora inicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="time" name="hora_inicio" id="hora_inicio" class="form-control form-control-sm" value="<?php echo $detalleServicio['hora_inicio']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Hora fin <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="time" name="hora_fin" id="hora_fin" class="form-control form-control-sm" value="<?php echo $detalleServicio['hora_fin']; ?>" required></div>
                            </div>

                            <div class="row mt-3">
                                <div class="label"><label>Valor del servicio <i style="font-size: .4rem;" class="fa fa-asterisk"></i></label></div>
                                <div class="input"><input type="number" min="0" name="valor_servicio" id="valor_servicio" class="form-control form-control-sm" value="<?php echo (float)$detalleServicio['valor_servicio']; ?>" required></div>
                            </div>
                        </div>

                        <div id="tabs-3" class="p-4">
                            <?php
                            $docs = array(
                                'doc_rut' => 'RUT',
                                'doc_camara' => 'Cámara de comercio',
                                'doc_cedula_rl' => 'Cédula representante legal',
                                'doc_aceptacion' => 'Aceptación del cliente',
                                'doc_contrato' => 'Contrato del servicio',
                                'doc_primer_abono' => 'Soporte primer abono 50%',
                                'doc_segundo_abono' => 'Soporte segundo abono 50%',
                                'doc_prefactura' => 'Proforma'
                            );
                            foreach ($docs as $campo => $label) { ?>
                                <div class="doc-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <b><?php echo $label; ?>:</b>
                                            <?php if (!empty($documentos[$campo])) { ?>
                                                <a href="../Documentos/ServiciosOcasionales/<?php echo $documentos[$campo]; ?>" target="_blank">Ver documento cargado</a>
                                            <?php } else { ?>
                                                <span class="text-muted">No cargado</span>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-5 mt-2 mt-md-0">
                                            <input type="file" name="<?php echo $campo; ?>" class="form-control form-control-sm" accept="application/pdf">
                                            <small class="text-muted">Seleccione PDF para reemplazar/actualizar.</small>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div id="tabs-4" class="p-4">
                            <div class="row mt-3">
                                <div class="label"><label>Detalle del servicio</label></div>
                                <div class="input">
                                    <textarea name="detalle_servicio" id="detalle_servicio" rows="6" class="form-control form-control-sm" placeholder="Escriba aquí el detalle del servicio"><?php echo htmlspecialchars($detalleServicio['detalle_servicio']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center mt-3 mb-2">
                        <button type="submit" class="btn btn-outline-primary mr-2">ACTUALIZAR</button>
                        <a href="serviciosOcasionales.php" class="btn btn-outline-danger">CANCELAR</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </section>
</section>

<?php include("Template/scripts.php"); ?>
<script>
    $(function() {
    $("#tabs").tabs();
    $('.selectpicker').selectpicker('refresh');
});
</script>

</body>
</html>