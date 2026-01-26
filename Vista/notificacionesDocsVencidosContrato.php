<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Cliente.php';
require_once '../Modelo/Contrato.php';
require_once '../Modelo/Vehiculo-Contrato.php';
require_once '../Modelo/Vehiculo-Conductor.php';

$vehiculo = new Vehiculo();
$conductor = new Conductor();
$cliente = new Cliente();
$contrato = new Contrato();
$veh_con = new Vehiculo_Contrato();
$veh_cond = new Vehiculo_Conductor();

$id_usuario = $_SESSION['id_usuario'];
//$id_usuario = 1493;
$hoy = date('Y-m-d');

$fecha = strtotime('+3 days',strtotime(date('Y-m-d')));
$notificarFecha = date('Y-m-d',$fecha);

$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$notificarFecha2 = date('Y-m-d',$fecha2);

$listar = $cliente->listar_programacion($id_usuario);
if(count($listar) < 1){
	/*echo "<script>
    alert('Usted no tiene ningun cliente anclado');
    window.location.href = '../Vista/inicio.php';
    </script>";
    exit;*/
}
$listado_clientes = '';
for($i=0;$i<count($listar);$i++){
	if($i==(count($listar)-1)){
		$listado_clientes .= $listar[$i]['id_cliente'];
	} else {
		$listado_clientes .= $listar[$i]['id_cliente'].',';
	}
}
//echo $listado_clientes;
$listar2 = $contrato->listarActivosPorClientes($listado_clientes,$hoy);
$contratos_activos = '';
for($i=0;$i<count($listar2);$i++){
	if($i==(count($listar2)-1)){
		$contratos_activos .= $listar2[$i]['id_contrato'];
	} else {
		$contratos_activos .= $listar2[$i]['id_contrato'].',';
	}
}
//echo $contratos_activos;

$listado_vehiculos = $veh_con->listarVehiculosPorContratos($contratos_activos);
$listado_veh = '';
for($i=0;$i<count($listado_vehiculos);$i++){
	if($i==(count($listado_vehiculos)-1)){
		$listado_veh .= $listado_vehiculos[$i]['id_vehiculo'];
	} else {
		$listado_veh .= $listado_vehiculos[$i]['id_vehiculo'].',';
	}
}
//echo $listado_veh;

$listado_conductores = $veh_cond->listarConductoresPorVehiculos($listado_veh);
$listado_cond = '';
for($i=0;$i<count($listado_conductores);$i++){
	if($i==(count($listado_conductores)-1)){
		$listado_cond .= $listado_conductores[$i]['id_conductor'];
	} else {
		$listado_cond .= $listado_conductores[$i]['id_conductor'].',';
	}
}
//echo $listado_cond;

/*Tarjeta de Operación*/
$listarToVencidos = $vehiculo->listarDocsToVencidosVeh($listado_veh,$notificarFecha);
/*Soat*/
$listarDocsSoatVencidos = $vehiculo->listarDocsSoatVencidosVeh($listado_veh,$notificarFecha);
/*Revision Tecnomecanica*/
$listarDocsRtVencidos = $vehiculo->listarDocsRtVencidosVeh($listado_veh,$notificarFecha);
/*Revision Preventiva*/
$listarDocsRpVencidos = $vehiculo->listarDocsRpVencidosVeh($listado_veh,$notificarFecha);
/*Contractual*/
$listarDocsPcVencidos = $vehiculo->listarDocspcVencidosVeh($listado_veh,$notificarFecha);
/*Extra Contractual*/
$listarDocsPeVencidos = $vehiculo->listarDocspeVencidosVeh($listado_veh,$notificarFecha);
/*Dispositivo Velocidad*/
$listarDocsDpVencidos = $vehiculo->listarDisposVencidosVeh($listado_veh,$notificarFecha2);

/*Licencia*/
$listarDocsConductorLcVencidos = $conductor->listarDocsConductorLcVencidosConductores($listado_cond,$notificarFecha);
//print_r($listarDocsConductorLcVencidos);

?> 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Documentacion Vencida</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <style type="text/css">
     @media (max-width: 760px){
        .icono-principal{
          display: none;
        }

        .titulo-principal{
            font-size: 1.6rem;
            text-align: center;
        }

     }
  </style>
</head>
<body>

    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->
  
    <!-- CONTENIDO -->

    <div aria-label="breadcrumb" class="mt-1"> 
      <ol class="breadcrumb">
          <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Documentacion Vencida</li>
      </ol>
    </div>

    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
      <div class="col">
        <h2 class="ml-4 mt-2 titulo-principal" style="color: #fff;"><span class="fa fa-envelope icono-principal"  style="border: 1px solid #fff; border-radius: 50%; padding: 7px;"></span>Documentación Vencida</h2>
      </div>
    </div>
    <hr style="background-color:#5e99b1; ">


    <section class="">
      <div class="col-12 mt-2 p-4 table-responsive">  
        <table id="dataT" class="table table-hover table-sm display" style="width:100%">
          <form method="POST"> 
            <thead>
                <tr class="text-center">
                    <th>TIPO</th>
                    <th>PLACA - No. DOCUMENTO</th>
                    <th>MOVIL - NOMBRE CONDUCTOR</th>
                    <th>EMPRESA</th>
                    <th>DOCUMENTO</th>
                    <th>FECHA DE VENCIMIENTO</th>                   
                    <th>ESTADO</th>
                    <!--<th>OPCIONES</th>-->
                </tr>
            </thead>
            <tbody>

              <!--TARJETA DE OPERACION-->
                <?php foreach ($listarToVencidos as $ltv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $ltv['placa']; ?></td>
                      <td><?php echo $ltv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($ltv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($ltv['numero_movil'] >= 1)&&($ltv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($ltv['numero_movil'] >= 1000)&&($ltv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Tarjeta de Operación</td>
                      <td><?php echo $ltv['fecha_vencimiento_to']; ?></td>
                      <td><?php if ($ltv['fecha_vencimiento_to'] <= date('Y-m-d')){echo "Vencido";}else if(($ltv['fecha_vencimiento_to'] <= $notificarFecha)&&($ltv['fecha_vencimiento_to'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $ltv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

              <!-- SOAT-->
                <?php foreach ($listarDocsSoatVencidos as $ldsv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $ldsv['placa']; ?></td>
                      <td><?php echo $ldsv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($ldsv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($ldsv['numero_movil'] >= 1)&&($ldsv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($ldsv['numero_movil'] >= 1000)&&($ldsv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Soat</td>
                      <td><?php echo $ldsv['fecha_vencimiento_soat']; ?></td>
                      <td><?php if ($ldsv['fecha_vencimiento_soat'] <= date('Y-m-d')){echo "Vencido";}else if(($ldsv['fecha_vencimiento_soat'] <= $notificarFecha)&&($ldsv['fecha_vencimiento_soat'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $ldsv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>
             
              <!--REVISION TECNO-->
                <?php foreach ($listarDocsRtVencidos as $lrtv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $lrtv['placa']; ?></td>
                      <td><?php echo $lrtv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($lrtv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($lrtv['numero_movil'] >= 1)&&($lrtv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($lrtv['numero_movil'] >= 1000)&&($lrtv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Revision Tecnomecanica</td>
                      <td><?php echo $lrtv['fecha_vencimiento_rt']; ?></td>
                      <td><?php if ($lrtv['fecha_vencimiento_rt'] <= date('Y-m-d')){echo "Vencido";}else if(($lrtv['fecha_vencimiento_rt'] <= $notificarFecha)&&($lrtv['fecha_vencimiento_rt'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrtv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

              <!--REVISION PREVENTIVA-->
                <?php foreach ($listarDocsRpVencidos as $lrpv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $lrpv['placa']; ?></td>
                      <td><?php echo $lrpv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($lrpv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($lrpv['numero_movil'] >= 1)&&($lrpv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($lrpv['numero_movil'] >= 1000)&&($lrpv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Revision Preventiva</td>
                      <td><?php echo $lrpv['fecha_vencimiento_rp']; ?></td>
                      <td><?php if ($lrpv['fecha_vencimiento_rp'] <= date('Y-m-d')){echo "Vencido";}else if(($lrpv['fecha_vencimiento_rp'] <= $notificarFecha)&&($lrpv['fecha_vencimiento_rp'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a href="actualizarVehiculo.php?id_vehiculo=<?php echo $lrpv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

              <!--POLIZA CONTRA-->
                <?php foreach ($listarDocsPcVencidos as $lpcv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $lpcv['placa']; ?></td>
                      <td><?php echo $lpcv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($lpcv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($lpcv['numero_movil'] >= 1)&&($lpcv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($lpcv['numero_movil'] >= 1000)&&($lpcv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Poliza - Contractual</td>
                      <td><?php echo $lpcv['fecha_vencimiento_contra']; ?></td>
                      <td><?php if ($lpcv['fecha_vencimiento_contra'] <= date('Y-m-d')){echo "Vencido";}else if(($lpcv['fecha_vencimiento_contra'] <= $notificarFecha)&&($lpcv['fecha_vencimiento_contra'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $lpcv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

              <!--POLIZA EXTRA-->
                <?php foreach ($listarDocsPeVencidos as $lpev){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $lpev['placa']; ?></td>
                      <td><?php echo $lpev['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($lpev['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($lpev['numero_movil'] >= 1)&&($lpev['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($lpev['numero_movil'] >= 1000)&&($lpev['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Poliza - Extra Contractual</td>
                      <td><?php echo $lpev['fecha_vencimiento_extra']; ?></td>
                      <td><?php if ($lpev['fecha_vencimiento_extra'] <= date('Y-m-d')){echo "Vencido";}else if(($lpev['fecha_vencimiento_extra'] <= $notificarFecha)&&($lpev['fecha_vencimiento_extra'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $lpev['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

                <!--DISPOSITIVO VELOCIDAD-->
                <?php foreach ($listarDocsDpVencidos as $ldpv){ ?>
                  <tr class="text-center">
                      <td>VEHICULO</td>
                      <td><?php echo $ldpv['placa']; ?></td>
                      <td><?php echo $ldpv['numero_movil']; ?></td>
                      <td>
                          <?php 
                          if($ldpv['numero_movil'] == 0){ echo 'Convenio'; 
                          } else if (($ldpv['numero_movil'] >= 1)&&($ldpv['numero_movil'] <= 999)){ echo 'ORT'; 
                          } else if (($ldpv['numero_movil'] >= 1000)&&($ldpv['numero_movil'] <= 1999)){ echo 'Lineas Premium';
                          } 
                          ?>
                      </td>
                      <td>Dispositivo Velocidad</td>
                      <td><?php echo $ldpv['fecha_exp_disp_velocidad']; ?></td>
                      <td><?php if ($ldpv['fecha_exp_disp_velocidad'] <= $notificarFecha2){echo "Vencido";}else if(($ldpv['fecha_exp_disp_velocidad'] <= $notificarFecha)&&($ldpv['fecha_exp_disp_velocidad'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a  href="actualizarVehiculo.php?id_vehiculo=<?php echo $ldpv['id_vehiculo']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>

                

              <!--LICENCIA DE CONDUCIR  -->
                <?php foreach ($listarDocsConductorLcVencidos as $llcv){ ?>
                  <tr class="text-center">
                      <td>CONDUCTOR</td>
                      <td><?php echo $llcv['numero_documento_conductor']; ?></td>
                      <td><?php echo $llcv['nombre_conductor']; ?></td>
                      <td><?php echo 'N/A';?></td>
                      <td>Licencia de Conducir</td>
                      <td><?php echo $llcv['fecha_vencimiento_licencia']; ?></td>
                      <td><?php if ($llcv['fecha_vencimiento_licencia'] <= date('Y-m-d')){echo "Vencido";}else if(($llcv['fecha_vencimiento_licencia'] <= $notificarFecha)&&($llcv['fecha_vencimiento_licencia'] > date('Y-m-d'))){ echo "Proximo a vencer";} ?>            
                      </td>
                      <!--<td><a href="actualizarConductores.php?id_conductor=<?php echo $llcv['id_conductor']  ?>" class="btn btn-primary" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a></td>-->
                  </tr>
                <?php } ?>
                
            </tbody>
          </form>
        </table>
      </div> 
    </section>
    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
</body>
</html>