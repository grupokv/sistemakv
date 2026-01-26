<?php
$filename = 'Informe actualizacion documentos vehiculos.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

require_once ('../Modelo/Vehiculo.php');
require_once ('../Modelo/Usuario.php');
require_once ('../Modelo/General.php');

$vehiculo = new Vehiculo();
$usuario = new Usuario();

$fecha_inicial_reporte = $_POST['fecha_inicial'];
$fecha_final_reporte = $_POST['fecha_final'];
$tipo_actividad = $_POST['tipoActividad'];
$id_modulo = 11;
$id_vehiculo = $_POST['vehiculo'];

$filtroActualizacionesDocs = $vehiculo->filtroActualizacionesDocs($fecha_inicial_reporte, $fecha_final_reporte, $tipo_actividad, $id_modulo, $id_vehiculo);

?>
<table  id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw-minimap style="width:100%">
		<thead>
			<tr>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>ACTIVIDAD</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist"><strong>PLACA</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>FECHA ACTIVIDAD</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>DATOS ACTUALIZADOS</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>VALORES ANTIGUOS</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>VALORES NUEVOS</strong></td>
        <td scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><strong>USUARIO</strong></td>
			</tr>
		</thead>
    <tbody>
      <?php foreach ($filtroActualizacionesDocs as $fad){ ?>
          <?php $cant_v = $vehiculo->listarConductoresPorId($lv['id_vehiculo']);?>
          <?php $c = count($cant_v); if($c < 1){ $c = 1; } ?>
          <tr style="font-size: .9rem;">
              <td><?php echo $fad['tipo_actividad']; ?></td>
              <td>
                  <?php 
                      $listarPorId = $vehiculo->listarPorId($fad['id_registro']);
                      echo $listarPorId[0]['placa'] . ' | ' . $listarPorId[0]['numero_movil']; 
                  ?>
              </td>
              <td>
                  <?php
                      echo $fad['fecha_actividad'] . ' A las ' . $fad['hora_actividad']; 
                  ?>
              </td>
              <td>
                  <?php echo strtoupper($fad['columnas_modulo']); ?>
              </td>
              <td><?php echo strtoupper($fad['valores_antiguos']); ?></td>
              <td><?php echo strtoupper($fad['valores_nuevos']); ?></td>
              <td>
                  <?php 
                      $listarUsuarioPorId = $usuario->listarUsuarioPorId($fad['id_usuario']);
                      echo $listarUsuarioPorId[0]['nombre']; 
                  ?>
              </td>
          </tr>
      <?php } ?>
	  </tbody>
</table>
  