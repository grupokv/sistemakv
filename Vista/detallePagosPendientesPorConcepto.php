<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/ConceptosCobro.php");
require_once '../Modelo/Vehiculo.php';

$concepto = new ConceptoCobro();
$vehiculo = new Vehiculo();

$id_concepto = base64_decode($_GET['id_concepto']);

$buscarVehiculoPorPropietario = $vehiculo->buscarVehiculoPorPropietario($_SESSION['id_usuario']);

$listado_veh = '';

$i=1;

foreach($buscarVehiculoPorPropietario as $vp){
    
    if($i==count($buscarVehiculoPorPropietario)){
        $listado_veh .= $vp['id_vehiculo'];
    } else {
        $listado_veh .= $vp['id_vehiculo'].',';
    }   
    
$i++; 

}

$listarCobrosPorIdConcepto = $concepto->listarCobrosPorIdConcepto($id_concepto, $listado_veh);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Pagos Pendientes</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
        
        <style>
            

          .barra-principal{
            background-color: #5e99b1;
            width: auto;
          }

          .botones_principal{
            display: flex;
            justify-content: flex-end;
          }

          .boton-registro{
            background-color: #fff; 
            height: 40px;
            margin-top: 10px; 
            margin-bottom: 10px; 
            color: #00a0df;
          }


          @media (max-width: 760px){
            
              .fa-plus{
                  display: none;
              }

              .titulo_principal{
                  text-align: center;
                  margin-top: 5px;
              }

              .botones_principal{
                  display: block;
                  padding: 10px ;
                  width: 100% !important;
              }

              .boton-registro{
                  width: 90% !important;
                  margin: 4px; 
              }


          }
        </style>
    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <section class="home_content"> 

        <div aria-label="breadcrumb" class="mt-1"> 
             <ol class="breadcrumb" style="background-color: #fff;">
                <li class="breadcrumb-item " aria-current="page"><a href="inicioPropietarios.php">Inicio</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="pagos_pendientes_propietario.php">Pagos pendientes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagos Pendientes</li>
             </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-money mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">PAGOS PENDIENTES</b></strong>
        </div>

        <div class="notice notice-sistemakv">
            <a id="buttonsKV" href="reportarPago.php" class="btn btn-outline-info">Enviar Comprobante Pago <i class="fa fa-file"></i></a>

            <a id="buttonsKV" href="realizarPagoConceptoCarteraPropietario.php" class="btn btn-outline-info" >Realizar Pago <i class="fa fa-dollar"></i></a>
        </div>

        <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
          	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
          		<thead style="background-color: #1b2d3b; color: #fff;">
          			<tr class="text-center">
          				<th>PLACA</th>
          				<th># MOVIL</th>
          				<th>CONCEPTO</th>
          				<th>FECHA</th>
          				<th>VALOR</th>
          			</tr>
          		</thead>
          		<tbody>
          			<?php foreach ($listarCobrosPorIdConcepto as $lcpc){ ?>
          				<tr class="text-center">
          					<?php $datos_v = $vehiculo->listarPorId($lcpc['id_vehiculo']); ?>
          					<?php $datos_c = $concepto->listarPorId($lcpc['id_concepto']); ?>	
          					<td><?php echo $datos_v[0]['placa']; ?></td>
          					<td><?php echo $datos_v[0]['numero_movil']; ?></td>
          					<td><?php if(($lcpc['id_concepto'] == 0) && ($lcpc['detalle_servicio'] != "" )){ echo $lcpc['detalle_servicio']; } else { echo $datos_c[0]['detalle_concepto']; } ?></td>
          					<td><?php setlocale(LC_TIME, 'spanish'); echo strtoupper(strftime("%B %d del %Y",strtotime($lcpc['fecha_cobro']))); ?></td>
          					<td><?php echo '$ '.number_format($lcpc['valor'],0,',','.'); ?></td>
          				</tr>
          			<?php } ?>
          		</tbody>
          	</table>
        </div>

    </section>
    
    <!-- FIN CONTENIDO -->


    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->
</body>
</html>