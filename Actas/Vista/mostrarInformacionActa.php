<?php
  require_once '../Modelo/Actas.php';
  require_once '../Modelo/Usuarios.php';

  session_start();
  $acta = new Acta();
  $usuario = new Usuario();

  $listarActasPorUsuario = $acta->listarActasPorUsuario($_SESSION['idus']);
  $listarTodosUsuarios = $usuario->listarTodos();
?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>

<body>

  <!-- container section start -->
  <section id="container" class="">

  <?php include('header.php');?>

    <?php include('menu.php');?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

          <!--overview start-->
            <div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-file-text-o"></i>ACTAS</h3>
                
              </div>
            </div>

          <!-- project team & activity start -->
            <div class="row">
              <div class="col-md-12 portlets">
                <!-- Widget -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="pull-left"></div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="panel-body">
                    <header align="right">
                        <a href="formularioActas.php"><button class="btn btn-success">Crear Acta</button></a>
                    </header>
                    <input type="hidden" name="id_acta" id="id_acta" value="<?php echo $_GET['id_acta'] ?>">
                    <section class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                     <th>N° ACTA</th>
                                     <th>TITULO</th>
                                     <th>FECHA REUNIÓN</th>
                                     <th>HORA INICIAL Y FINAL</th>
                                     <th>OPCIONES</th>
                                  </tr>
                              </thead>                             
                              <tbody>
                                <?php foreach ($listarActasPorUsuario as $lau){ ?>
                                  <tr>
                                      <td><?php echo $lau['id_acta']; ?></td>
                                      <td><?php echo $lau['titulo_reunion']; ?></td>
                                      <td><?php echo $lau['fecha_acta']; ?></td>
                                      <td><?php echo "De las " . $lau['hora_inicial_acta'] . ' a las ' . $lau['hora_final_acta'] ?></td>
                                      <td>
                                          <a href='PDF/actas.php?id_acta=<?php echo $lau['id_acta'] ?>' type="button" class="btn btn-success btn-xs"><i class="fa fa-search-plus"></i></a>
                                      </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                          
                    </section>
                  </div>
                </div>
              </div>

        </div>

      </section>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

    <!-- javascripts -->
  <script src="../Recursos/js/jquery.js"></script>
  <script src="../Recursos/js/jquery-ui-1.10.4.min.js"></script>
  <script src="../Recursos/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="../Recursos/js/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="../Recursos/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <!-- bootstrap -->

  <script src="../Recursos/js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="../Recursos/js/jquery.scrollTo.min.js"></script>
  <script src="../Recursos/js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="../Recursos/assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="../Recursos/js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="../Recursos/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="../Recursos/js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <script src="../Recursos/js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="../Recursos/assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="../Recursos/js/calendar-custom.js"></script>
    <script src="../Recursos/js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="../Recursos/js/jquery.customSelect.min.js"></script>
    <script src="../Recursos/assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="../Recursos/js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="../Recursos/js/sparkline-chart.js"></script>
    <script src="../Recursos/js/easy-pie-chart.js"></script>
    <script src="../Recursos/js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../Recursos/js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../Recursos/js/xcharts.min.js"></script>
    <script src="../Recursos/js/jquery.autosize.min.js"></script>
    <script src="../Recursos/js/jquery.placeholder.min.js"></script>
    <script src="../Recursos/js/gdp-data.js"></script>
    <script src="../Recursos/js/morris.min.js"></script>
    <script src="../Recursos/js/sparklines.js"></script>
    <script src="../Recursos/js/charts.js"></script>
    <script src="../Recursos/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript">
        $( function() {
            $( "#fecha_acta" ).datepicker({ dateFormat:'yy/mm/dd'});
        } );

    </script>

</body>

</html>
