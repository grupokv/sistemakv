<?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Usuario.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");

$usuario = new Usuario();
$operativo = new Operativo();
$vehiculo = new Vehiculo();

$listarControlMantenimientos = $operativo->listarControlMantenimientos();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Control Mantenimientos</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style type="text/css">
        thead {
            background-color: #fff;
        }

        table {
            font-size: .8rem;
        }

        tr {
            background-color: #fff;
        }

        th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
        }
        
        #contEstado {
            width: 18px;
            height: 22px;
            border-radius: 20%;
            cursor: pointer;
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
    
<section class="home_content">

    <!-- CONTENIDO -->
    <div aria-label="breadcrumb" class="mt-1"> 
        <ol class="breadcrumb" style="background: #fff;">
            <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Control Mantenimientos</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">CONTROL MANTENIMIENTOS</b>
        </strong>
    </div>

    <div class="notice notice-sistemakv">
        <a href="registrarControlMantenimiento.php" class="btn" id="buttonsKV">Registrar Control<i class="fa fa-plus-circle ml-1"></i></a>
        <a href="registrarControlMantenimiento.php" class="btn" id="buttonsKV">Reporte<i class="fa fa- ml-1"></i></a>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display" style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
                    <th>TIPO SERVICIO</th>
                    <th>VEHICULO</th>
                    <th>ENVIADO POR</th>
                    <th>FECHA MTTO.</th>
                    <th>DETALLE MTTO.</th>
    				<th>VALOR MTTO.</th>
    				<th>FORMA DE PAGO</th>
                    <th>OBSERVACIONES</th>
                    <th>ESTADO</th>
    				<th></th>
    				<th></th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                
                <?php foreach ($listarControlMantenimientos as $lcm) { 
	                $listarUsuarioPorId = $usuario->listarUsuarioPorId($lcm['id_usuario_creador']);
	                $listarVehPorId = $vehiculo->listarPorId($lcm['id_vehiculo']);
                ?>
                    <tr>
                        <td><?php echo $lcm['tipo_servicio']; ?></td>
                        <td><?php echo $listarVehPorId[0]['placa'] . ' - ' . $listarVehPorId[0]['numero_movil']; ?></td>
                        <td><?php echo $lcm['enviado_por']; ?></td>
                        <td>
                            <?php
                                $fecha = explode("-", $lcm['fecha_mtto']);
                                echo $fecha[2].' DE '. strtoupper(mes($fecha[1])) .' DEL '. $fecha[0]; 
                            ?>
                        </td>
                        <td><?php echo $lcm['detalle_mtto']; ?></td>
                        <td><?php echo "$ " . number_format($lcm['valor_mtto']); ?></td>
                        <td><?php echo $lcm['forma_pago']; ?></td>
                        <td><?php echo $lcm['observaciones']; ?></td>
                        <td class="d-flex justify-content-center">
                            <?php if ($lcm['estado'] == 1) { ?>
                                <div id="contEstado" style="background: #96f909;" data-bs-toggle="tooltip" data-bs-placement="top" title="EN PROCESO"></div>
                            <?php } else { ?>
                                <div id="contEstado" style="background: #ff0000;" data-bs-toggle="tooltip" data-bs-placement="top" title="FINALIZADO"></div>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="actualizarControlMantenimiento.php?id_mantenimiento=<?php echo $lcm['id_mantenimiento']; ?>" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <i data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo "Creado el: ". strtoupper(date("Y-m-d g:i a", strtotime($ls['fecha_creacion']))) . " - Por: " . $listarUsuarioPorI[0]['nombre'] ?>" style="color: #6e6e6e; font-size:1rem; border-radius:50%; cursor:pointer;" class="fa fa-exclamation-circle"></i>
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