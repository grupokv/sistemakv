<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Cartera.php");
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/General.php';

$cartera = new Cartera();
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

$consultarAvalIdVehiculo = $cartera->consultarAvalIdVehiculo($listado_veh);

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
              <strong><i class="fa fa-list-alt mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">PAGOS PENDIENTES</b></strong>
          </div>

          <div class="notice notice-sistemakv">
              <a id="buttonsKV" href="realizarPagoAvalCarteraPropietario.php" class="btn btn-outline-info"><b>Realizar Pago</b> <i class="fa fa-dollar ml-1"></i></a>
          </div>


          <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
          	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
          		<thead style="background-color: #1b2d3b; color: #fff;">
          			<tr class="text-center">
          				<th>PLACA</th>
          				<th># MOVIL</th>
          				<th>DETALLE</th></th>
          				<th>FECHA - MES</th>
          				<th>VALOR</th>
          			</tr>
          		</thead>
          		<tbody>
          			<?php foreach ($consultarAvalIdVehiculo as $laiv){ ?>
          				<tr class="text-center">
          					<?php $datos_v = $vehiculo->listarPorId($laiv['id_vehiculo']); ?>	
          					<td><?php echo $datos_v[0]['placa']; ?></td>
          					<td><?php echo $datos_v[0]['numero_movil']; ?></td>
          					<td><?php echo "SALDO AVAL - " . $laiv['anio']; ?></td>
          					<td><?php echo strtoupper(mes($laiv['mes'])) . " DE " . $laiv['anio']; ?></td>
          					<td><?php echo '$ '.number_format($laiv['valor'],0,',','.'); ?></td>
          				</tr>
          			<?php } ?>
          		</tbody>
          	</table>
          </div>
    
    <!-- FIN CONTENIDO -->


    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->
</body>
</html>