<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Area.php");

$areas = new Area();
$listarArea = $areas->listar();
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>SistemaKV | Areas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  

    <!-- STYLES -->

        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

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
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Areas</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-building-o mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ÁREAS</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarAreas.php" id="buttonsKV" class="btn">Registrar Área<i class="fa fa-plus-circle ml-1"></i></a>
            </div>

            <div class="mt-2 mb-3 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>ID</th>
                            <th>NOMBRE DEL AREA</th>
                            <th>EMPRESA</th>
            				<th>ESTADO</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listarArea as $la){ ?>
            				<tr>
            					<td><?php echo $la['id_area']; ?></td>
                                <td><?php echo $la['nombre_area']; ?></td>
                                <td><?php echo $la['nombre_empresa']; ?></td>
            					<td><?php if ($la['estado_area'] == 1) {
                                    echo "Activa";
                                } else  {
                                    echo "Inactiva";
                                }?></td>
            					<td>
                                    <!--Desboquear-->
                                    <?php if ($la['estado_area'] == 0){ ?>
                                        <a href="../Controlador/bloquearDesbloquearArea.php?id_area=<?php echo $la['id_area']; ?>_1" data-toggle="tooltip" data-placement="button" title="Habilitar area" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-check-circle"></span></a>
                                    <?php } elseif ($la['estado_area'] == 1) { ?>
                                        <a href="../Controlador/bloquearDesbloquearArea.php?id_area=<?php echo $la['id_area']; ?>_2" data-toggle="tooltip" data-placement="button" title="Deshabilitar area" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-times-circle"></span></a>
                                     <?php }  ?>

            						<!--Editar-->
            					    <a href="actualizarAreas.php?id_area=<?php echo $la['id_area']; ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
            					</td>
            				</tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>

        </section>
    
    <!-- FIN CONTENIDO -->


    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->


</body>
</html>