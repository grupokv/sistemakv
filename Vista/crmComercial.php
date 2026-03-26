<?php
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Usuario.php';

function crmToString($value) {
  if (is_array($value)) {
    $parts = [];
    array_walk_recursive($value, function ($item) use (&$parts) {
      if (is_scalar($item) || (is_object($item) && method_exists($item, '__toString'))) {
        $parts[] = (string)$item;
      }
    });
    return trim(implode(' ', $parts));
  }

  if (is_object($value) && method_exists($value, '__toString')) {
    return (string)$value;
  }

  if (is_scalar($value) || $value === null) {
    return (string)$value;
  }

  return '';
}

$usuario = new Usuario();
$id_usuario = (int)$_SESSION['id_usuario'];
$listarUsuarioID = $usuario->listarUsuarioPorId($id_usuario);
$nombreUsuarioRaw = isset($listarUsuarioID[0]['nombre']) ? $listarUsuarioID[0]['nombre'] : '';
$nombreUsuario = ucfirst(mb_strtolower(crmToString($nombreUsuarioRaw)));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | CRM Comercial</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  <style>
    body { background: #dcdcdc; }
    .home_content { padding: 15px 20px 30px 20px; }

    .crm-panel {
      background: #fff;
      border-radius: 8px;
      padding: 12px;
      box-shadow: 0 2px 7px rgba(0,0,0,.12);
      margin-bottom: 12px;
    }

    .crm-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
    }

    .crm-actions .btn { margin-right: 8px; margin-bottom: 6px; }

    .crm-btn-system {
      background: #ffffff;
      color: #4f97bc;
      border: 1px solid #4f97bc;
      border-radius: 16px;
      font-weight: 600;
      padding: 8px 18px;
      font-size: 15px;
    }

    .crm-btn-system:hover,
    .crm-btn-system:focus {
      color: #2e7ea7;
      border-color: #2e7ea7;
      background: #ffffff;
    }

    .crm-metrics {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .metric-box {
      background: #0d2a63;
      color: #fff;
      border-radius: 8px;
      padding: 10px 12px;
      min-width: 190px;
      min-height: 82px;
      font-size: 12px;
    }

    .metric-box strong { font-size: 20px; display: block; margin-top: 4px; }

    .donut {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: conic-gradient(#35d07f 0deg, #35d07f 180deg, #f14f4f 180deg 360deg);
      position: relative;
      margin-right: 8px;
    }

    .donut:after {
      content: '';
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: #0d2a63;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .metric-flex { display: flex; align-items: center; }

    #tablaCRM {
      width: 100% !important;
      min-width: 2400px;
      font-size: 12px;
      table-layout: auto;
    }
    #tablaCRM th {
      background: #0d2a63;
      color: #fff;
      font-weight: 700;
      font-size: 10px;
      white-space: nowrap;
      vertical-align: middle;
    }

    .dataTables_scrollHead table th {
      background: #0d2a63 !important;
      color: #fff !important;
      font-weight: 700 !important;
      font-size: 10px !important;
    }
    #tablaCRM td {
      vertical-align: middle;
      white-space: nowrap;
    }

    .dataTables_wrapper .dataTables_scrollBody {
      overflow-x: auto !important;
      overflow-y: auto !important;
    }

    .btn-lock {
      background: #dc3545;
      color: #fff;
      border: 1px solid #b82836;
    }

    #tablaCRM .btn-xs {
      padding: 1px 5px;
      font-size: 10px;
      line-height: 1.2;
    }

    .semaforo {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-weight: 600;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      display: inline-block;
    }

    .dot-rojo { background: #d9534f; }
    .dot-naranja { background: #f0ad4e; }
    .dot-verde { background: #5cb85c; }

    .modal input, .modal select, .modal textarea { text-transform: none !important; font-size: 12px; }
    .modal .modal-title,
    .modal .form-group label {
      color: #0d2a63;
      font-weight: 700;
    }

    .dataTables_wrapper .dataTables_paginate,
    .dataTables_wrapper .dataTables_info {
      position: sticky;
      left: 0;
      background: #fff;
      padding-top: 8px;
    }

    @media (max-width: 991px) {
      .crm-toolbar { flex-direction: column; align-items: flex-start; }
    }
  </style>
</head>
<body>
  <?php include("Template/header.php"); ?>
  <?php include("Template/newMenu.php"); ?>

  <section class="home_content">
    <div class="notice notice-warning">
      <strong>Bienvenid@ <?php echo htmlspecialchars(crmToString($nombreUsuario), ENT_QUOTES, 'UTF-8'); ?></strong> al sistemakv - Crm Comercial.
    </div>

    <div class="crm-panel">
      <div class="crm-toolbar">
        <div class="crm-actions">
          <button class="btn crm-btn-system" id="btnAgregar">Agregar dato <i class="fa fa-plus"></i></button>
        </div>

        <div class="crm-metrics">
          <div class="metric-box">
            Status promedio
            <div class="metric-flex">
              <div class="donut" id="donutStatus"></div>
              <div style="font-size:11px;">
                <div><span class="dot dot-rojo"></span> Frio: <b id="labelRojo">0%</b></div>
                <div><span class="dot dot-naranja"></span> Medio: <b id="labelNaranja">0%</b></div>
                <div><span class="dot dot-verde"></span> Caliente: <b id="labelVerde">0%</b></div>
              </div>
            </div>
          </div>
          <div class="metric-box">
            Activos vs Inactivos
            <div class="metric-flex">
              <div class="donut" id="donutEstado"></div>
              <div style="font-size:11px;">
                <div>Activos: <b id="labelActivos">0</b></div>
                <div>Inactivos: <b id="labelInactivos">0</b></div>
              </div>
            </div>
          </div>
          <div class="metric-box">
            Total datos agregados
            <strong id="metricTotal">0</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="crm-panel">
      <table class="table table-bordered table-hover" id="tablaCRM">
        <thead>
          <tr>
            <th>ID</th>
            <th>OPCIONES</th>
            <th>FECHA INGRESO</th>
            <th>NOMBRE</th>
            <th>EMPRESA</th>
            <th>ESTADO DE VENTA</th>
            <th>TIPO CLIENTE</th>
            <th>STATUS</th>
            <th>TELEFONO</th>
            <th>CORREO</th>
            <th>CIUDAD</th>
            <th>ESTADO</th>
            <th>FECHA SEGUIMIENTO</th>
            <th>VALOR POTENCIAL</th>
            <th>ULTIMO CONTACTO</th>
            <th>RESPONSABLE</th>
            <th>OBSERVACIONES</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </section>

  <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="tituloModal">Agregar registro CRM</h4>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <form id="formCRM" autocomplete="off">
            <input type="hidden" id="registroId" name="id">
            <div class="row">
              <div class="col-md-4 form-group"><label>Fecha ingreso</label><input type="date" class="form-control" id="fechaIngreso" disabled></div>
              <div class="col-md-4 form-group"><label>Nombre</label><input type="text" class="form-control" id="nombre" required></div>
              <div class="col-md-4 form-group"><label>Empresa</label><input type="text" class="form-control" id="empresa" required></div>

              <div class="col-md-4 form-group"><label>Estado de venta</label>
                <select class="form-control" id="estadoVenta" required>
                  <option value="">Seleccione</option>
                  <option>Prospecto</option>
                  <option>Contactado</option>
                  <option>Calificado</option>
                  <option>En proceso</option>
                  <option>Cotización enviada</option>
                  <option>En negociación</option>
                  <option>Cierre</option>
                  <option>Cerrado (Ganado)</option>
                  <option>Cerrado (Perdido)</option>
                  <option>Pospuesto</option>
                  <option value="__OTRO__">Otro</option>
                </select>
              </div>
              <div class="col-md-4 form-group" id="estadoVentaOtroWrap" style="display:none;">
                <label>Otro estado de venta</label>
                <input type="text" class="form-control" id="estadoVentaOtro" placeholder="Escriba el estado de venta">
              </div>
              <div class="col-md-4 form-group"><label>Tipo cliente</label>
                <select class="form-control" id="tipoCliente" required>
                  <option value="">Seleccione</option>
                  <option>Empresarial</option>
                  <option>Escolar</option>
                  <option>Turismo</option>
                  <option>Expreso</option>
                  <option>Salud</option>
                  <option>Concesionario</option>
                  <option>Para Afiliar</option>
                </select>
              </div>
              <div class="col-md-4 form-group"><label>Status (%)</label><input type="number" min="0" max="100" class="form-control" id="status" required></div>

              <div class="col-md-4 form-group"><label>Telefono</label><input type="text" class="form-control" id="telefono"></div>
              <div class="col-md-4 form-group"><label>Correo</label><input type="email" class="form-control" id="correo"></div>
              <div class="col-md-4 form-group"><label>Ciudad</label><input type="text" class="form-control" id="ciudad"></div>

              <div class="col-md-4 form-group"><label>Estado</label><input type="text" class="form-control" value="ACTIVO" disabled></div>
              <div class="col-md-4 form-group"><label>Fecha seguimiento</label><input type="date" class="form-control" id="fechaSeguimiento"></div>
              <div class="col-md-4 form-group"><label>Valor potencial</label><input type="number" min="0" class="form-control" id="valorPotencial"></div>

              <div class="col-md-6 form-group"><label>Ultimo contacto</label><input type="date" class="form-control" id="ultimoContacto"></div>
              <div class="col-md-6 form-group"><label>Responsable</label><input type="text" class="form-control" id="responsable" value="<?php echo htmlspecialchars(crmToString($nombreUsuario), ENT_QUOTES, 'UTF-8'); ?>"></div>
              <div class="col-md-12 form-group"><label>Observaciones</label><textarea class="form-control" id="observaciones" rows="2"></textarea></div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" id="guardarRegistro">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("Template/scripts.php") ?>
  <script>
    (function () {
      const apiUrl = '../WS/WS_crmComercial.php';
      let tabla = null;

      function semaforoHtml(valor) {
        const n = Number(valor || 0);
        let clase = 'dot-rojo';
        if (n >= 80) clase = 'dot-verde';
        else if (n >= 50) clase = 'dot-naranja';
        return `<span class="semaforo"><span class="dot ${clase}"></span>${n}%</span>`;
      }

      function cargarTabla() {
        $.getJSON(apiUrl, { accion: 'listar' }, function (resp) {
          if (!resp.ok) return;
          const data = resp.data || [];
          const tbody = $('#tablaCRM tbody');
          tbody.empty();

          data.forEach(item => {
            const candado = item.estado === 'ACTIVO' ? 'fa-lock' : 'fa-unlock-alt';
            const badge = item.estado === 'ACTIVO'
              ? '<span class="label label-success">ACTIVO</span>'
              : '<span class="label label-danger">INACTIVO</span>';

            tbody.append(`
              <tr>
                <td>${item.id}</td>
                <td>
                  <button class="btn btn-xs btn-primary btnEditar" data-id="${item.id}"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-xs btn-lock btnEstado" data-id="${item.id}"><i class="fa ${candado}"></i></button>
                </td>
                <td>${item.fecha_ingreso || ''}</td>
                <td>${item.nombre || ''}</td>
                <td>${item.empresa || ''}</td>
                <td>${item.estado_venta || ''}</td>
                <td>${item.tipo_cliente || ''}</td>
                <td>${semaforoHtml(item.status_porcentaje)}</td>
                <td>${item.telefono || ''}</td>
                <td>${item.correo || ''}</td>
                <td>${item.ciudad || ''}</td>
                <td>${badge}</td>
                <td>${item.fecha_seguimiento || ''}</td>
                <td>$${Number(item.valor_potencial || 0).toLocaleString('es-CO')}</td>
                <td>${item.ultimo_contacto || ''}</td>
                <td>${item.responsable || ''}</td>
                <td>${item.observaciones || ''}</td>
              </tr>
            `);
          });

          if (tabla) tabla.destroy();
          tabla = $('#tablaCRM').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,
            language: {
              search: 'Buscar:',
              lengthMenu: 'Mostrar _MENU_ registros',
              info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
              paginate: { previous: 'Anterior', next: 'Siguiente' },
              emptyTable: 'No hay datos CRM cargados'
            }
          });

          renderMetricas(data);
        });
      }

      function renderMetricas(data) {
        const total = data.length;
        $('#metricTotal').text(total);

        const rojos = data.filter(r => Number(r.status_porcentaje || 0) < 50).length;
        const naranjas = data.filter(r => Number(r.status_porcentaje || 0) >= 50 && Number(r.status_porcentaje || 0) <= 79).length;
        const verdes = data.filter(r => Number(r.status_porcentaje || 0) >= 80).length;
        const pRojo = total ? (rojos / total) * 100 : 0;
        const pNaranja = total ? (naranjas / total) * 100 : 0;
        const pVerde = total ? (verdes / total) * 100 : 0;
        const degRojo = (pRojo / 100) * 360;
        const degNaranja = degRojo + ((pNaranja / 100) * 360);

        $('#donutStatus').css('background',
          `conic-gradient(#d9534f 0deg, #d9534f ${degRojo}deg, #f0ad4e ${degRojo}deg, #f0ad4e ${degNaranja}deg, #5cb85c ${degNaranja}deg, #5cb85c 360deg)`);
        $('#labelRojo').text(`${pRojo.toFixed(1)}%`);
        $('#labelNaranja').text(`${pNaranja.toFixed(1)}%`);
        $('#labelVerde').text(`${pVerde.toFixed(1)}%`);

        const activos = data.filter(r => r.estado === 'ACTIVO').length;
        const inactivos = total - activos;
        const pActivos = total ? (activos / total) * 100 : 0;
        const pInactivos = total ? (inactivos / total) * 100 : 0;
        const grados = Math.round((pActivos / 100) * 360);

        $('#donutEstado').css('background', `conic-gradient(#35d07f 0deg, #35d07f ${grados}deg, #f14f4f ${grados}deg 360deg)`);
        $('#labelActivos').text(activos);
        $('#labelInactivos').text(inactivos);
      }

      function toggleEstadoVentaOtro() {
        const esOtro = $('#estadoVenta').val() === '__OTRO__';
        $('#estadoVentaOtroWrap').toggle(esOtro);
        $('#estadoVentaOtro').prop('required', esOtro);
        if (!esOtro) {
          $('#estadoVentaOtro').val('');
        }
      }

      function abrirNuevo() {
        $('#tituloModal').text('Agregar registro CRM');
        $('#formCRM')[0].reset();
        $('#registroId').val('');
        $('#fechaIngreso').val(new Date().toISOString().split('T')[0]);
        $('#responsable').val(<?php echo json_encode(crmToString($nombreUsuario)); ?>);
        toggleEstadoVentaOtro();
        $('#modalRegistro').modal('show');
      }

      function editarRegistro(id) {
        $.getJSON(apiUrl, { accion: 'listar' }, function (resp) {
          if (!resp.ok) return;
          const item = (resp.data || []).find(r => Number(r.id) === Number(id));
          if (!item) return;
          $('#tituloModal').text(`Editar registro #${item.id}`);
          $('#registroId').val(item.id);
          $('#fechaIngreso').val(item.fecha_ingreso);
          $('#nombre').val(item.nombre);
          $('#empresa').val(item.empresa);
          const opcionesEstadoVenta = [
            'Prospecto', 'Contactado', 'Calificado', 'En proceso', 'Cotización enviada',
            'En negociación', 'Cierre', 'Cerrado (Ganado)', 'Cerrado (Perdido)', 'Pospuesto'
          ];
          if (opcionesEstadoVenta.indexOf(item.estado_venta) >= 0) {
            $('#estadoVenta').val(item.estado_venta);
            $('#estadoVentaOtro').val('');
          } else {
            $('#estadoVenta').val('__OTRO__');
            $('#estadoVentaOtro').val(item.estado_venta || '');
          }
          toggleEstadoVentaOtro();
          $('#tipoCliente').val(item.tipo_cliente);
          $('#status').val(item.status_porcentaje);
          $('#telefono').val(item.telefono);
          $('#correo').val(item.correo);
          $('#ciudad').val(item.ciudad);
          $('#fechaSeguimiento').val(item.fecha_seguimiento);
          $('#valorPotencial').val(item.valor_potencial);
          $('#ultimoContacto').val(item.ultimo_contacto);
          $('#responsable').val(item.responsable);
          $('#observaciones').val(item.observaciones);
          $('#modalRegistro').modal('show');
        });
      }

      function guardar() {
        if (!$('#formCRM')[0].checkValidity()) {
          $('#formCRM')[0].reportValidity();
          return;
        }

        const estadoVentaSeleccionado = $('#estadoVenta').val();
        const estadoVentaFinal = estadoVentaSeleccionado === '__OTRO__'
          ? $('#estadoVentaOtro').val().trim()
          : estadoVentaSeleccionado;

        if (!estadoVentaFinal) {
          alertify.error('Debe indicar el estado de venta.');
          return;
        }

        $.post(apiUrl, {
          accion: 'guardar',
          id: $('#registroId').val(),
          nombre: $('#nombre').val(),
          empresa: $('#empresa').val(),
          estado_venta: estadoVentaFinal,
          tipo_cliente: $('#tipoCliente').val(),
          status_porcentaje: $('#status').val(),
          telefono: $('#telefono').val(),
          correo: $('#correo').val(),
          ciudad: $('#ciudad').val(),
          fecha_seguimiento: $('#fechaSeguimiento').val(),
          valor_potencial: $('#valorPotencial').val(),
          ultimo_contacto: $('#ultimoContacto').val(),
          responsable: $('#responsable').val(),
          observaciones: $('#observaciones').val()
        }, function (resp) {
          let r = resp;
          if (typeof resp === 'string') r = JSON.parse(resp);
          if (r.ok) {
            $('#modalRegistro').modal('hide');
            window.location.reload();
            return;
          } else {
            alertify.error(r.mensaje || 'No se pudo guardar');
          }
        });
      }

      function cambiarEstado(id) {
        $.post(apiUrl, { accion: 'cambiar_estado', id }, function (resp) {
          let r = resp;
          if (typeof resp === 'string') r = JSON.parse(resp);
          if (!r.ok) {
            alertify.warning('No se pudo cambiar el estado del registro.');
            return;
          }
          window.location.reload();
        });
      }

      $('#btnAgregar').on('click', abrirNuevo);
      $('#estadoVenta').on('change', toggleEstadoVentaOtro);

      $('#guardarRegistro').on('click', guardar);
      $(document).on('click', '.btnEditar', function () { editarRegistro($(this).data('id')); });
      $(document).on('click', '.btnEstado', function () { cambiarEstado($(this).data('id')); });

      cargarTabla();
    })();
  </script>
</body>
</html>