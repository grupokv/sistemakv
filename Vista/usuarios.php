<?php 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cargo.php");

$usuario = new Usuario();
$listar = $usuario->listar();

$cargo = new Cargo();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Usuarios</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- styles -->
  <?php include("Template/styles.php") ?>

  <link rel="stylesheet" href="../Resources/fontawesome-free-5.11.2-web/css/fontawesome.css">
  <link rel="stylesheet" href="../Resources/fontawesome-free-5.11.2-web/css/brands.css">
  <link rel="stylesheet" href="../Resources/fontawesome-free-5.11.2-web/css/solid.css">
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

  <style type="text/css">
  </style>

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
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </div>

    <div class="notice notice-sistemakv">
        <strong>
            <i class="fa fa-users mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">USUARIOS</b>
        </strong>
    </div>

    <div class="notice notice-sistemakv">
        <a href="registrarUsuarios.php" class="btn" id="buttonsKV">Ingresar Usuario<i class="fa fa-plus-circle ml-1"></i></a>
    </div>

    <div class="mt-2 mb-5 p-4 table-responsive" style="background-color: #fff;">
    	<table id="dataT" class="table table-hover table-sm display tablesaw tablesaw-columntoggle" data-tablesaw-mode="columntoggle" data-tablesaw style="width:100%">
    		<thead class="text-center" style="background-color: #1b2d3b; color: #fff;">
    			<tr>
                    <th>NOMBRE USUARIO</th>
                    <th>CORREO ELECTRONICO</th>
                    <th>USUARIO</th>
                    <th>CARGO</th>
    				<th>PERFIL</th>
                    <th>ESTADO</th>
    				<th style="width: 100px;">OPCIONES</th>
    			</tr>
    		</thead>
    		<tbody class="text-center">
                <?php foreach ($listar as $lu){ ?>
                    <tr>
                        <td><?php echo $lu['nombre'] ?></td>
                        <td><?php echo $lu['correo_electronico'] ?></td>
                        <td><?php echo $lu['usuario'] ?></td>
                        <td><?php 
                            if($lu['id_cargo'] == '0'){
                                echo 'N/A';
                            } else {
                                $nombrecargo = $cargo->listarCargosPorId($lu['id_cargo']);
                                echo $nombrecargo[0]['nombre_cargo'];
                            }
                            ?>
                        </td>
                        <td><?php echo $lu['nombre_perfil'] ?></td>
                        <td><?php if ($lu['estado'] == 1) {
                                        echo "Activo";
                                }else{
                                        echo "Inactivo";
                                } ?>
                                    
                        </td>
                        <td>
                            <!--Bloquear y Desboquear-->
                            <?php if ($lu['estado'] == 0){ ?>
                                <a href="../Controlador/bloquearDesbloquearUsuario.php?id_usuario=<?php echo $lu['id_usuario']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                            <?php } elseif ($lu['estado'] == 1) { ?>
                                <a href="../Controlador/bloquearDesbloquearUsuario.php?id_usuario=<?php echo $lu['id_usuario']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fas fa-user-lock"></i></a>
                             <?php }  ?>

                            <!-- ACTUALIZAR -->
                            <a href="actualizarUsuarios.php?id_usuario=<?php echo $lu['id_usuario'] ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fas fa-user-edit"></i></a>

                            <!-- PERMISOS -->
                            <a href="../Vista/actualizarRoles.php?us=<?php echo $lu['id_usuario'] ?>" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><i class="fas fa-dice-d20"></i></a>
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