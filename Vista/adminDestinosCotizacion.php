<?php 
//include("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Cotizador.php");

$cotizacion = new Cotizador();
$listarE = $cotizacion->listarDestinos();

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Destinos Cotizacion</title>
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
         </ol>
    </div>
    <hr style="background-color:#5e99b1; ">
    <div class="row" style="height: 60px; background-color: #5e99b1; ">
    	<div class="col-6">
    		<h2 class="ml-4 mt-2" style="color: #fff; line-height: 25px;"><span class="fa fa-briefcase" style="border: 2px solid #fff; border-radius: 50%;  font-size:0.8em; padding: 9px;"></span> Destinos Cotizador</h2>
    	</div>
    	<div class="col-6 d-flex justify-content-end">
            <a href="registrarDestinoCotizador.php" class="btn  mr-4" style="background-color: #fff; height: 40px; margin-top: 10px; color: #00a0df;">registrar destino <span class="fa fa-plus"></span></a>
        </div>
    </div>
    <hr style="background-color:#5e99b1;">
    <div class="mt-2 p-4 table-responsive">
    	<table  id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead>
    			<tr>
    				<th>DESTINO</th>
    				<th>DIAS SERVICIO</th>
    				<th>KMS</th>
    				<th>PEAJES</th>
    				<th>OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody>
    		       <?php foreach ($listarE as $le){ ?>
    				<tr>
    					<td><?php echo $le['ciudad'].' - '.$le['departamento']; ?></td>
    					<td><?php echo $le['dias']; ?></td>
    					<td><?php echo $le['kms_ida_retorno']; ?></td>
    					<td><?php echo $le['total_peaje_viaje']; ?></td>
    					
    					<td>

    					       <a href="actualizarDestinoCotizador.php?id=<?php echo $le['id_destino']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>

						 <a href="../controlador/borrarDestinoCotizador.php?id=<?php echo $le['id_destino']; ?>" class="btn btn-outline-danger"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-close"></span></a>

    					</td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
    </div>
    
    <!-- FIN CONTENIDO -->

    <!-- script -->
    <?php include("Template/scripts.php"); ?>
  
</body>
</html>