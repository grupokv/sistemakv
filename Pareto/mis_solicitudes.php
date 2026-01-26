<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');
$querys = new consultas;
$contenido=$querys->invitacionestodas2($_SESSION['idus']);
$cant =  count($contenido);
?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>
<script>
function modal(id){
	$('.modal-body').load('contenido_modal_invitacion.php?id='+id,function(){
		$('#myModal').modal({show:true});
	});
}
</script>
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
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Invitaciones</h3>
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
              <header align="right">
				<a href="invitaciones.php"><button class="btn btn-primary">Invitaciones</button></a>
              </header>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Fecha</th>
					  <th>Cant. Invitados</th>
					  <th>Invitados</th>
					  <th>Detalle</th>
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant > 0){ $i = 1; ?>
					 <?php foreach($contenido as $cont){?>
                    <tr>
					  
                      <td><?php echo $i;?></td>
					  <td><?php $actividad = $querys->actividad_id2($cont['id_actividad']); echo $actividad[0]['fecha'];?></td>
					  <td>
						<?php
						$invitados = $querys->invitacion_actividad($cont['id_actividad']);
						echo $cantact = count($invitados);
						?>
					  </td>
                      <td>
							<button type="button" class="btn btn-success btn-xs" onclick="modal('<?php echo $cont["id_actividad"];?>')"><b>Ver Invitados</b></button>
					  </td>
					  <td><?php echo $actividad[0]['descripcion'];?></td>
					</tr>
					<?php $i++; } ?>
					  <?php } else { ?>
					  <tr><td colspan="6" align="center">sin registro</td></tr>
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

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" onclick="location.reload();">×</button>
					<h4 class="modal-title">INVITADOS</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">CERRAR</button>
				</div>
			</div>
		</div>
	</div>
	
</body>

</html>
