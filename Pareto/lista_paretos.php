<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');
$querys = new consultas;
$fecha = date('Y-m-d');
$idpareto = $_GET['id'];
$actividades1 = $querys->actividades($idpareto,'1');
$cant1 = count($actividades1);
$actividades2 = $querys->actividades($idpareto,'2');
$cant2 = count($actividades2);
$actividades3 = $querys->actividades($idpareto,'3');
$cant3 = count($actividades3);
$actividades4 = $querys->actividades($idpareto,'4');
$cant4 = count($actividades4);
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
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Pareto</h3>
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
				 <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <div class="table-responsive">
                <table class="table">
				
                  <thead>
				  <tr><th colspan="5"><b>LLAMADAS</b></th></tr>
                    <tr>
                      <th>#</th>
                      <th>Descripción</th>
					  <th>Fecha</th>
					  <th>Estado</th>
					  <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant1 > 0){ $i = 1; ?>
					 <?php foreach($actividades1 as $act1){?>
                    <tr>
					  
                      <td><?php echo $i;?></td>
                      <td><?php echo $act1['descripcion'];?></td>
					  <td><?php echo $act1['fecha'];?></td>
					  <td><?php echo $act1['estado'];?></td>
                      <td>
					  <?php if ($act1['estado'] == 0){ ?>
						<?php if($act1['novedad'] == ''){ ?>
						<a href="agregar_novedad.php?id=<?php echo $act1['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-primary btn-sm">Novedad No Finalizacion</button>
						</a>
						<?php } else { ?>
						<a href="consultar_novedad.php?id=<?php echo $act1['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-success btn-sm">Novedad</button>
						</a>
						<?php } ?>
					  <?php } ?>
					  </td>
					  
                    </tr>
					<?php $i++; } ?>
					  <?php } else { ?>
					  <tr><td colspan="5" align="center">sin registro de llamadas</td></tr>
					  <?php } ?>
                  </tbody>
                </table>
              </div>
			 
			  <div class="table-responsive">
                <table class="table">
				
                  <thead>
				  <tr><th colspan="5"><b>IMPORTANTES</b></th></tr>
                    <tr>
                      <th>#</th>
                      <th>Descripción</th>
					  <th>Fecha</th>
					  <th>Estado</th>
					  <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant2 > 0){ $i = 1; ?>
					 <?php foreach($actividades2 as $act2){?>
                    <tr>
					  
                      <td><?php echo $i;?></td>
                      <td><?php echo $act2['descripcion'];?></td>
					  <td><?php echo $act2['fecha'];?></td>
					  <td><?php echo $act2['estado'];?></td>
                      <td>
					  <?php if ($act2['estado'] == 0){ ?>
						<?php if($act2['novedad'] == ''){ ?>
						<a href="agregar_novedad.php?id=<?php echo $act2['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-primary btn-sm">Novedad No Finalizacion</button>
						</a>
						<?php } else { ?>
						<a href="consultar_novedad.php?id=<?php echo $act2['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-success btn-sm">Novedad</button>
						</a>
						<?php } ?>
					  <?php } ?>
					  </td>
					  
                    </tr>
					<?php $i++; } ?>
					  <?php } else { ?>
					  <tr><td colspan="5" align="center">sin registro de actividades importantes</td></tr>
					  <?php } ?>
                  </tbody>
                </table>
              </div>
			  
			  <div class="table-responsive">
                <table class="table">
				
                  <thead>
				  <tr><th colspan="5"><b>FUERA DE TIEMPO</b></th></tr>
                    <tr>
                      <th>#</th>
                      <th>Descripción</th>
					  <th>Fecha</th>
					  <th>Estado</th>
					  <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant3 > 0){ $i = 1; ?>
					 <?php foreach($actividades3 as $act3){?>
                    <tr>
					  
                      <td><?php echo $i;?></td>
                      <td><?php echo $act3['descripcion'];?></td>
					  <td><?php echo $act3['fecha'];?></td>
					  <td><?php echo $act3['estado'];?></td>
                      <td>
					  <?php if ($act3['estado'] == 0){ ?>
						<?php if($act3['novedad'] == ''){ ?>
						<a href="agregar_novedad.php?id=<?php echo $act3['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-primary btn-sm">Novedad No Finalizacion</button>
						</a>
						<?php } else { ?>
						<a href="consultar_novedad.php?id=<?php echo $act3['id'];?>&idp=<?php echo $idpareto;?>">
						<button class="btn btn-success btn-sm">Novedad</button>
						</a>
						<?php } ?>
					  <?php } ?>
					  </td>
					  
                    </tr>
					<?php $i++; } ?>
					  <?php } else { ?>
					  <tr><td colspan="5" align="center">sin registro de actividades futuras</td></tr>
					  <?php } ?>
                  </tbody>
                </table>
              </div>
			  
            </section>
          </div>
        </div>
              </div>


            </div>
          </div>

        </div>
        <!-- project team & activity end -->

      </section>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script>

</body>

</html>
