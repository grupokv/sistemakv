<?php
$hoy = date('Ymd_His');
$filename = $hoy.'_reporte_servicios.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

include ("../Controlador/Sesion/autenticar.php");
require ("../Modelo/Vehiculo.php");
require ("../Modelo/TipoVehiculo.php");
require ("../Modelo/Programacion.php");
require ("../Modelo/Cliente.php");
require ("../Modelo/TipoServicio.php");
require ("../Modelo/Conductor.php");

$tipo_servicio = $_POST['export_tiposervicio'];
$fechai = $_POST['export_fechai'];
$fechaf = $_POST['export_fechaf'];
$cliente1 = $_POST['export_cliente'];
$vehiculo1 = $_POST['export_vehiculo'];

$programacion = new Programacion();
if($vehiculo1 == ''){
  $listarV = $programacion->consultaReporte1($cliente1,$tipo_servicio,$fechai,$fechaf);
} else {
  $serv = $programacion->buscarServiciosPorVehiculoTodos($vehiculo1);
  $cant = count($serv);
  $servicios = '';
  $a = 1;
  foreach($serv as $ser){
    if($a == $cant){
      $servicios .= $ser['id_servicio'];
    } else {
      $servicios .= $ser['id_servicio'].',';
    }
    $a++;
  }
  $listarV = $programacion->consultaReporte2($cliente1,$tipo_servicio,$servicios,$fechai,$fechaf);
}

$cliente = new Cliente();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$tipo_vehiculo = new TipoVehiculo();
$tipo_servicio = new TipoServicio();
?>

<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
          <thead>
            <tr>
              <th>ID SERVICIO</th>
              <th>CLIENTE</th>
              <th>FECHA SOLICITUD</th>
              <th>TIPO SOLICITUD</th>
	      <th>SOLICITANTE</th>
	      <th>CONTACTO</th>
              <th>FECHA SERVICIO</th>
              <th>HORA SERVICIO</th>
              <th>TIPO VEHICULO</th>
              <th>TIPO SERVICIO</th>
              <th>ORIGEN</th>
              <th>DESTINO</th>
              <th>CANTIDAD</th>
              <th>CENTRO COSTO</th>
              <th>VALOR SERVICIO</th>
              <th>ESTADO</th>
              <th>VEH. ASIGNADO</th>
              <th>COND. ASIGNADO</th>
              <th>VALOR VEH.</th>
              <th>RELEVO</th>
              <th>VEH. RELEVO</th>
              <th>COND. RELEVO</th>
              <th>VALOR RELEVO</th>
			  <?php if(($_SESSION['id_usuario'] == '1503')or($_SESSION['id_usuario'] == '2')){ ?>
			  <th>KM. INICIAL</th>
              <th>KM. FINAL</th>  
			  <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($listarV as $lv){ ?>
	      <?php if ($lv['estado'] != 'C'){ ?>
              <tr>
                  <td><?php echo $lv['id_detalle'] ?></td>
                  <td><?php $datos_c = $cliente->cliente_ID($lv['id_cliente']); echo $datos_c[0]['razon_social']; ?></td>
                  <td><?php echo $lv['fecha_solicitud'] ?></td>
                  <td><?php echo $lv['tipo'] ?></td>
		  <td><?php echo $lv['solicitante'] ?></td>
		  <td><?php echo $lv['contacto'] ?></td>
                  <td><?php echo $lv['fecha_servicio'] ?></td>
                  <td><?php echo $lv['hora_servicio'] ?></td>
                  <td><?php $datos_tv = $tipo_vehiculo->listarPorId($lv['id_tipovehiculo']); echo $datos_tv[0]['nombre_tipo_vehiculo']; ?></td>
                  <td><?php $datos_ts = $tipo_servicio->listarPorIdCliente($lv['id_tiposervicio']); echo $datos_ts[0]['nombre_tipo_servicio'] ?></td>
                  <td><?php echo $lv['origen'] ?></td>
                  <td><?php echo $lv['destino'] ?></td>
                  <td>
                      <?php if($lv['cant_pasajeros'] == 1){
                            echo $lv['cantidad'] . " Pasajero";
                      }else{
                            echo $lv['cantidad'] . " Pasajeros";
                      }?>
                  </td>
                  <td><?php echo $lv['centro_costo'] ?></td>
                  <td><?php echo str_replace('.',',',$lv['valor']) ?></td>
                  <td>
                    <?php 
                      if($lv['estado'] == 'P'){
                        echo "Pendiente";
                      } else if($lv['estado'] == 'C'){
                        echo "Cancelado";
                      } else if($lv['estado'] == 'A'){
                        echo "Asignado";
                      } else {
                        echo "Finalizado";
                      }
                    ?>
                  </td>
                  <?php 
                  if(($lv['estado'] == 'A')or($lv['estado'] == 'F')){
                  $veh_asignado = $programacion->buscarVehiculosPorServicio($lv['id_detalle'],'D');
                  $datos_vehiculo = $vehiculo->listarPorId($veh_asignado[0]['id_vehiculo']);
                  $datos_conductor = $conductor->listarPorId($veh_asignado[0]['id_conductor']);
                    $dat_veh = $datos_vehiculo[0]['placa'];
                    $dat_cond = $datos_conductor[0]['nombre_conductor'];
                    $costo = $veh_asignado[0]['costo'];
                  } else { 
                    $dat_veh = '';
                    $dat_cond = '';
                    $costo = '';
                  }?>
                  <td><?php echo $dat_veh;?></td>
                  <td><?php echo $dat_cond;?></td>
                  <td><?php echo str_replace('.',',',$costo);?></td>
                  <?php
                  if($lv['relevo'] == 'S'){
                      $relevo = 'SI';
                      $veh_relevo = $programacion->buscarVehiculosPorServicio($lv['id_detalle'],'RC');
                      if(count($veh_relevo > 0)){
                          $datos_vehiculor = $vehiculo->listarPorId($veh_relevo[0]['id_vehiculo']);
                          $datos_conductor = $conductor->listarPorId($veh_relevo[0]['id_conductor']);
                          $dat_vehr = $datos_vehiculo[0]['placa'];
                          $dat_condr = $datos_conductor[0]['nombre_conductor'];
                          $valor_r = $veh_relevo[0]['costo'];
                      } else {
                          $veh_relevo = $programacion->buscarVehiculosPorServicio($lv['id_detalle'],'RV');
                          $datos_vehiculor = $vehiculo->listarPorId($veh_relevo[0]['id_vehiculo']);
                          $datos_conductor = $conductor->listarPorId($veh_relevo[0]['id_conductor']);
                          $dat_vehr = $datos_vehiculo[0]['placa'];
                          $dat_condr = $datos_conductor[0]['nombre_conductor'];
                          $valor_r = $veh_relevo[0]['costo'];
                      }
                  } else {
                      $relevo = 'NO';
                      $dat_vehr = '';
                      $dat_condr = '';
                      $valor_r = '';
                  }
                  ?>
                  <td><?php echo $relevo;?></td>
                  <td><?php echo $dat_vehr;?></td>
                  <td><?php echo $dat_condr;?></td>
                  <td><?php echo str_replace('.',',',$valor_r);?></td>
				  <?php if(($_SESSION['id_usuario'] == '1503')or($_SESSION['id_usuario'] == '2')){ ?>
				  <td><?php echo $veh_asignado[0]['kms_inicio'];?></td>
				  <td><?php echo $veh_asignado[0]['kms_final'];?></td>
				  <?php } ?> 
              </tr>
	      <?php } ?>
            <?php } ?>
          </tbody>
        </table>