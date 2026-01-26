<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Modulo.php");

$modulo = new Modulo();
$listar = $modulo->listar();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Modulos</title>
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

    <!--**************************--->
    
    <!-- CONTENIDO -->
        <section class="home_content"> 

            <div aria-label="breadcrumb" class="mt-1"> 
               <ol class="breadcrumb" style="background-color: #fff;">
                  <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Modulos</li>
               </ol>
            </div>

            <div class="notice notice-sistemakv">
                <strong><i class="fa fa-cubes mr-2" style="font-size: 2rem;"></i><b style="font-size: 1.2rem;">MODULOS</b></strong>
            </div>

            <div class="notice notice-sistemakv">
                <a href="registrarModulos.php" class="btn" id="buttonsKV">registrar modulos <i class="fa fa-plus ml-1"></i></a>
            </div>

            <div class="mt-2 p-4 table-responsive" style="background-color: #fff;">
            	<table id="dataT" class="table table-hover table-sm display text-center" style="width:100%">
            		<thead style="background-color: #1b2d3b; color: #fff;">
            			<tr>
            				<th>NOMBRE</th>
                    <th>ESTADO</th>
            				<th>OPCIONES</th>
            			</tr>
            		</thead>
            		<tbody>
                    <?php foreach ($listar as $lm){ ?>
                        <tr>
                            <td><?php echo $lm['nombre_modulo'] ?></td>
                            <td><?php if ($lm['estado'] == 1) {
                                         echo "Activo";
                                      }else{
                                         echo "Inactivo";
                                      } 
                                ?>
                            </td>
                            <td>
                                <!--Bloquear y Desbloquear-->
                                <?php if ($lm['estado'] == 0){ ?>
                                    <a href="../Controlador/bloquearDesbloquearMod.php?id_modulo=<?php echo $lm['id_modulo']; ?>_1" class="btn btn-outline-success" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-unlock"></span></a>
                                <?php } elseif ($lm['estado'] == 1) { ?>
                                    <a href="../Controlador/bloquearDesbloquearMod.php?id_modulo=<?php echo $lm['id_modulo']; ?>_2" class="btn btn-outline-danger" style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-lock"></span></a>
                                 <?php }  ?>
                                
                                <!--Editar-->
                                <a href="actualizarModulos.php?id_modulo=<?php echo $lm['id_modulo']; ?>" class="btn btn-outline-info"  style="margin: 0px; padding: 0px 4px 0px 4px;"><span class="fa fa-edit"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
            		</tbody>
            	</table>
            </div>

        </section>
    
    <!-- FIN CONTENIDO -->

    <!--**************************--->
    
    <!-- SCRIPT -->
      <?php include("Template/scripts.php"); ?>
    <!--FIN SCRIPT-->

</body>
</html>