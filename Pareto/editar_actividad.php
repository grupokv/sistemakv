<?php
session_start();
if (($_SESSION['user'] == '')or($_SESSION['pass'] == '')){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.location.href='index.php';
	</SCRIPT>");
}
require('bd/datos.php');

$id = $_GET['id'];
$querys = new consultas;

$contenidoid=$querys->actividad_id($_SESSION['idus'],$id);
$tipos = $querys->tiposact();

if($_POST){
	$id = $_POST['id'];
	$idusuario = $_SESSION['idus'];
	$descripc = $_POST['descripcion'];
	$tipo = $_POST['tipo'];
	$fecha = $_POST['fechap'];
	$horai = $_POST['horai'];
	$horaf = $_POST['horaf'];
	
	$hoy = date('Y-m-d H:i:s');
	$sql = "update pareto_actividades set descripcion = '$descripc', id_tipoactividad = '$tipo', fecha='$fecha', fecha_fin='$fecha', hora = '$horai', hora_fin = '$horaf', fecha_modificacion = '$hoy' where id = '$id'";
	$insert = new base_datos;
	$insert->connect();
	$insert->query($sql);
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	alert('Actividad Editada Correctamente');
	window.location.href='pareto_activo.php';
	</SCRIPT>");
}
$fecha = date("Y-m-d"); 
$rangomin = (30 * 60);//cantidad minutos * 60 segundos;
$timestamp = strtotime($fecha.' 00:00:00')-$rangomin; 
$timestamp_limite = strtotime($fecha.' 23:30:00'); 
?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- date picker -->
  
  <script>
  $(document).ready(function() {
  $(function() {
    $('#fechap').datepicker({
      dateFormat: 'yy-mm-dd',
      showButtonPanel: false,
      changeMonth: true,
      changeYear: true,
      minDate: '-0D',
      inline: true
    });
  });
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);
});
</script>
<script>
function rangohora(hora){
	//alert(hora);
	var parametros = {
			"hora" : hora
	};
	$.ajax({
			data:  parametros,
			url:   'select_horas.php',
			type:  'post',
			beforeSend: function () {
					$("#horaf").html("Procesando, espere por favor...");
			},
			success:  function (response) {
				//alert(response);
					$("#horaf").html(response);
			}
	});
}
function rangohoraedit(hora1,hora2){
	//alert(hora);
	var parametros = {
			"hora1" : hora1,
			"hora2" : hora2
	};
	$.ajax({
			data:  parametros,
			url:   'select_horas_edit.php',
			type:  'post',
			beforeSend: function () {
					$("#horaf").html("Procesando, espere por favor...");
			},
			success:  function (response) {
				//alert(response);
					$("#horaf").html(response);
			}
	});
}
</script>
<body onload="rangohoraedit('<?php echo $contenidoid[0]['hora'];?>','<?php echo $contenidoid[0]['hora_fin'];?>')">
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
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Editar Actividad</h3>
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
					<input type="hidden" value="<?php echo $id;?>" name="id"/>
                    <div class="form-group ">
                      <label for="descripcion" class="control-label col-lg-2">Descripcion <span class="required"></span></label>
                      <div class="col-lg-10">
                        <input class="form-control"  type="text" name="descripcion" id="descripcion" value="<?php echo $contenidoid[0]['descripcion'];?>" required />
					  </div>
                    </div>
                    
					<div class="form-group ">
                      <label for="forma" class="control-label col-lg-2">Tipo Actividad <span class="required"></span></label>
                      <div class="col-lg-10">
					  <select name="tipo" id="tipo" required class="form-control">
                        <?php foreach ($tipos as $tp){?>
							 
							<option value="<?php echo $tp['id'];?>" <?php if ($contenidoid[0]['id_tipoactividad'] == $tp['id']){ ?> selected="selected" <?php } ?> >
							<?php echo $tp['detalle'];?>
							</option>
							
						<?php } ?>
						</select>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="cuantificador" class="control-label col-lg-2">Fecha <span class="required"></span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="fechap" name="fechap" type="text" required value="<?php echo $contenidoid[0]['fecha'];?>"/>
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="horai" class="control-label col-lg-2">Hora Inicio <span class="required">*</span></label>
                      <div class="col-lg-10">
						<select name="horai" id="horai" class=" form-control" required onchange="rangohora(this.value)" >
						<option value="">SELECCIONE HORA DE INICIO</option>
						<?php			
						$timestamp1 = strtotime($fecha.' 00:00:00')-$rangomin; 
						$timestamp_limite1 = strtotime($fecha.' 23:30:00'); 
						while ($timestamp < $timestamp_limite){
							$timestamp += $rangomin; 
							$hora1 = strtoupper(date("H:i:s", $timestamp));
							$hora2 = strtoupper(date("h:i a", $timestamp));
							if($hora1 == $contenidoid[0]['hora']){
								echo "<option value=".$hora1." selected='selected'>".$hora2."</option>";
							} else {
								echo "<option value=".$hora1.">".$hora2."</option>"; 
							}
						} 
						?>
						</select>
                        
                      </div>
                    </div>
					<div class="form-group ">
                      <label for="horaf" class="control-label col-lg-2">Hora Fin <span class="required">*</span></label>
                      <div class="col-lg-10">
						<select name="horaf" id="horaf" class=" form-control" required></select>
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
