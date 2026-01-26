<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Pais.php");
require_once ("../Modelo/Departamento.php");

$paises = new Pais();
$departamentos = new Departamento();
$listarDepart = $departamentos->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Departamentos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->


</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- *********************************** -->
    
    <!-- CONTENIDO -->
    
        <section class="home_content"> 

            <div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Departamentos</li>
                 </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-map mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">DEPARTAMENTOS</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarDepartamento.php" class="btn" id="buttonsKV">Registrar departamento <i class="fa fa-plus-circle ml-1" style="font-size: "></i></a>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>NOMBRE DEPARTAMENTO</th>
                            <th>PAIS</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
            			<?php foreach ($listarDepart as $la){ ?>
            				<tr>
            					<td><?php echo $la['departamento']; ?></td>
                                <td>
                                    <?php
                                    $nombre_pais = $paises->listarPorId($la['id_pais']);
                                    echo $nombre_pais[0]['pais']; 
                                    ?>
                                </td>    					
            					<td>
                                    

            						<!--Editar-->
            					    <a href="actualizarDepartamento.php?id_departamento=<?php echo $la['id_departamento']; ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar area"   style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
            					</td>
            				</tr>
            			<?php } ?>
            		</tbody>
            	</table>
            </div>

        </section>
    
    <!-- FIN CONTENIDO -->

    <!-- *********************************** -->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->


</body>
</html>