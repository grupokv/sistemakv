<?php
  require_once '../Modelo/Usuarios.php';

  $usuario = new Usuario();
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
                <h3 class="page-header"><i class="fa fa-file-text-o"></i> REGISTRAR ACTA - INFORMACIÓN DEL ACTA</h3>
                
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
                    <section>
                        <form action="../Controlador/registrar_acta.php" method="POST" onsubmit="return validar()">

                            <section class="row mt-2"  style="margin-top: 15px; margin-left: 70px;">
                                <div class="col-md-2">
                                    <label>Titulo del acta (Reunión)</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="titulo_reunion" id="titulo_reunion" class="form-control"  onkeypress="validar()">
                                </div>                      
                            </section>

                            <section class="row mt-2"  style="margin-top: 15px; margin-left: 70px;">
                                  <div class="col-md-2">
                                    <label>Fecha de la reunión</label>
                                  </div>
                                  <div class="col-md-3">
                                       <input type="date" name="fecha_acta" id="fecha_acta" class="form-control" onchange ="validar()">
                                  </div>
                            </section>

                            <section class="row" style="margin-top: 20px; margin-left: 70px;">
                                    <div class="col-md-2">
                                        <label>Hora Inicial de la reunión</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="hora_inicial_acta" id="hora_inicial_acta" class="form-control"  onchange="validar()">
                                    </div>
                            </section>
                            <section class="row" style="margin-top: 20px; margin-left: 70px;">
                                    <div class="col-md-2">
                                        <label>Fecha de la reunión</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="hora_final_acta" id="hora_final_acta" class="form-control" onchange="validar()">
                                    </div>
                            </section>
                            <section class="col-md-12" style="display: flex; justify-content: flex-end; margin-top: 10px;">
                               <button type="submit" id="guardar" disabled="disabled" class="btn btn-success">Siguiente <span class="fa fa-arrow-right"></span></button>
                            </section>
                    </section>
 
                    </form>
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
       function validar(){

                var titulo_reunion = document.getElementById('titulo_reunion').value;
                var fecha_acta = document.getElementById('fecha_acta').value;
                var hora_inicial_acta = document.getElementById('hora_inicial_acta').value;
                var hora_final_acta = document.getElementById('hora_final_acta').value;


                if ((titulo_reunion == '') || (fecha_acta == '') || (hora_inicial_acta == '') || (hora_final_acta == '')) {
                    document.getElementById('guardar').disabled = true;
                }else{
                    document.getElementById('guardar').disabled = false;
                }/*
          
                document.getElementById('guardar').innerHTML = 'Por favor espere';
                document.getElementById('guardar').disabled = true;

          return true;*/
        }
    </script>
</body>

</html>
