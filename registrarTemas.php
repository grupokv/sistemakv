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
                <h3 class="page-header"><i class="fa fa-file-text-o"></i> REGISTRAR ACTA - TEMA</h3>
                
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
                        <button class="btn btn-primary" id="btnAdd" style="margin: 0px; padding: 0px 4px 0px 4px;" onclick="duplicar()"><strong>Agregar <span class="fa fa-plus"></span></strong></button>

                        <button class="btn btn-danger" id="btnDelete" style="margin: 0px; padding: 0px 4px 0px 4px; display: none; margin-left: 5px; " onclick="eliminar()"><strong>Eliminar <span class="fa fa-trash-o"></span></strong></button>
                    </header>
                        <form action="../Controlador/registrarTemasActas.php" method="POST">
                          <input type="hidden" name="id_acta" id="id_acta" value="<?php echo $_GET['id_acta'] ?>">
                          <div class="row contenedor mt-3" id="contenedor">
                              <div  class="col-md-12" id="duplicar">
                                <section class="row mt-2"  style="margin-top: 15px; margin-left: 70px;">
                                    <div class="col-md-2">
                                        <label>Tema a tratar</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="tema[]" id="tema" class="form-control">
                                    </div>          
                                </section>

                                <section class="row mt-2"  style="margin-top: 15px; margin-left: 70px;">
                                      <div class="col-md-2">
                                        <label>Descripcion</label>
                                      </div>
                                      <div class="col-md-4">
                                           <textarea name="descripcion[]" id="descripcion" class="form-control"></textarea>
                                      </div>
                                      <div class="col-md-2" id="opciones">
                                      
                                      </div> 

                                </section>
                                      <hr>
                              </div>
                          </div>

                          <section class="col-md-12" style="display: flex; justify-content: flex-end; margin-top: 10px;">
                                <button type="submit" class="btn btn-success">Siguiente</button>
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

          num = 1;
        function duplicar(){

            var clon = $('#duplicar').clone();
            clon.attr("id", 'duplicar' + '_' + num);
            $('#contenedor').append(clon);

            if (num > 0) {
              /*Colocar el boton visible*/  
              document.getElementById('btnDelete').style.display = 'flex';
              document.getElementById('btnDelete').style.float = 'right';

            }
            num++;
        }


        function eliminar(){
            
            document.getElementById('duplicar_' + (num - 1)).remove();
            num--;    

            if (num == 1){
              document.getElementById('btnDelete').style.display = 'none';

            }
        }
    </script>

</body>

</html>
