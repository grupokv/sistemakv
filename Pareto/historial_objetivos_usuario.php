<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');
$querys = new consultas;

$contenido1=$querys->obj_general($_POST['usuario']);
$cant1 = count($contenido1);
$contenido=$querys->obj_especificos($_POST['usuario']);
$cant = count($contenido);
?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>
<script>
function valor(id,campo){
	if(document.getElementById(campo).checked==true){
		var parametros = {
                "id" : id,
				"estado" : 1
        };
		$.ajax({
                data:  parametros,
                url:   'act_proxima_alerta.php',
                type:  'post',
                beforeSend: function () {
                        //$("#semana").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					//alert(response);
                    //$("#semana").html(response);
					location.reload();
                }
        });
	}
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
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Objetivos Usuario</h3>
           </div>
        </div>

        <!-- project team & activity start -->
        <div class="row">
          <div class="col-md-12 portlets">
            <!-- Widget -->
            <div class="panel panel-default">
              <div class="panel-heading">
			  
                 OBJETIVO GENERAL
                <div class="pull-left"></div>
                <div class="clearfix"></div>
              </div>

              <div class="panel-body">
				 <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header align="right">
              </header>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Descripción</th>
					  
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant1 > 0){ $i1 = 1; ?>
					 <?php foreach($contenido1 as $cont1){?>
                    <tr>
					  
                      <td><?php echo $i1;?></td>
                      <td><?php echo $cont1['descripcion'];?></td>
					  
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
			
			<div class="panel panel-default">
              <div class="panel-heading">
			  
                 OBJETIVOS ESPECIFICOS
                <div class="pull-left"></div>
                <div class="clearfix"></div>
              </div>

              <div class="panel-body">
				 <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header align="right">
              </header>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Descripción</th>
					  <th>Cuantificador</th>
					  <th>Forma Presentacion</th>
					  <th>Fecha Presentacion</th>
					  <th>Proxima Presentacion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
					<?php if ($cant > 0){ $i = 1; ?>
					 <?php foreach($contenido as $cont){?>
                    <tr>
					  
                      <td><?php echo $i;?></td>
                      <td><?php echo $cont['descripcion'];?></td>
					  <td><?php echo $cont['cuantificador'];?></td>
					  <td>
						<?php
						$evidencia = $querys->evidenciaid($cont['forma_presentacion']);
						echo $evidencia[0]['nombre'];
						?>
					  </td>
					  <td>
						<?php 
						if($cont['continuidad'] == 1){
							$dia = $querys->diasemana($cont['fecha_presentacion']);
							echo $dia.' de cada semana';
						} else {
							echo $cont['fecha_presentacion'].' de cada mes';	
						}
						?>
					  </td>
					  <td><?php echo $cont['proxima_alerta'];?></td>
                      <td>
						<label class="switch">
							<input type="checkbox" value="<?php echo $cont['id'];?>" id="<?php echo $cont['id'];?>" 
							onclick="valor(this.value,this.id)" <?php if ($cont['estado_presentacion'] == 1){ ?> checked="checked" <?php } ?> >
							<span class="slider round"></span>
						</label>
					  </td>
					  
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

</body>

</html>
