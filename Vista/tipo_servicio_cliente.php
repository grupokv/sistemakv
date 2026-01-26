<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/TipoServicioCliente.php");

$cliente = new Cliente();
$tipo_vehiculo = new TipoVehiculo();
$tipo_servicio = new TipoServicioCliente();

$listado = $tipo_servicio->listar();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Tipo Servicio Cliente</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>
  <!--fin  styles -->

</head>
<body>
    <!--MENU-->
       <?php include("Template/menu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
         <ol class="breadcrumb">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tipo Servicio Cliente</li>
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-building-o" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Cargos</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarTipoServicioCliente.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">registrar cargos <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
    				<th>NOMBRE</th>
				<th>TIPO VEHICULO</th>
                    		<th>CLIENTE</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php foreach ($listado as $lc){ ?>
    				<tr>
    					<td><?php echo $lc['detalle'] ?></td>
					<td>
					<?php
					$detalle_veh = $tipo_vehiculo->listarPorId($lc['id_tipo_vehiculo']); 
					echo $detalle_veh[0]['nombre_tipo_vehiculo']; ?>
					</td>
                        		<td>
					<?php
					$detalle_cliente = $cliente->cliente_ID($lc['id_cliente']); 
					echo $detalle_cliente[0]['razon_social']; ?>
					</td>
    					<td>
    					    <a href="actualizarTipoServicioCliente.php?id=<?php echo $lc['id_tipo_servicio']; ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
    					</td>
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