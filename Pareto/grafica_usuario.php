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

$usuario = $_POST['usuario'];
$tipografica = $_POST['tiporeporte'];
if ($tipografica == 1){
	$tipo = 'SEMANAL';
	$opc = explode('|',$_POST["semana"]);
	$texto = 'Periodico: '.$opc[1].' a '.$opc[2] ;
	$semana = $opc[0];
} else if ($tipografica == 2){
	$tipo = 'MENSUAL';
	$opc = explode('|',$_POST["mes"]);
	$texto = 'Mes: '.$opc[0].' Año:'.$opc[1];
	$mes = $opc[0];
	$anno = $opc[1];
} else if ($tipografica == 3){
	$tipo = 'ANUAL';
	$texto = 'Año: '.$_POST['anno'];
	$anno = $_POST['anno'];
}

$usuarioid = $querys->usuarioid($usuario);
$nombreusuario = $usuarioid[0]['nombre'];

?>
<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>

<script src="grafica/amcharts/amcharts.js" type="text/javascript"></script>
<script src="grafica/amcharts/pie.js" type="text/javascript"></script>
<script src="grafica/amcharts/serial.js" type="text/javascript"></script>
<?php if ($tipografica == 1){ ?>
<?php
$actividades = $querys->actividadestodas($semana);
$cant1 = count($actividades);
$completas = $querys->actividadescompletas($semana,'1');
$cant2 = count($completas);
$restantes = ($cant1 - $cant2);
$texto2 = 'Total de actividades: '.$cant1;
?>
<script>
var chart;
var legend;
var chartData = [
                {
                    "country": "Finalizados",
                    "value": <?php echo $cant2;?>
                },
                {
                    "country": "Pendientes",
                    "value": <?php echo $restantes;?>
                },
            ];

AmCharts.ready(function () {
	// PIE CHART
	chart = new AmCharts.AmPieChart();
	chart.dataProvider = chartData;
	chart.titleField = "country";
	chart.valueField = "value";
	chart.outlineColor = "#FFFFFF";
	chart.outlineAlpha = 0.8;
	chart.outlineThickness = 2;
	chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
	// this makes the chart 3D
	chart.depth3D = 15;
	chart.angle = 30;
	// WRITE
	chart.write("chartdiv");
});
</script>
<?php } ?>
<?php if ($tipografica == 2){ ?>
<?php
$paretosmes = $querys->paretosmes($mes,$anno,$usuario);
$cant = count($paretosmes);
$texto2 = 'Total de paretos: '.$cant;
?>
<script>
var chart;
var chartData = [
	<?php foreach($paretosmes as $pmes){ ?>
	<?php
	$idpareto = $pmes['id'];
	$cant1 = 0;
	$cant2 = 0;
	$actividades = $querys->actividadestodas($idpareto);
	$cant1 = count($actividades);
	$completas = $querys->actividadescompletas($idpareto,'1');
	$cant2 = count($completas);
	$restantes = ($cant1 - $cant2);
	?>
	{
		"semana": "<?php echo $pmes['fecha_inicial'].' / '.$pmes['fecha_final'];?>",
		"finalizadas": <?php echo $cant2;?>,
		"pendientes": <?php echo $restantes;?>,
	},
	<?php } ?>
];

AmCharts.ready(function () {
	// SERIALL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	chart.categoryField = "semana";
	chart.plotAreaBorderAlpha = 0.2;
	chart.rotate = true;
	chart.depth3D = 15;
	chart.angle = 30;
	

	// AXES
	// Category
	var categoryAxis = chart.categoryAxis;
	categoryAxis.gridAlpha = 0.1;
	categoryAxis.axisAlpha = 0;
	categoryAxis.gridPosition = "start";
	categoryAxis.labelRotation = 45;

	// value
	var valueAxis = new AmCharts.ValueAxis();
	valueAxis.stackType = "regular";
	valueAxis.gridAlpha = 0.1;
	valueAxis.axisAlpha = 0;
	chart.addValueAxis(valueAxis);

	// GRAPHS
	// firstgraph
	var graph = new AmCharts.AmGraph();
	graph.title = "Finalizadas";
	graph.labelText = "[[value]]";
	graph.valueField = "finalizadas";
	graph.type = "column";
	graph.lineAlpha = 0;
	graph.fillAlphas = 1;
	graph.lineColor = "#28E141";
	graph.balloonText = "<b><span style='color:#28E141'>[[category]]</b></span><br><span style='font-size:14px'>[[title]]: <b>[[value]]</b></span>";
	graph.labelPosition = "middle";
	chart.addGraph(graph);

	// second graph
	graph = new AmCharts.AmGraph();
	graph.title = "Pendientes";
	graph.labelText = "[[value]]";
	graph.valueField = "pendientes";
	graph.type = "column";
	graph.lineAlpha = 0;
	graph.fillAlphas = 1;
	graph.lineColor = "#6691E7";
	graph.balloonText = "<b><span style='color:#6691E7'>[[category]]</b></span><br><span style='font-size:14px'>[[title]]: <b>[[value]]</b></span>";
	graph.labelPosition = "middle";
	chart.addGraph(graph);

	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.position = "right";
	legend.borderAlpha = 0.3;
	legend.horizontalGap = 10;
	legend.switchType = "x";
	chart.addLegend(legend);

	chart.creditsPosition = "top-right";

	// WRITE
	chart.write("chartdiv");
});
</script>
<?php } ?>
<?php if ($tipografica == 3){ ?>
<?php
$paretosanno = $querys->paretosanno($anno,$usuario);
$cant = count($paretosanno);
$texto2 = 'Total de paretos: '.$cant;
?>

<!--INICIO OPCION 3 -->
<script>
var chart;
var chartData = [
	<?php foreach($paretosanno as $pmes){ ?>
	<?php
	$idpareto = $pmes['id'];
	$cant1 = 0;
	$cant2 = 0;
	$actividades = $querys->actividadestodas($idpareto);
	$cant1 = count($actividades);
	$completas = $querys->actividadescompletas($idpareto,'1');
	$cant2 = count($completas);
	$restantes = ($cant1 - $cant2);
	?>
	{
		"semana": "<?php echo $pmes['fecha_inicial'].' / '.$pmes['fecha_final'];?>",
		"finalizadas": <?php echo $cant2;?>,
		"pendientes": <?php echo $restantes;?>,
	},
	<?php } ?>
];

AmCharts.ready(function () {
	// SERIALL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	chart.categoryField = "semana";
	chart.plotAreaBorderAlpha = 0.2;
	chart.rotate = true;
	chart.depth3D = 15;
	chart.angle = 30;
	

	// AXES
	// Category
	var categoryAxis = chart.categoryAxis;
	categoryAxis.gridAlpha = 0.1;
	categoryAxis.axisAlpha = 0;
	categoryAxis.gridPosition = "start";
	categoryAxis.labelRotation = 45;

	// value
	var valueAxis = new AmCharts.ValueAxis();
	valueAxis.stackType = "regular";
	valueAxis.gridAlpha = 0.1;
	valueAxis.axisAlpha = 0;
	chart.addValueAxis(valueAxis);

	// GRAPHS
	// firstgraph
	var graph = new AmCharts.AmGraph();
	graph.title = "Finalizadas";
	graph.labelText = "[[value]]";
	graph.valueField = "finalizadas";
	graph.type = "column";
	graph.lineAlpha = 0;
	graph.fillAlphas = 1;
	graph.lineColor = "#28E141";
	graph.balloonText = "<b><span style='color:#28E141'>[[category]]</b></span><br><span style='font-size:14px'>[[title]]: <b>[[value]]</b></span>";
	graph.labelPosition = "middle";
	chart.addGraph(graph);

	// second graph
	graph = new AmCharts.AmGraph();
	graph.title = "Pendientes";
	graph.labelText = "[[value]]";
	graph.valueField = "pendientes";
	graph.type = "column";
	graph.lineAlpha = 0;
	graph.fillAlphas = 1;
	graph.lineColor = "#6691E7";
	graph.balloonText = "<b><span style='color:#6691E7'>[[category]]</b></span><br><span style='font-size:14px'>[[title]]: <b>[[value]]</b></span>";
	graph.labelPosition = "middle";
	chart.addGraph(graph);

	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.position = "right";
	legend.borderAlpha = 0.3;
	legend.horizontalGap = 10;
	legend.switchType = "x";
	chart.addLegend(legend);

	chart.creditsPosition = "top-right";

	// WRITE
	chart.write("chartdiv");
});


</script>
<!--FIN OPCION3-->
<?php } ?>
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
            <h4 class="page-header"><i class="fa fa-icon_document_alt"></i>
			Grafica Reporte <?php echo $tipo;?><br/>
			<?php echo $texto;?><br/>
			Usuario: <?php echo $nombreusuario;?>
			</h4>
			<h5><a href="reporte_usuario.php"><button class="btn btn-success">Volver</button></a></h5>
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
				<header><?php echo $texto2;?></header>
                <div id="chartdiv" style="width: 100%; height: 400px;"></div>
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
