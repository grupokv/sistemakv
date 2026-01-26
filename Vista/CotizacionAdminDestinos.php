<?php 
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$listar = $cotizadorkv->listarDestinos();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Destinos</title>
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
            <li class="breadcrumb-item active" aria-current="page">Destinos</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-build mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">DESTINOS</b>
        </strong>
    </div>
    
    <div class="notice notice-sistemakv">
        <a id="buttonsKV" href="CotizadorAdminDestinosNew.php" class="btn ml-1 mr-1">Nuevo Destino <i class="fa fa-plus-circle ml-1"></i></a>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
    			    <th>NUM</th>
                    <th>NOMBRE SOCIAL</th>
                    <th>KMS</th>
                    <th>DIAS</th>
                    <th>PEAJES</th>
                    <th>ESTADO</th>
    				<th style="width: 100px;">OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                <?php foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $lu['id_destino'] ?></td>
                        <td><?php echo $lu['nombre'] ?></td>
                        <td><?php echo $lu['kms'] ?></td>
                        <td><?php echo $lu['dias_viaje'] ?></td>
                        <td><?php echo $lu['cant_peajes'] ?></td>
                        <td><?php if($lu['estado'] == 1) { echo "ACTIVO"; } else { echo "INACTIVO"; } ?></td>
                        <td>
                            <?php if ($lu['estado'] == 0){ ?>
                                    <a href="../Controlador/bloquearDesbloquearDestinoCotizador.php?id=<?php echo base64_encode($lu['id_destino']); ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                            <?php } else if ($lu['estado'] == 1) { ?>
                                    <a href="../Controlador/bloquearDesbloquearDestinoCotizador.php?id=<?php echo base64_encode($lu['id_destino']); ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                            <?php } ?> 

                            <a href="CotizadorAdminDestinosEdit.php?id_destino=<?php echo base64_encode($lu['id_destino']) ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;">
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