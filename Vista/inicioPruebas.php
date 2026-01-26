<?php 
include("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/SeguimientoActualizacion.php';
require_once '../Modelo/Menu.php';
require_once("../Modelo/Salud.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");

$usuario = new Usuario();
$vehiculo = new Vehiculo();
$conductor = new Conductor();
$contrato = new Contrato();


$id_usuario = $_SESSION['id_usuario'];
$hoy = date('Y-m-d');

$listarUsuarioID = $usuario->listarUsuarioPorId($id_usuario);

$seguimiento = new Seguimiento_Actualizacion();
$listarPorEstadoP = $seguimiento->listarPorEstadoPendientes();

$menu = new Menu();
$salud = new Salud();
$listarTodos = $menu->listarOpcionesBotones();

$totalPendientes = count($listarPorEstadoP);

if($id_usuario != 1868){

  $busqueda = $salud->buscarPorUsuario($id_usuario,$hoy);
  $cant = count($busqueda);

  if($cant < 1){

      echo "<script>
      window.location.href = '../Vista/encuesta_salud.php';
      </script>";
      exit;
  }
}

$listarVehi = $vehiculo->listarActivos();
$cantVehiculos = count($listarVehi);

$listarcond = $conductor->listarConductoresActivos();
$cantConductores = count($listarcond);

$listarcontr = $contrato->listarTodosActivos(date('Y-m-d'));
$cantContratos = count($listarcontr);


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
  <?php include("Template/styles.php") ?>

</head>
<body>

    
    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>


    <section class="home_content">

        <div class="notice notice-warning">
          <strong>Bienvenid@ <?php echo ucfirst(mb_strtolower($listarUsuarioID[0]['nombre'])); ?></strong> al sistemakv - desde aqui podra administrar las opciones segun su perfil.
        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="card-counter primary">
              <!-- <i class="fa fa-code-fork"></i> -->
              <i class="fa fa-car"></i>
              <span class="count-numbers"><?php echo $cantVehiculos; ?></span>
              <span class="count-name">Vehiculos</span>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="card-counter warning">
              <!-- <i class="fa fa-code-fork"></i> -->
              <i class="fa fa-users"></i>
              <span class="count-numbers"><?php echo $cantConductores; ?></span>
              <span class="count-name">Conductores</span>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="card-counter info">
              <!-- <i class="fa fa-code-fork"></i> -->
              <i class="fa fa-file-text-o"></i>
              <span class="count-numbers"><?php echo $cantContratos; ?></span>
              <span class="count-name">Contratos</span>
            </div>
          </div>

        </div>

    </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
</body>
</html>