<?php 
    include("../Controlador/Sesion/autenticar.php");
    require_once '../Modelo/Administracion.php';
    require_once '../Modelo/Usuario.php';

    $administracion = new Administracion();
    $listarPermisosModVehiculos = $administracion->listarPermisosModVehiculos();

    $usuario = new Usuario();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SistemaKV | Permisos Usuarios</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Permisos Usuarios</li>
                </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong>
                    <i class="fa fa-gears mr-3" style="font-size: 2rem;"></i>
                    <b style="font-size:1.3rem;">PERMISOS MODULO VEHÍCULOS</b>
                </strong>
            </div>

            <!-- <div style="width: 100%; height: auto; padding: 5px; background-color: #fff; border-radius: 10px;">
                <a href="asignarPermisosUsuariosOperativo.php" class="btn btn-outline-info" id="buttonsKV"
                    style="border-radius: 10px;">Asignar Permisos <i class="fa fa-plus-circle ml-1"></i></a>
            </div> -->

            <div class="mt-2 p-4 table-responsive" style="background: #fff; border-radius: 5px;">
                <table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
                    <thead style="background-color: #1b2d3b; color: #fff;">
                        <tr>
                            <th style="vertical-align: top;">ID</th>
                            <th style="vertical-align: top;">USUARIO</th>
                            <th style="vertical-align: top;">PERFIL</th>
                            <th style="vertical-align: top;">TIPO DE CONSULTA</th>
                            <th style="vertical-align: top;">FECHA ASIGNACIÓN</th>
                            <th style="vertical-align: top;">ASIGNADO POR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listarPermisosModVehiculos as $lpmv){ 
                            
                            $listarUsuarioPorId = $usuario->listarUsuarioPorId($lpmv['id_usuario']);
                            $listarUsuarioAsignadorPorId = $usuario->listarUsuarioPorId($lpmv['id_usuario_asignacion']); ?>

                            <tr>
                                <td><?php echo str_pad($lpmv['id'], 5, "0", STR_PAD_LEFT) ?></td>
                                <td><?php echo $listarUsuarioPorId[0]['nombre'] ?></td>
                                <td><?php echo $lpmv['perfil']; ?></td>
                                <td><?php echo $lpmv['tipo_consulta']; ?></td>
                                <td><?php echo $lpmv['fecha_asignacion']; ?></td>
                                <td><?php echo $listarUsuarioAsignadorPorId[0]['nombre'] ?></td>
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
