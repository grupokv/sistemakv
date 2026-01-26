<?php 
//include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/InspeccionVehicular.php';
require_once '../Modelo/Usuario.php';

$inspeccion = new InspeccionVehicular();
$usuario = new Usuario();
$listar = $inspeccion->listar();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inspeccion Vehicular</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
  <?php include("Template/styles.php") ?>
  <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  
  <style>

        th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
            padding: 10px;
        }

        #dataT thead {
            background-color: #fff;
        }

        #dataT table {
            font-size: .8rem;
        }

        #dataT tr {
            background-color: #fff;
        }

        #dataT th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
        }

    </style>

</head>
<body>

    
    <!--MENU-->
    <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
    
      <section class="home_content">
           
          <div aria-label="breadcrumb" class="mt-1"> 
              <ol class="breadcrumb" style="background-color: #fff;">
                  <li class="breadcrumb-item" aria-current="page"><a href="inicio.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Inspeccion Vehicular</li>
              </ol>
          </div>

          <div class="notice notice-sistemakv">
              <strong>
                  <i class="fa fa-cars mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">INSPECCIONES VEHICULARES</b>
              </strong>
          </div>

          <div class="notice notice-sistemakv">
              <a href="registrarInspeccionVehiculo.php" class="btn" id="buttonsKV">Registrar Inspeccion<i class="fa fa-plus-circle ml-1"></i></a>
              
              <a href="reportesInspeccionVehicular.php" class="btn btn-outline-success" >Reportes Inspeccion<i class="fa fa-search ml-1"></i></a>
          </div>

          <div class="mt-2 mb-4 table-responsive p-4" style="background-color: #fff; border-radius: 5px;">
              <table id="dataT" class="table table-hover table-sm display" style="width:100%">
                  <thead class="text-center">
                    <tr>
                      <th>ID</th>
                      <th>EMPRESA</th>
                      <th>VEHICULO</th>
                      <th>CONDUCTOR</th>
                      <th>FECHA DE REGISTRO</th>
                      <th>REGISTRADO POR</th>
                      <th>OPCIONES</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php foreach($listar as $ls){ ?>
                    <tr>
                      <td><?php echo $ls['id_inspeccion'];?></td>
                      <td><?php echo $ls['empresa'];?></td>
                      <td><?php echo $ls['placa'];?></td>
                      <td><?php echo $ls['nombre'];?></td>
                      <td><?php echo $ls['fecha_registro'];?></td>
                      <td><?php $datos_usu = $usuario->listarUsuarioPorId($ls['id_usuario_registro']); echo $datos_usu[0]['nombre'];?></td>
                      <td>
                           <a href="consultarInspeccionVehicular.php?id=<?php echo $ls['id_inspeccion']; ?>" class="btn btn-outline-success" target="_blank" style="margin: 0px; padding: 0px 2px 0px 4px;"><span class="fa fa-search"></span></a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
              </table>
          </div>

      </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>

</body>
</html>