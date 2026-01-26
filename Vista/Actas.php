<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Actas.php");
require_once ("../Modelo/Usuario.php");

$acta = new Acta();
$listarActa = $acta->listarActas();

$usuario = new Usuario();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Actas</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

        <style>

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

        </style>
    <!-- FIN STYLES -->

</head>
<body>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!-- ************************** --->
    
    <!-- CONTENIDO -->

        <section class="home_content">

            <div aria-label="breadcrumb" class="mt-1"> 
                 <ol class="breadcrumb" style="background-color: #FFF;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actas</li>
                 </ol>
            </div>

            <hr style="border:2px solid #fff;">

            <div class="notice notice-sistemakv mt-1">
                <strong><i class="fa fa-file-text mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">ACTAS</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarActas.php" class="btn" id="buttonsKV">Nueva Acta<i class="fa fa-plus-circle ml-1"></i></a>
            </div>

            <div class="mt-2 p-4 table-responsive mb-4" style="background-color: #fff;">
                <table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
                    <thead style="background-color: #1b2d3b; color: #fff; text-align:center;">
                        <tr>
                            <th style="vertical-align: top;">ID</th>
                            <th style="vertical-align: top;">NOMBRE ACTA</th>
                            <th style="vertical-align: top;">FECHA INICIAL</th>
                            <th style="vertical-align: top;">FECHA FINAL</th>
                            <th style="vertical-align: top;">FECHA CREACIÓN</th>
                            <th style="vertical-align: top;">CREADA POR</th>
                            <th style="vertical-align: top;">OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($listarActa as $la){  ?>
                                <tr>   
                                    <td><?php echo $la['id_acta']; ?></td>
                                    <td><?php echo $la['nombre_acta']; ?></td>
                                    <td><?php echo strtoupper($la['fecha_reunion'] . ' - ' . date('g:i a', strtotime($la['hora_inicial_acta']))); ?></td>
                                    <td><?php echo strtoupper($la['fecha_reunion'] . ' - ' . date('g:i a', strtotime($la['hora_final_acta']))); ?></td>
                                    <td><?php echo date('Y-m-d g:i a', strtotime($la['fecha_hora_creacion'])); ?></td>
                                    <td>
                                        <?php 
                                            $listarUsuariosId = $usuario->listarUsuarioPorId($la['id_responsable']); 
                                            echo $listarUsuariosId[0]['nombre'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php if (($_SESSION['id_usuario'] == $la['id_responsable'])or($_SESSION['id_usuario'] == 2)) { ?>
                                            <!--Editar-->
                                            <a href="actualizarActas.php?id_acta=<?php echo $la['id_acta']; ?>" class="btn btn-outline-info" data-toggle="tooltip" data-placement="button" title="editar acta"   style="margin: 0px; padding: 0px 2px 0px 4px;"><span class="fa fa-edit"></span></a>
                                            <a href="actualizarEstadoSituacionActa.php?id_acta=<?php echo $la['id_acta']; ?>" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="button" title="editar estado situacion" style="margin: 0px; padding: 0px 2px 0px 4px;"><span class="fa fa-pencil-square-o"></span></a>
                                        <?php } ?>
                                        
                                        <!--Consultar-->
                                        <a href="PDF/actas.php?id_acta=<?php echo $la['id_acta']; ?>" class="btn btn-outline-success" target="_blank" style="margin: 0px; padding: 0px 2px 0px 4px;"><span class="fa fa-search"></span></a>

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