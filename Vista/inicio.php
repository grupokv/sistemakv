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

if(($id_usuario != 1868) && ($id_usuario != 2487) && ($_SESSION['id_perfil'] != 11)){

  $busqueda = $salud->buscarPorUsuario($id_usuario,$hoy);
  $cant = count($busqueda);

  if($cant < 0){

      echo "<script>
      window.location.href = 'encuesta_salud.php';
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

$usuariosInicio = [1, 2032];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>SistemaKV | Inicio</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
  <!-- FIN STYLES -->

  <style>

    .cards{
      border: 2px solid #ddd;
    }


    @media(max-width: 768px){

      #card-events{
        height: auto;
      }

      .cards{
        margin-left: 5px;
        margin-right: 5px;
      }

      .cant-notificaciones{
          position: absolute;
          left: 185px;
      }

    }

  </style>
  
</head>
<body>

    
    <!-- STYLES -->
      <?php include("Template/header.php"); ?>
      <?php include("Template/newMenu.php"); ?>
    <!-- FIN STYLES -->

    <!-- ****************************** -->

    <!-- CONTENIDO -->
    <section class="home_content">

        <div class="notice notice-warning">
          <strong>Bienvenid@ <?php echo ucfirst(mb_strtolower($listarUsuarioID[0]['nombre'])); ?></strong> al sistemakv - desde aqui podra administrar las opciones segun su perfil.
        </div>
        
        <?php if (in_array($_SESSION['id_usuario'], $usuariosInicio)){ ?>
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
        <?php } ?>

        <div class="content-cards mt-3 mb-5 p-2" style="background-color: #fff;">
            <section class="row d-flex justify-content-start" style="margin: 0; padding: 5px; background: #eeeeee;">
                <?php foreach ($listarTodos as $ltb){ ?>
                  <?php  
                    $tipo_permiso = $menu->Permisos($id_usuario, $ltb['id_modulo']);
                    $cant_permiso = count($tipo_permiso);
                    if($cant_permiso > 0) {  ?>
                        <?php if ($ltb['id_modulo'] != 0){ ?>
                          <div class="col-lg-3 col-md-3  col-sm-12 col-xs-12 p-3 mt-2 mb-1 cards" style="background-color: #fff; border-radius: 4px;">
                              <div class="box-part text-center">
                                  <i class="fa fa-list-alt fa-3x" aria-hidden="true"></i>
                                  <div class="title">
                                    <h4 style="color: red;"><?php echo $ltb['nombre_modulo'] ?></h4>
                                  </div>         
                                  
                                  <?php if ($ltb['id_modulo'] == 65){ ?>
                                      <?php if (($_SESSION['id_perfil'] == 1)or($_SESSION['id_perfil'] == 5)or($_SESSION['id_perfil'] == 6)){ ?>
                                          <a href="../Vista/preoperacionales.php">Consultar <span class="fa fa-search ml-1"></span></a>
                                      <?php }else{ ?> 
                                          <a href="<?php echo $ltb['link']?>" > Registrar <span class="fa fa-plus ml-1"></span></a>
                                      <?php } ?> 
                                  <?php }else{ ?> 
                                      <a href="<?php echo $ltb['link']?>" > Consultar <span class="fa fa-search ml-1"></span></a>
                                  <?php } ?>  
                              </div>
                          </div>
                        <?php } ?>
                     <?php } ?>
                <?php } ?> 
            </section>
        </div>

    </section>

    <!-- FIN CONTENIDO -->

    <!--***************************-->

  <!-- SCRIPTS -->
  <?php include("Template/scripts.php") ?>
 
</body>
</html>