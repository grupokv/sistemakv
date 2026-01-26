<?php 
    include("../Controlador/Sesion/autenticar.php");
    require_once '../Modelo/Pre-operacionales.php';
    require_once '../Modelo/Usuario.php';
    require_once '../Modelo/Vehiculo.php';
    require_once '../Modelo/Conductor.php';

    $preoperacionales = new PreOperacionales();
    $usuario = new Usuario();
    $vehiculo = new Vehiculo();
    $conductor = new Conductor();

    $id_usuario = $_SESSION['id_usuario'];
    $listarUsuarioPorId = $usuario->listarUsuarioPorId($id_usuario);
    print_r($listarUsuarioPorId);

    $buscarConductorPorDocumento = $conductor->buscarConductorPorDocumento($listarUsuarioPorId[0]['numero_documento_conductor']);

    $listarPorConductor = $preoperacionales->listarPorConductor($buscarConductorPorDocumento[0]['id_conductor']);
    print_r($listarPorConductor);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Historial Preoperacionales</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- STYLES -->
        <?php include("Template/styles.php") ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!-- FIN STYLES -->

</head>

    <!--MENU-->
        <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->

    <!-- CONTENIDO -->

        <section class="home_content">

            <div aria-label="breadcrumb" class="mt-1">
                <ol class="breadcrumb" style="background: #fff;">
                    <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pre-operacionales</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">HISTORIAL DE PREOPERACIONALES Y DESINFECCIÓN</b></strong>
            </div>

            <div class="mt-2 p-4 table-responsive" id="servicios" style="background-color: #fff;">
                <table id="data" class="table table-hover table-sm display text-center" style="width:100%">
                    <thead style="background-color: #1b2d3b; color: #fff;">
                        <tr>
                            <th>ID</th>
                            <th>VEHICULO</th>
                            <th>USUARIO DE REGISTRO</th>
        				            <th>FECHA CREACIÓN</th>
        				            <th>OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($listarPreoperacionales as $lp){ ?>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>

      </section>

    <!-- FIN CONTENIDO -->
                 
    
    <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
 
</body>
</html>
