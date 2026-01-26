<?php 
require_once ("../Modelo/Rol.php");

$rol = new Rol();
$listarPorIdModulo = $rol->listarPorIdModulo($_SESSION['id_usuario'], 0);

?>

<header class="header">
  <div class="toggle-nav">
      <div class="icon-reorder tooltips" data-original-title="Menu" data-placement="bottom" id="btn_menu">
          <i  class="fa fa-bars"></i>
      </div>
  </div>

<!--logo start-->
<a href="inicio.php" class="logo">SISTEMA <span class="lite">KV</span></a>

  <?php if (count($listarPorIdModulo) > 0){ ?>
    
    <div class="top-nav notification-row">
        <ul class="nav pull-right top-menu">

            <!-- NOTIFICACIONES -->
            <li id="notification_bar" class="dropdown">

              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-bell-o"></i>
                  <span class="badge" style="background: #00a0df;"><i class="fa fa-exclamation"></i></span>
              </a>

            </li>

            <!-- DOC VEHICULOS -->
            <li id="notification_bar" class="dropdown">

              <a data-toggle="dropdown" class="dropdown-toggle" href="notificacionesDocsVencidos.php">
                <i class="fa fa-car"></i>
                  <span class="badge" style="background: #de1d1d;"><i class="fa fa-exclamation"></i></span>
              </a>

            </li>

        </ul>
    </div>
  
  <?php } ?>
</header>
