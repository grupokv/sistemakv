<?php
include("../Controlador/Sesion/autenticar.php");
require_once('../Modelo/ServicioOcasional.php');

$servicioOcasional = new ServicioOcasional();
$listarTodosClientes = $servicioOcasional->listarClientesConServicios();
$listarEmisores = $servicioOcasional->listarEmisoresServiciosOcasionales();

$id_responsable = '%%';
$id_cliente = '%%';
$fecha_inicial = '0000-00-00';
$fecha_final = '9999-12-31';

if ($_POST) {
    if (isset($_POST['id_responsable']) && $_POST['id_responsable'] !== '') {
        $id_responsable = $_POST['id_responsable'];
    }

    if (isset($_POST['id_cliente']) && $_POST['id_cliente'] !== '') {
        $id_cliente = $_POST['id_cliente'];
    }

    if (isset($_POST['fecha_inicial']) && $_POST['fecha_inicial'] !== '') {
        $fecha_inicial = $_POST['fecha_inicial'];
    }

    if (isset($_POST['fecha_final']) && $_POST['fecha_final'] !== '') {
        $fecha_final = $_POST['fecha_final'];
    }
}

$reservas = $servicioOcasional->filtrarReservasReporte($id_responsable, $id_cliente, $fecha_inicial, $fecha_final);

function textoSeguro($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function valorReserva($reserva, $claves, $default = 'N/A')
{
    foreach ($claves as $clave) {
        if (isset($reserva[$clave]) && $reserva[$clave] !== '' && $reserva[$clave] !== null) {
            return $reserva[$clave];
        }
    }

    return $default;
}

function tipoAfiliacionSimple($valor)
{
    $texto = trim((string) $valor);
    if ($texto === '') {
        return 'N/A';
    }

    $partes = array_map('trim', explode(' / ', $texto));
    $simples = array();

    foreach ($partes as $parte) {
        $normalizado = strtoupper($parte);

        if (strpos($normalizado, 'FLOTA PROPIA') !== false) {
            $simples[] = 'FLOTA PROPIA';
        } elseif (strpos($normalizado, 'AFILIADO') !== false) {
            $simples[] = 'AFILIADO';
        } elseif (strpos($normalizado, 'TERCERO') !== false) {
            $simples[] = 'TERCERO';
        }
    }

    $simples = array_values(array_unique($simples));

    return count($simples) > 0 ? implode(' / ', $simples) : 'N/A';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Reporte Reservas Ocasionales</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include('Template/styles.php'); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <style>
        .filtros-reservas label {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .filtros-reservas .form-control,
        .filtros-reservas .btn,
        .filtros-reservas .bootstrap-select .dropdown-toggle {
            font-size: 12px;
        }

        .contenedor-tabla-reservas {
            padding-bottom: 8px;
        }

        .contenedor-tabla-reservas .dataTables_wrapper > .row:nth-child(2) {
            overflow-x: auto;
            margin-left: 0;
            margin-right: 0;
        }

        .tabla-reservas-ocasionales {
            min-width: 2500px;
            width: 100%;
            font-size: 13px;
        }

        .tabla-reservas-ocasionales th,
        .tabla-reservas-ocasionales td {
            white-space: nowrap;
            padding: 10px 12px !important;
            vertical-align: middle !important;
        }

        .tabla-reservas-ocasionales .col-detalle {
            min-width: 260px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
<?php include('Template/header.php'); ?>
<?php include('Template/newMenu.php'); ?>
<section class="home_content">
    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-table mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">REPORTE DE RESERVAS - SERVICIOS OCASIONALES</b></strong>
    </div>

    <div class="col-lg-12 mt-3" style="background-color: #1b2d3b; color: #fff; border-radius: 3px; width: 100%"><p><b>FILTROS (OPCIONALES)</b></p></div>

    <div class="col-12 p-4" style="height: auto; width: 100%; border-radius: 4px; background-color: #fff;">
        <form method="POST" action="" class="filtros-reservas">
            <div class="row mt-2 d-flex justify-content-around">
                <div class="col-md-3 col-sm-12">
                    <label><b>EMISOR / RESPONSABLE</b></label>
                    <select class="form-control selectpicker" data-live-search="true" name="id_responsable">
                        <option value="">TODOS</option>
                        <?php foreach ($listarEmisores as $emisor) { ?>
                            <option value="<?php echo textoSeguro($emisor['id_usuario']); ?>" <?php echo ($id_responsable == $emisor['id_usuario']) ? 'selected' : ''; ?>><?php echo textoSeguro($emisor['nombre']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-12">
                    <label><b>CLIENTE / CONTRATANTE</b></label>
                    <select class="form-control selectpicker" data-live-search="true" name="id_cliente">
                        <option value="">TODOS</option>
                        <?php foreach ($listarTodosClientes as $clienteItem) { ?>
                            <option value="<?php echo textoSeguro($clienteItem['id_cliente']); ?>" <?php echo ($id_cliente == $clienteItem['id_cliente']) ? 'selected' : ''; ?>><?php echo textoSeguro($clienteItem['razon_social']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12">
                    <label><b>FECHA INICIAL</b></label>
                    <input type="date" name="fecha_inicial" class="form-control" value="<?php echo ($fecha_inicial == '0000-00-00') ? '' : textoSeguro($fecha_inicial); ?>">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label><b>FECHA FINAL</b></label>
                    <input type="date" name="fecha_final" class="form-control" value="<?php echo ($fecha_final == '9999-12-31') ? '' : textoSeguro($fecha_final); ?>">
                </div>
                <div class="col-md-2 col-sm-12">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-outline-info btn-block">Filtrar</button>
                </div>
            </div>
        </form>

        <form action="exportarReporteReservasServiciosOcasionales.php" method="post" class="mt-3">
            <input type="hidden" name="id_responsable" value="<?php echo textoSeguro($id_responsable); ?>">
            <input type="hidden" name="id_cliente" value="<?php echo textoSeguro($id_cliente); ?>">
            <input type="hidden" name="fecha_inicial" value="<?php echo textoSeguro($fecha_inicial); ?>">
            <input type="hidden" name="fecha_final" value="<?php echo textoSeguro($fecha_final); ?>">
            <div class="row d-flex justify-content-center">
                <div class="col-md-3 col-sm-12">
                    <button type="submit" class="btn btn-outline-success btn-block">Descargar reporte <i class="fa fa-file-excel-o ml-1"></i></button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-2 p-4" style="background-color: #fff;">
        <div class="contenedor-tabla-reservas">
        <table id="dataT" class="table table-hover text-center table-sm display tabla-reservas-ocasionales">
            <thead>
            <tr style="background-color: #1b2d3b; color: #fff;"><th colspan="20">TOTAL RESERVAS: <?php echo count($reservas); ?></th></tr>
            <tr style="background-color: #1b2d3b; color: #fff;">
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
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservas as $reserva) { ?>
                <tr>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['id_servicio_ocasional'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['contratante', 'nombre_contratante'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['cliente', 'razon_social'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['tipo_servicio'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['origen'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['destino'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['nombre_tipo_vehiculo', 'id_tipo_vehiculo'], 'N/A')); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['cantidad_vehiculos'], '0')); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['cantidad_pasajeros'], '0')); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['placa_inicio', 'placas_inicio'])); ?></td>
                    <td><?php echo textoSeguro(tipoAfiliacionSimple(valorReserva($reserva, ['tipo_afiliacion_inicio'], ''))); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['conductor_inicio'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['placa_fin', 'placas_fin'])); ?></td>
                    <td><?php echo textoSeguro(tipoAfiliacionSimple(valorReserva($reserva, ['tipo_afiliacion_fin'], ''))); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['conductor_fin'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['valor_servicio', 'valor'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['fecha_inicio', 'fecha_hora_inicio'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['fecha_fin', 'fecha_hora_fin'])); ?></td>
                    <td><?php echo textoSeguro(valorReserva($reserva, ['responsable', 'responsable_creador'])); ?></td>
                    <td class="col-detalle"><?php echo textoSeguro(valorReserva($reserva, ['detalle', 'detalle_servicio'], '')); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
        <div class="row mt-4"><div class="col-md-3 col-sm-12"><a href="serviciosOcasionales.php" class="btn btn-outline-secondary btn-block">Regresar</a></div></div>
    </div>
</section>
<?php include('Template/scripts.php'); ?>
</body>
</html>