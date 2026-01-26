<?php 
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require("../Modelo/CotizadorKV.php");

$cotizadorkv = new CotizadorKV();

$listar = $cotizadorkv->listar_cotizaciones();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Cotizaciones</title>
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
            <li class="breadcrumb-item active" aria-current="page">Cotizaciones</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-list mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">COTIZACIONES</b>
        </strong>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
    			    <th>NUM</th>
                    <th>CLIENTE</th>
                    <th>DESTINO</th>
                    <th>VALOR FINAL</th>
                    <th>ASESOR</th>
                    <th>EMPRESA</th>
    				<th style="width: 100px;">OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                <?php foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $lu['id_cotizacion'] ?></td>
                        <td><?php echo $lu['nombre_cliente'] ?></td>
                        <td><?php echo $lu['destino'] ?></td>
                        <td><?php echo $lu['valor_final'] ?></td>
                        <td><?php $datos_asesor =  $cotizadorkv->listar_usuario_id($lu['id_creador']); echo $datos_asesor[0]['nombre']; ?></td>
                        <td><?php $datos_emp = $cotizadorkv->listarEmpresaPorId($lu['id_empresa']); echo $datos_emp[0]['razon_social']; ?></td>
                        <td>
                            <!-- VER  COTIZACION -->
                            <a href="verCotizacionKV.php?id=<?php echo base64_encode($lu['id_cotizacion']); ?>" target="_blank" class="btn btn-outline-info" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fa fa-search"></i></a>
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