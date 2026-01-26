<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
$id = $_GET['id'];
require('bd/datos.php');
$querys = new consultas;
$fecha = date('Y-m-d');

$info = $querys->usuarioid($id);

if($_SESSION['perfil'] == 1){ 
	$cargos=$querys->cargos();
	$perfiles = $querys->perfiles();
} else {
	$cargos=$querys->cargosarea($_SESSION['area']);
	$perfiles = $querys->perfilesarea();
}

if($_POST){
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$num = $_POST['cedula'];
	$cargo = $_POST['cargo'];
	$perfil = $_POST['perfil'];
	$pass = $_POST['password'];
	
	$hoy = date('Y-m-d H:i:s');
	$sql = "update usuario set nombre = '$nombre', cedula = '$num', password = '$pass', id_cargo = '$cargo', id_perfil = '$perfil' where id = '$id'";
	$insert = new base_datos;
	$insert->connect();
	$insert->query($sql);
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	alert('Usuario Editado Correctamente');
	window.location.href='usuarios.php';
	</SCRIPT>");
}
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
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Editar Usuario</h3>
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
                <div class="form">
                  <form class="form-validate form-horizontal " id="register_form" method="post" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
					<div class="form-group ">
                      <label for="nombre" class="control-label col-lg-2">Nombre <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="nombre" name="nombre" type="text" required value="<?php echo $info[0]['nombre'];?>"/>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="cedula" class="control-label col-lg-2">Usuario <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="cedula" name="cedula" type="text" required  value="<?php echo $info[0]['cedula'];?>"/>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="password" class="control-label col-lg-2">Password <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="password" name="password" type="password" required  value="<?php echo $info[0]['password'];?>"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="tipo" class="control-label col-lg-2">Cargo <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="cargo" name="cargo" required >
							<?php foreach ($cargos as $tp){?>
								<option value="<?php echo $tp['id'];?>" <?php if ($info[0]['id_cargo'] == $tp['id']){ ?> selected="selected" <?php } ?> > 
								<?php echo $tp['nombre'];?>
								</option>
							<?php } ?>
						</select>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="tipo" class="control-label col-lg-2">Perfil <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class=" form-control" id="perfil" name="perfil" required >
							<?php foreach ($perfiles as $tp1){?>
							<option value="<?php echo $tp1['id'];?>" <?php if ($info[0]['id_perfil'] == $tp1['id']){ ?> selected="selected" <?php } ?>>
							<?php echo $tp1['nombre'];?>
							</option>
							<?php } ?>
						</select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button class="btn btn-default" type="button" onclick="window.history.go(-1); return false;">Cancelar</button>
                      </div>
                    </div>
                  </form>
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
