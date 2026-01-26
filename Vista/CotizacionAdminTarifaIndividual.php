<?php 
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$listar = $cotizadorkv->listarTarifaIndividual();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Tarifa Individual</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

</head>
<body>

    <!--MENU-->
        <?php include("Template/header_cotizador.php"); ?>
    <?php include("Template/menu_cotizador.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="CotizacionNuevo.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tarifa Individual</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">TARIFA INDIVIDUAL</b>
        </strong>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
    			    <th>NUM</th>
                    <th>CANT PASAJEROS</th>
                    <th>PRECIO BASE</th>
                    <th>VALOR DIA ESPERA</th>
                    <th>VALOR DIA SERVICIO</th>
    				<th style="width: 100px;">OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                <?php foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $lu['id_tarifa'] ?></td>
                        <td><?php echo $lu['cant_pax'] ?></td>
                        <td><?php echo $lu['precio'] ?></td>
                        <td><?php echo $lu['espera'] ?></td>
                        <td><?php echo $lu['servicio'] ?></td>
                        <td>
                            <a href="CotizadorAdminTarifaIndividualEdit.php?id_tarifa=<?php echo base64_encode($lu['id_tarifa']) ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
                                <span class="fa fa-edit"></span>
                            </a>
                        </td>
                </tr>
                <?php } ?>
    		</tbody>
    	</table>
    </div>

</section>
    
    <!-- FIN CONTENIDO -->
  <!-- script -->
  <?php include("Template/scripts.php"); ?>

  
</body>
</html>