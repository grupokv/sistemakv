<?php 

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=Reporte_VehiculosContrato.xls');

require_once('../Modelo/Vehiculo-Contrato.php');
require_once('../Modelo/TipoVehiculo.php');
require_once('../Modelo/Usuario.php');
require_once('../Modelo/Vehiculo.php');
require_once('../Modelo/Conductor.php');
require_once('../Modelo/Fuec.php');

$id_contrato = $_GET['id_contrato'];

$tipo_contrato_base = "BASE";
$tipo_contrato_apoyo = "APOYO";
$fuec = new Fuec();
$tipovehiculo = new TipoVehiculo();
$usuario = new Usuario();
$vehiculoContrato = new Vehiculo_Contrato();
$conductor = new Conductor();
$vehiculo = new Vehiculo();

$listarPorTipoContratoBase = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_base);
//echo count($listarPorTipoContratoBase);

$listarPorTipoContratoApoyo = $vehiculoContrato->listarPorTipoContrato($id_contrato, $tipo_contrato_apoyo);
?>

<table>
  	<thead>
  		<tr style="text-align: center;">

  			<!-- VEHICULOS-->
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">No.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Estado</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo utf8_decode("Tipo Afiliación"); ?> </th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Empresa Afiliada</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="presist">No. Movil</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Placa</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Marca y Linea</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha de Matricula</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Ciudad de Matricula</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Modelo</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo utf8_decode("Tipo de Vehículo"); ?></th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Cantidad de Pasajeros</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">No. de Puertas</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Cilindraje</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># de Motor</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># de Chasis</th>              
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Tipo de Carroceria</th>              
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Tipo de Combustible</th>              
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Nombre de Propietario</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">No. Documento Propietario</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo utf8_decode("Dirección Propietario"); ?></th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo utf8_decode("Teléfono Propietario"); ?></th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo utf8_decode("# Tarjeta de Operación"); ?></th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento T.O.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># L.T</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Expedición L.T.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># SOAT</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento SOAT</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># R.T</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento R.T.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento R.P.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># Polizas RCC</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># Polizas RCE</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento Polizas</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Expedición D.V.</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"># Poliza Todo Riesgo</th>
        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Fecha Vencimiento Poliza Todo Riesgo</th>
        <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Contrato</th> -->
  		</tr>
  	</thead>
  	<tbody>

    <tbody>
      <?php $i = 1; ?>
      <?php foreach ($listarPorTipoContratoBase as $lv){ ?>
        <?php $cant_v = $vehiculo->listarConductoresPorId($lv['id_vehiculo']);?>
        <?php $c = count($cant_v); if($c < 1){ $c = 1; } ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php if($lv['estado'] == 1){ echo "Activo"; } else { echo "Inactivo"; } ?></td>
            <td><?php echo $lv['tipo_afiliacion'] ?></td>
            <td><?php echo $lv['empresa_afiliada'] ?></td>
            <td><?php echo $lv['numero_movil'] ?></td>
            <td><?php echo $lv['placa'] ?></td>
            <td><?php echo $lv['marca'] ?></td>
            <td><?php echo $lv['fecha_registro'] ?></td>
            <td><?php echo $lv['ciudad_registro'] ?></td>
            <td><?php echo $lv['modelo'] ?></td>
            <td>
              <?php $tipov = $tipovehiculo->listarPorId($lv['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
            </td>
            
            <td><?php if($lv['cant_pasajeros'] == 1){
                      echo $lv['cant_pasajeros'] . " Pasajero";
                }else{
                      echo $lv['cant_pasajeros'] . " Pasajeros";
                }?>
            </td>
            <td><?php echo $lv['num_puertas'] ?></td>
            <td><?php echo $lv['cilindraje'] ?></td>
            <td><?php echo $lv['numero_motor'] ?></td>
            <td><?php echo $lv['numero_chasis'] ?></td>
            <td><?php echo $lv['tipo_carroceria'] ?></td>
            <td><?php echo $lv['tipo_combustible'] ?></td>
            <td>
              <?php
                $listarUsuario = $usuario->listarPropietariosPorId($lv['id_propietario']);
                echo $listarUsuario[0]['nombre'];
              ?>
            </td>
            <td>
              <?php
                echo $listarUsuario[0]['usuario'];
              ?>
            </td>
            <td><?php echo $lv['direccion_propietario'] ?></td>
            <td><?php echo $lv['telefono_propietario'] ?></td>
            <td><?php echo $lv['num_tarjeta_operacion'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_to'] ?></td>
            <td><?php echo $lv['num_licencia_transito'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_lt'] ?></td>
            <td><?php echo $lv['num_soat'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_soat'] ?></td>
            <td><?php echo $lv['num_revision_tecnomecanica'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_rt'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_rp'] ?></td>
            <td><?php echo $lv['num_poliza_contra'] ?></td>
            <td><?php echo $lv['num_poliza_extra'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_contra'] ?></td>
            <td><?php echo $lv['fecha_exp_disp_velocidad'] ?></td>
            <td><?php echo $lv['num_seguro_todo_riesgo'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_seguro_todo_riesgo'] ?></td>
            
        </tr>

          <?php $i++; ?>
      <?php } ?>

      <?php $a = $i; ?>
      <?php foreach ($listarPorTipoContratoApoyo as $lv){ ?>
        <?php $cant_v = $vehiculo->listarConductoresPorId($lv['id_vehiculo']);?>
        <?php $c = count($cant_v); if($c < 1){ $c = 1; } ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php if($lv['estado'] == 1){ echo "Activo"; } else { echo "Inactivo"; } ?></td>
            <td><?php echo $lv['tipo_afiliacion'] ?></td>
            <td><?php echo $lv['empresa_afiliada'] ?></td>
            <td><?php echo $lv['numero_movil'] ?></td>
            <td><?php echo $lv['placa'] ?></td>
            <td><?php echo $lv['marca'] ?></td>
            <td><?php echo $lv['fecha_registro'] ?></td>
            <td><?php echo $lv['ciudad_registro'] ?></td>
            <td><?php echo $lv['modelo'] ?></td>
            <td>
              <?php $tipov = $tipovehiculo->listarPorId($lv['id_tipo_vehiculo']); echo $tipov[0]['nombre_tipo_vehiculo']; ?>
            </td>
            
            <td><?php if($lv['cant_pasajeros'] == 1){
                      echo $lv['cant_pasajeros'] . " Pasajero";
                }else{
                      echo $lv['cant_pasajeros'] . " Pasajeros";
                }?>
            </td>
            <td><?php echo $lv['num_puertas'] ?></td>
            <td><?php echo $lv['cilindraje'] ?></td>
            <td><?php echo $lv['numero_motor'] ?></td>
            <td><?php echo $lv['numero_chasis'] ?></td>
            <td><?php echo $lv['tipo_carroceria'] ?></td>
            <td><?php echo $lv['tipo_combustible'] ?></td>
            <td>
              <?php
                $listarUsuario = $usuario->listarPropietariosPorId($lv['id_propietario']);
                echo $listarUsuario[0]['nombre'];
              ?>
            </td>
            <td>
              <?php
                echo $listarUsuario[0]['usuario'];
              ?>
            </td>
            <td><?php echo $lv['direccion_propietario'] ?></td>
            <td><?php echo $lv['telefono_propietario'] ?></td>
            <td><?php echo $lv['num_tarjeta_operacion'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_to'] ?></td>
            <td><?php echo $lv['num_licencia_transito'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_lt'] ?></td>
            <td><?php echo $lv['num_soat'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_soat'] ?></td>
            <td><?php echo $lv['num_revision_tecnomecanica'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_rt'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_rp'] ?></td>
            <td><?php echo $lv['num_poliza_contra'] ?></td>
            <td><?php echo $lv['num_poliza_extra'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_contra'] ?></td>
            <td><?php echo $lv['fecha_exp_disp_velocidad'] ?></td>
            <td><?php echo $lv['num_seguro_todo_riesgo'] ?></td>
            <td><?php echo $lv['fecha_vencimiento_seguro_todo_riesgo'] ?></td>
            
        </tr>

          <?php $i++; ?>
      <?php } ?>

    </tbody>

</table>