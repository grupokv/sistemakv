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
$idus = $_SESSION['idus'];
$pareto=$querys->pareto_activo($idus,$fecha);
$cantidad = count($pareto);
$idpareto = $pareto[0]['id'];
$fechainicial = strtotime ( '+7 day' , strtotime ( $pareto[0]['fecha_inicial'] ) );
$fechainicial = date ( 'Y-m-d' , $fechainicial );
$fechafinal = strtotime ( '+7 day' , strtotime ( $pareto[0]['fecha_final'] ) ) ;
$fechafinal = date ( 'Y-m-d' , $fechafinal );

$actividades = array();
$cons = new base_datos;
$cons->connect();
$sql = "SELECT * FROM pareto_actividades WHERE id_padre = 0 AND activo = 'A' AND id_usuario = '$idus' AND (fecha BETWEEN '$fechainicial' AND '$fechafinal') ORDER BY id_tipoactividad ASC, fecha DESC";
$res = $cons->query($sql);

while($item = $cons->fetch_row($res))	{
	array_push($actividades,$item);
}

$cant1 = count($actividades);

?>

<!DOCTYPE html>
<html lang="es">
<?php include('head.php');?>
<script>
function modal(id){
	$('.modal-body').load('contenido_modal.php?id='+id,function(){
		$('#myModal').modal({show:true});
	});
}
</script>
<script>
function valor(id,campo){
	//alert(id);
	if(document.getElementById(campo).checked==true){
		var parametros = {
                "id" : id,
				"estado" : 1
        };
		$.ajax({
                data:  parametros,
                url:   'act_estado.php',
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
	} else {
		var parametros = {
                "id" : id,
				"estado" : 0
        };
		$.ajax({
                data:  parametros,
                url:   'act_estado.php',
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

	<?php include('header.php'); ?>

    <?php include('menu.php');?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-icon_document_alt"></i> Pareto Siguiente Semana</h3>
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
			                <header align="right"><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
                          <a href="nueva_actividad.php"><button class="btn btn-success">Agregar</button></a>
    				              <a href="pareto_activo.php"><button class="btn btn-primary">Pareto Actual</button></a>
                      </header>   
                      <?php 
                        $i = 1; 
                        $a = 0; 
                      ?>
                      <?php foreach($actividades as $act){ ?>
                        <?php if($i == 1){ ?>
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th colspan="5">
                                    <b>
                                      <?php 
                                        $det_tipo = $querys->tiposactid($act['id_tipoactividad']); 
                                        echo $det_tipo[0]['detalle'];
                                      ?>
                                    </b>
                                  </th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                              </thead>
                              
                              <tbody>
                        <?php } ?>
                        
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $act['descripcion'];?></td>
                                <td><?php echo $act['fecha'];?></td>
                                <td>
                                  <label class="switch">
                                    <input type="checkbox" value="<?php echo $act['id'];?>" id="<?php echo $act['id'];?>" 
                                    onclick="valor(this.value,this.id)" <?php if ($act['estado'] == 1){ ?> checked="checked" <?php } ?>
                                    <?php $sub = $querys->actividadespadre($act['id']); if (count($sub) > 0 ){ ?> disabled="disabled" <?php } ?> >
                                    <span class="slider round"></span>
                                  </label>
                                </td>
                                <td>
                                    <?php if (count($sub) < 1 ){ ?>
                                      <?php if ($act['estado'] == 0){ ?>
                                        <a href="editar_actividad.php?id=<?php echo $act['id'];?>">
                                          <button class="btn btn-primary btn-xs">Editar</button>
                                        </a>
                                        <a href="eliminar_actividad.php?id=<?php echo $act['id'];?>">
                                          <button class="btn btn-danger btn-xs">Eliminar</button>
                                        </a>
                                      <?php } ?>
                                    <?php } ?>
                                    <button type="button" class="btn btn-success btn-xs" onclick="modal('<?php echo $act["id"];?>')"><b>+</b></button>
                                </td>
                            </tr>
                        
                        <?php if($i == $conteo[$a]['total']){ ?>
                              </tbody>
                            </table>
                          </div>
                        <?php 
                            $a++; 
                            $i = 0; 
                        } ?>
                        <?php $i++; } ?>

                      <?php 
                        $cat = ''; 
                        $i = 1;
                      ?>

			  			
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
					<h4 class="modal-title">ACTIVIDADES INTERNAS</h4>
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
