<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/ServicioOcasional.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

$servicioOcasional = new ServicioOcasional();
$usuario = new Usuario();

$modulo = 11;
$permisos = permisos($modulo, $_SESSION['id_usuario']);
if (count($permisos) < 1) {
    echo ("<script LANGUAGE='JavaScript'>
        window.location.href='https://www.sistemakv.com/';
    </script>");
    exit;
}

$listarServiciosOcasionales = $servicioOcasional->listarServiciosOcasionales(date('Y'));

$rutaVista = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
if (substr($rutaVista, -6) !== '/Vista') {
    $rutaVista .= '/Vista';
}

$cacheUsuarios = array();
$detalleOperacionMap = array();
foreach ($listarServiciosOcasionales as $srv) {
    $detalleOperacionMap[$srv['id_servicio_ocasional']] = $servicioOcasional->listarDetalleOperacionConNombres($srv['id_servicio_ocasional']);
}

function estadoReservaLabel($estado)
{
    if ($estado == 'F') {
        return "<div class='col-12' style='background-color: #288211; border-radius: 25px; color: #fff;'>Finalizado</div>";
    }

    if ($estado == 'C') {
        return "<div class='col-12' style='background-color: #c23e3e; border-radius: 25px; color: #fff;'>Cancelado</div>";
    }

    return "<div class='col-12' style='background-color: #eda426; border-radius: 25px; color: #fff;'>En proceso</div>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Servicios Ocasionales</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  <style>
      .modal-backdrop{ z-index: 2; }
      .tabla-servicios-container{
          background-color:#fff;
          border-radius:5px;
          overflow-x:auto;
          -webkit-overflow-scrolling: touch;
      }
      #dataTable{
          width:100% !important;
          min-width: 1600px;
      }
      #dataTable thead { background-color: #fff; }
      #dataTable tr { background-color: #fff; }
      #dataTable th,
      #dataTable td {
          white-space: nowrap;
          vertical-align: middle;
      }
      #dataTable th { border-radius: 13px; border: 3px solid #fff; background-color: #274054; color: #fff; padding: 10px; }
      #dataTable td { font-size: .8rem; }
      #dataTable td:last-child{ min-width: 170px; }
  </style>
</head>
<body>

<?php include("Template/header.php"); ?>
<?php include("Template/newMenu.php"); ?>

<section class="home_content">
    <div class="notice notice-sistemakv">
        <strong><i class="fa fa-calendar-check-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">SERVICIOS OCASIONALES</b></strong>
    </div>

    <div class="notice notice-sistemakv p-2">
        <?php if ($permisos[0]['agregacion'] == 1) { ?>
            <a id="buttonsKV" href="<?php echo $rutaVista; ?>/registrarReservaOcasional.php" class="btn m-1">Reserva Ocasional <i class="fa fa-plus-circle ml-1"></i></a>
        <?php } ?>
        <a id="buttonsKV" href="<?php echo $rutaVista; ?>/registrarReservaFija.php" class="btn m-1">Reserva Fija <i class="fa fa-calendar ml-1"></i></a>
        <?php if ($permisos[0]['consulta'] == 1) { ?>
            <a id="buttonsKV" href="reporteReservasServiciosOcasionales.php" class="btn m-1">Reporte <i class="fa fa-clipboard ml-1"></i></a>
        <?php } ?>
    </div>

    <div class="mt-2 mb-4 table-responsive p-4 tabla-servicios-container">
        <table id="dataTable" class="table table-hover table-sm display" style="width:100%;">
            <thead style="background-color: #1b2d3b; color: #fff;">
                <tr class="text-center">
                    <th>ID RESERVA</th>
                    <th>CONTRATANTE</th>
                    <th>CLIENTE</th>
                    <th>ORIGEN</th>
                    <th>DESTINO</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA FIN</th>
                    <th>PLACA INICIO</th>
                    <th>PLACA FIN</th>
                    <th>RESPONSABLE</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listarServiciosOcasionales as $ls) {
                    $detalles = isset($detalleOperacionMap[$ls['id_servicio_ocasional']]) ? $detalleOperacionMap[$ls['id_servicio_ocasional']] : array();
                    $placaInicio = count($detalles) ? implode(' / ', array_map(function ($d) {
                        return !empty($d['placa_inicio']) ? $d['placa_inicio'] : 'N/A';
                    }, $detalles)) : 'N/A';
                    $placaFin = count($detalles) ? implode(' / ', array_map(function ($d) {
                        return !empty($d['placa_fin']) ? $d['placa_fin'] : 'N/A';
                    }, $detalles)) : 'N/A';
                    $estadoCerrado = ($ls['estado'] == 'F' || $ls['estado'] == 'C');

                    if (!isset($cacheUsuarios[$ls['id_responsable']])) {
                        $listarUsuario = $usuario->listarUsuarioPorId($ls['id_responsable']);
                        $cacheUsuarios[$ls['id_responsable']] = isset($listarUsuario[0]['nombre']) ? utf8_encode($listarUsuario[0]['nombre']) : 'Sin responsable';
                    }
                ?>
                    <tr class="text-center">
                        <td><?php echo $ls['id_servicio_ocasional']; ?></td>
                        <td><?php echo $ls['nombre_empresa']; ?></td>
                        <td><?php echo $ls['razon_social']; ?></td>
                        <td><?php echo $ls['origen']; ?></td>
                        <td><?php echo $ls['destino']; ?></td>
                        <td><?php echo $ls['fecha_inicio']; ?></td>
                        <td><?php echo $ls['fecha_fin']; ?></td>
                        <td><?php echo $placaInicio; ?></td>
                        <td><?php echo $placaFin; ?></td>
                        <td><?php echo $cacheUsuarios[$ls['id_responsable']]; ?></td>
                        <td><?php echo estadoReservaLabel($ls['estado']); ?></td>
                        <td>
                            <?php if (!$estadoCerrado && ($permisos[0]['eliminacion'] == 1)) { ?>
                                <button onclick="modalCambiarEstado(<?php echo $ls['id_servicio_ocasional']; ?>);" class="btn btn-outline-danger" style="margin: 2px; padding: 0px 4px;"><i class="fa fa-lock"></i></button>
                            <?php } ?>

                            <?php if ($permisos[0]['consulta'] == 1) { ?>
                                <a href="<?php echo $rutaVista; ?>/serviciosOcasionalesConsulta.php?id_servicio_ocasional=<?php echo $ls['id_servicio_ocasional']; ?>" class="btn btn-outline-warning" style="margin: 2px; padding: 0px 4px;"><i class="fa fa-search"></i></a>
                            <?php } ?>

                            <?php if (!$estadoCerrado && ($permisos[0]['edicion'] == 1)) { ?>
                                <a href="<?php echo $rutaVista; ?>/actualizarReservaOcasional.php?id_servicio_ocasional=<?php echo $ls['id_servicio_ocasional']; ?>" class="btn btn-outline-info" style="margin: 2px; padding: 0px 4px;"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo $rutaVista; ?>/serviciosOcasionalesArea.php?area=contabilidad&id_servicio_ocasional=<?php echo $ls['id_servicio_ocasional']; ?>" class="btn btn-outline-success" style="margin: 2px; padding: 0px 4px;" title="Contabilidad"><i class="fa fa-money"></i></a>
                                <a href="<?php echo $rutaVista; ?>/serviciosOcasionalesArea.php?area=operaciones&id_servicio_ocasional=<?php echo $ls['id_servicio_ocasional']; ?>" class="btn btn-outline-primary" style="margin: 2px; padding: 0px 4px;" title="Operaciones"><i class="fa fa-cogs"></i></a>
                                <a href="<?php echo $rutaVista; ?>/serviciosOcasionalesArea.php?area=documental&id_servicio_ocasional=<?php echo $ls['id_servicio_ocasional']; ?>" class="btn btn-outline-secondary" style="margin: 2px; padding: 0px 4px;" title="Documental"><i class="fa fa-folder-open"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalEstados" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3">
            <form method="POST" action="../Controlador/actualizarEstadoServicioOcasional.php">
                <div class="modal-body">
                    <div class="col-12 text-center mb-3">
                        <h5 class="modal-title" style="font-size: .9rem;"><b>ACTUALIZACIÓN DE ESTADO - RESERVA</b></h5>
                    </div>
                    <hr>
                    <div class="text-center" id="mensaje"><p style="font-size: .8rem;">¿Está seguro de actualizar el estado de la reserva?</p></div>
                    <input type="hidden" id="id_servicio_ocasional" name="id_servicio_ocasional" class="form-control form-control-sm">
                    <div class="col-12 mt-4">
                        <label style="font-size: .8rem;">Estado de la reserva</label>
                        <select class="form-control form-control-sm selectpicker" name="estadoReserva" id="estadoReserva" title="Seleccionar" required>
                            <option value="F">Finalizado</option>
                            <option value="C">Cancelado</option>
                        </select>
                    </div>
                    <hr>
                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-danger mr-2" data-dismiss="modal" style="font-size: .8rem;">CERRAR</button>
                        <button type="submit" name="enviar" class="btn btn-outline-primary" style="font-size: .8rem;">ACTUALIZAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("Template/scripts.php"); ?>
<script>
$(document).ready(function(){
    $('#dataTable').DataTable({"order": [[0, "desc"]], "scrollX": true, "autoWidth": false, "responsive": false});
});
function modalCambiarEstado(idServicio){
    $('#modalEstados').modal('show');
    $('#id_servicio_ocasional').val(idServicio);
}
</script>
</body>
</html>